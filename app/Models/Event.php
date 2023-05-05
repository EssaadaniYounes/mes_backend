<?php

namespace App\Models;

use App\Services\UploadFile;
use App\Traits\BasePostTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Event extends Model
{
    use HasFactory,BasePostTrait;

    protected $fillable = [
        'base_post_id',
        'title',
        'thumbnail',
        'files',
        'event_date',
        'event_type'
    ];
    public static $filesPath = 'events';
    public $timestamps = false;

    protected $appends = ['type'];

    public static function uploadSingle(Request $request):string
    {
        return (
        new UploadFile(Event::$filesPath,'file')
        )->uploadSingle($request);

    }

    public static function upload($files)
    {
        return (new UploadFile(Event::$filesPath,''))->uploadMany($files);
    }

}
