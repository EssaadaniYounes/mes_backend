<?php

namespace App\Models;

use App\Services\UploadFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'result',
        'classe_id'
    ];

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }


    public static function uploadTimeTable(Request $request): string
    {
        return (
        new UploadFile('pdfs/results','file')
        )->uploadSingle($request);

    }
}
