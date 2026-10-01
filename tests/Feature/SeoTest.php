<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoTest extends TestCase
{
    public function test_public_domain_is_indexable_with_canonical_urls(): void
    {
        config(['agency.site_url' => 'https://impactwaves.agency']);

        $this->get('https://impactwaves.agency/services/ppc')
            ->assertSee('<link rel="canonical" href="https://impactwaves.agency/services/ppc">', false)
            ->assertSee('index, follow', false)
            ->assertSee('"@type":"Service"', false)
            ->assertSee('BreadcrumbList');

        $this->get('https://impactwaves.agency/robots.txt')->assertSee('Sitemap: https://impactwaves.agency/sitemap.xml')->assertSee('Disallow: /admin');
    }

    public function test_other_hosts_are_not_indexed_but_point_to_the_public_domain(): void
    {
        config(['agency.site_url' => 'https://impactwaves.agency']);

        $this->get('https://impactwaves-agency.vercel.app/about')
            ->assertSee('noindex, nofollow', false)
            ->assertSee('<link rel="canonical" href="https://impactwaves.agency/about">', false);

        $this->get('https://impactwaves-agency.vercel.app/robots.txt')->assertSee("Disallow: /\n", false);
        $this->get('https://impactwaves-agency.vercel.app/sitemap.xml')->assertSee('<loc>https://impactwaves.agency/careers</loc>', false)->assertDontSee('vercel.app');
    }

    public function test_home_has_website_and_organization_schema(): void
    {
        $this->get('/')->assertSee('"@type":"WebSite"', false)->assertSee('"@type":"Organization"', false);
    }
}
