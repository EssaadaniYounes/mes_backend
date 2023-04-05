<?php

namespace App\Models;

use App\Traits\BasePostTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory, BasePostTrait;

    public $timestamps = false;

    protected $fillable = [
        'base_post_id'
    ];
    protected $appends = ['type'];


}
