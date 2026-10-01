<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['user_id', 'name', 'email', 'page_url', 'ip_address', 'last_message_at', 'admin_read_at'])]
class ChatConversation extends Model
{
    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
            'admin_read_at' => 'datetime',
        ];
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->oldest('id');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(ChatMessage::class)->latestOfMany();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isUnread(): bool
    {
        return $this->last_message_at && (! $this->admin_read_at || $this->admin_read_at->lt($this->last_message_at))
            && $this->latestMessage?->sender === 'visitor';
    }
}
