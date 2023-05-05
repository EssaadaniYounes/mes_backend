<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;
    protected $fillable = [
        'started_by',
        'second_user'
    ];

    public function startedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'started_by');
    }

    /**
     * Get the user who is the second participant in the conversation.
     */
    public function secondUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'second_user');
    }
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
    /**
     * Get all the conversations that the given user is joined to.
     */
    public function markRead()
    {
        $this->messages()
            ->where('is_seen', false)
            ->update([
                'is_seen' => true,
            ]);
    }
}
