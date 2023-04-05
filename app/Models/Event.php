<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'base_post_id',
        'files',
        'event_date',
        'event_type'
    ];
    protected $appends = ['type'];
    public function basePost(): BelongsTo{
        return $this->belongsTo(BasePost::class);
    }
    public function getTypeAttribute() : string
    {
        return 'event';
    }
}
