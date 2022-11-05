<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMethod extends Model
{
    use HasFactory;
    protected $fillable=[
        'init',
        'name',
        'company_id',
        'is_default'
    ];
}
