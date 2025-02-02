<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('forked_url')->nullable();
            $table->string('original_url');
            $table->string('repo_description');
            $table->string('author_name');
            $table->string('github_user_profile')->nullable();
            $table->string('linkedin_profile')->nullable();
            $table->string('facebook_profile')->nullable();
            $table->string('twitter_profile')->nullable();
            $table->string('author_website')->nullable();
            $table->string('additional_links')->nullable();
            $table->text('generated_content')->nullable();
            $table->string('generated_title')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
