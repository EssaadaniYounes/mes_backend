<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasseAnnouncement extends Model
{
    use HasFactory;
    protected $fillable = [
        'announcement_id',
        'classe_id'
    ];

    public $timestamps = false;
}
