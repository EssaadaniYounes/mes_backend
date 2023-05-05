<?php

namespace App\Models;

use App\Services\UploadFile;
use App\Traits\BasePostTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Post extends Model
{
    use HasFactory, BasePostTrait;

    protected $fillable =[
        'base_post_id',
        'files',
        'post_type'
    ];

    public $timestamps = false;

    protected $appends = ['type'];

    public static function upload($files)
    {
        return (new UploadFile('courses',''))->uploadMany($files);
    }


}
