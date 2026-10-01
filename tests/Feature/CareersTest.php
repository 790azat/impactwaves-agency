<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CareersTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return tap(User::factory()->create(), fn ($u) => $u->forceFill(['is_admin' => true])->save());
    }

    public function test_careers_page_shows_open_application_when_empty(): void
    {
        $this->get('/careers')->assertOk()->assertSee('No open roles right now')->assertSee('Media Buying');
    }

    public function test_admin_creates_vacancy_and_it_appears_on_the_site(): void
    {
        $this->actingAs($this->admin())->post('/admin/vacancies', [
            'title' => 'Senior Media Buyer (TikTok)',
            'department' => 'media-buying',
            'employment_type' => 'Full-time',
            'location' => 'Remote',
            'summary' => 'Scale TikTok campaigns.',
            'body' => "## What you will do\n- Launch campaigns",
            'published' => '1',
        ])->assertRedirect('/admin/vacancies/senior-media-buyer-tiktok/edit');

        $this->get('/careers')->assertSee('Senior Media Buyer (TikTok)')->assertSee('1 open role');
        $this->get('/careers/senior-media-buyer-tiktok')->assertOk()->assertSee('Launch campaigns', false)->assertSee('JobPosting');
        $this->get('/sitemap.xml')->assertSee('/careers/senior-media-buyer-tiktok');
    }

    public function test_hidden_vacancy_is_not_public(): void
    {
        Vacancy::create(['slug' => 'designer', 'title' => 'Designer', 'department' => 'design', 'employment_type' => 'Full-time', 'body' => 'x', 'published' => false]);

        $this->get('/careers/designer')->assertNotFound();
    }

    public function test_company_location_and_team_sizes_show_on_the_site(): void
    {
        $this->actingAs($this->admin())->put('/admin/company', [
            'location' => ['city' => 'Testville', 'country' => 'Testland', 'address' => '', 'note' => ''],
            'team' => ['media-buying' => ['size' => '12', 'visible' => '1'], 'recruiting' => ['size' => '', 'visible' => '0']],
        ])->assertRedirect();

        $this->get('/about')->assertSee('Testville, Testland')->assertSee('12')->assertDontSee('Recruiting &amp; HR', false);
        $this->get('/contact')->assertSee('Testville, Testland');
        $this->get('/')->assertSee('Headquartered in Testville, Testland');
    }

    public function test_non_admin_cannot_manage_vacancies(): void
    {
        $this->actingAs(User::factory()->create())->get('/admin/vacancies')->assertForbidden();
    }
}
