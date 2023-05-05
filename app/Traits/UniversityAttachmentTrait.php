<?php


namespace App\Traits;


use App\Models\Classe;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UniversityAttachmentTrait
{

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
