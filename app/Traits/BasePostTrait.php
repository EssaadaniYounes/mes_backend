<?php


namespace App\Traits;


use App\Models\BasePost;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BasePostTrait
{
    public function basePost():BelongsTo{
        return $this->belongsTo(BasePost::class);
    }
    public function getTypeAttribute() : string
    {
        return strtolower(class_basename($this));

    }
}
