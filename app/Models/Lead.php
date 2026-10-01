<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'name', 'email', 'company', 'budget', 'services', 'message', 'status', 'notes', 'ip_address'])]
class Lead extends Model
{
    public const STATUSES = [
        'new' => 'New',
        'contacted' => 'Contacted',
        'qualified' => 'Qualified',
        'won' => 'Won',
        'lost' => 'Lost',
        'spam' => 'Spam',
    ];

    protected function casts(): array
    {
        return ['services' => 'array'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function serviceTitles(): array
    {
        return collect($this->services ?? [])
            ->map(fn ($slug) => config("agency.services.$slug.title", $slug))
            ->all();
    }

    public function budgetLabel(): ?string
    {
        return $this->budget ? config('agency.budgets.'.$this->budget, $this->budget) : null;
    }
}
