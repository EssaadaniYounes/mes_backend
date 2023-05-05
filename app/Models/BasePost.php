<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BasePost extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function announcement(): HasOne
    {
        return $this->hasOne(Announcement::class);
    }
    public function post(): HasOne
    {
        return $this->hasOne(Post::class);
    }
    public function event(): HasOne
    {
        return $this->hasOne(Event::class);
    }
}
