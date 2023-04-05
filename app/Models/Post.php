<?php

namespace App\Models;

use App\Traits\BasePostTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory, BasePostTrait;

    protected $fillable =[
        'post_id',
        'files',
        'post_type'
    ];

    protected $appends = ['type'];

}
