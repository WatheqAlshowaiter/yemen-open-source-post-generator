<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'forked_url',
        'original_url',
        'repo_name',
        'repo_description',
        'repo_tags',
        'author_name',
        'github_user_profile',
        'linkedin_profile',
        'facebook_profile',
        'twitter_profile',
        'author_website',
        'additional_links',
        'generated_content',
        'generated_title',
        'generated_tweet',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'additional_links' => 'array',
        'repo_tags' => 'array',
    ];
}
