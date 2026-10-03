<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SectionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_is_hidden_until_an_admin_switches_it_on(): void
    {
        $this->get('/news')->assertNotFound();
        $this->get('/news/impact-waves-launches-new-website-and-guides')->assertNotFound();
        $this->get('/')->assertDontSee('href="'.route('section', 'news').'"', false);
        $this->get('/sitemap.xml')->assertDontSee('/news');

        $admin = tap(User::factory()->create(), fn ($u) => $u->forceFill(['is_admin' => true])->save());
        $this->actingAs($admin)->get('/admin/articles')->assertOk()->assertSee('News section');
        $this->actingAs($admin)->put('/admin/sections/news', ['enabled' => 1])->assertRedirect();

        $this->get('/news')->assertOk();
        $this->get('/news/impact-waves-launches-new-website-and-guides')->assertOk();
        $this->get('/sitemap.xml')->assertSee('/news');

        $this->actingAs($admin)->put('/admin/sections/news', ['enabled' => 0]);
        $this->get('/news')->assertNotFound();
    }
}
