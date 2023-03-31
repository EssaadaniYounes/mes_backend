<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'base_post_id'
    ];
    protected $appends = ['type'];
    public function basePost():BelongsTo{
        return $this->belongsTo(BasePost::class);
    }
    public function getTypeAttribute() : string
    {
        return 'announcement';
    }

}
