<?php

namespace App\Models;

use App\Services\UploadFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class TimeTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'classe_id'
    ];

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }


    public static function uploadTimeTable(Request $request): string
    {
        return (
                new UploadFile('pdfs/timetables','file')
                    )->uploadSingle($request);

    }
}
