<?php


namespace App\Services;
use Illuminate\Http\Request;

class UploadFile
{
    public $path;
    public $fileHeader;
    public function __construct(string $path, string $fileHeader)
    {
        $this->path = $path;
        $this->fileHeader = $fileHeader;
    }

    public function uploadSingle(Request $request): string
    {
        if($request->hasFile($this->fileHeader)){
            $file = $request->file($this->fileHeader);
            return  'storage/'.$file->store($this->path);
        }
    }
    public function uploadMany($files)
    {
        $storedFiles = [];

        foreach ($files as $file) {
            $storedFile = 'storage/'.$file->store($this->path);
            array_push($storedFiles, $storedFile);
        }
        return $storedFiles;
    }
}
