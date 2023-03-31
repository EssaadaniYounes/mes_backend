<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable =[
        'post_id',
        'files',
        'post_type'
    ];

    protected $appends = ['type'];
    public function basePost():BelongsTo{
        return $this->belongsTo(BasePost::class);
    }
    public function getTypeAttribute() : string
    {
        return 'post';
    }
}
