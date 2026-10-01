<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Open roles shown on /careers, managed in Admin → Vacancies.
     */
    public function up(): void
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 120)->unique();
            $table->string('title');
            $table->string('department', 40);
            $table->string('location', 120)->nullable();
            $table->string('employment_type', 40)->default('Full-time');
            $table->string('salary', 120)->nullable();
            $table->string('summary', 500)->nullable();
            $table->longText('body');
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
