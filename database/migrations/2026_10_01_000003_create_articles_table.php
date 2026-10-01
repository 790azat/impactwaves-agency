<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Articles written or edited in the admin panel. A row with the same
     * section and slug as a Markdown file in resources/content overrides it;
     * an unpublished row hides it.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('section', 40);
            $table->string('slug', 120);
            $table->string('title');
            $table->string('description', 500)->nullable();
            $table->string('keywords', 500)->nullable();
            $table->string('tag', 60)->nullable();
            $table->string('author', 120)->nullable();
            $table->longText('body');
            $table->boolean('published')->default(true);
            $table->date('published_on');
            $table->timestamps();
            $table->unique(['section', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
