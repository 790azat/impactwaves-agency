<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['slug', 'title', 'department', 'location', 'employment_type', 'salary', 'summary', 'body', 'published'])]
class Vacancy extends Model
{
    protected function casts(): array
    {
        return ['published' => 'boolean'];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('published', true);
    }

    public function departmentTitle(): string
    {
        return config('agency.departments.'.$this->department.'.title', Str::headline($this->department));
    }

    public function html(): string
    {
        return Str::markdown($this->body, ['html_input' => 'strip', 'allow_unsafe_links' => false]);
    }

    /**
     * Published roles for the public site. Empty when there is no database.
     */
    public static function open()
    {
        try {
            return static::published()->latest()->get();
        } catch (\Throwable) {
            return collect();
        }
    }
}
