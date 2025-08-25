<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bilgiler extends Model
{
    protected $table = 'bilgiler';
    protected $fillable = ["metin","created_at", "updated_at"];
}
