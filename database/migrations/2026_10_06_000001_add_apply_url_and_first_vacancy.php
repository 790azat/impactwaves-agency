<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * An optional external posting (for example LinkedIn) per vacancy, and the
     * first open role from the client's careers document.
     */
    public function up(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->string('apply_url', 300)->nullable()->after('salary');
        });

        if (DB::table('vacancies')->where('slug', 'senior-media-buyer')->doesntExist()) {
            DB::table('vacancies')->insert([
                'slug' => 'senior-media-buyer',
                'title' => 'Senior Media Buyer',
                'department' => 'media-buying',
                'location' => 'Remote',
                'employment_type' => 'Full-time',
                'apply_url' => 'https://www.linkedin.com/jobs/view/4420726270/',
                'summary' => 'You will own campaigns end to end, from the first idea to scaling what works.',
                'body' => implode("\n", [
                    '## What you will do',
                    '',
                    '- **Research:** audiences, market trends, competitors and media platforms',
                    '- **Creatives:** work with our creative team on ad copy, visuals and video',
                    '- **Launch:** set up and deploy campaigns with proper tracking',
                    '- **Optimization:** monitor performance and adjust targeting, bidding and creatives to maximize ROI',
                    '- **Scale:** grow reach and spend while keeping campaigns efficient and profitable',
                    '',
                    '## What we offer',
                    '',
                    'Profit-based compensation that grows with your results.',
                ]),
                'published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropColumn('apply_url');
        });
    }
};
