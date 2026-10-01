<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['section', 'slug', 'title', 'description', 'keywords', 'tag', 'author', 'body', 'published', 'published_on'])]
class Article extends Model
{
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'published_on' => 'date',
        ];
    }
}
