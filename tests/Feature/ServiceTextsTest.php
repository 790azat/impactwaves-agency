<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTextsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_edits_service_text_and_can_restore_it(): void
    {
        $admin = tap(User::factory()->create(), fn ($u) => $u->forceFill(['is_admin' => true])->save());

        $this->actingAs($admin)->get('/admin/services/ppc')->assertOk();
        $this->actingAs($admin)->put('/admin/services/ppc', [
            'title' => 'PPC Advertising',
            'eyebrow' => 'Search',
            'short' => 'New short text.',
            'headline' => 'A brand new PPC headline',
            'intro' => 'New intro.',
            'platforms' => 'Google Ads, Bing',
            'features' => [['title' => 'Point one', 'text' => 'Text one'], ['title' => '', 'text' => 'dropped']],
        ])->assertRedirect('/admin/services/ppc');

        $this->get('/services/ppc')->assertSee('A brand new PPC headline')->assertSee('Point one')->assertDontSee('dropped')->assertSee('Bing');
        $this->get('/services')->assertSee('New short text.');
        $this->actingAs($admin)->get('/admin/services')->assertOk()->assertSee('Edited');

        $this->actingAs($admin)->delete('/admin/services/ppc');
        $this->get('/services/ppc')->assertDontSee('A brand new PPC headline')->assertSee('Query hygiene');
    }
}
