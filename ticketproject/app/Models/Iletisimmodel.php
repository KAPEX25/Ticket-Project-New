<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iletisimmodel extends Model
{
    protected $table ="iletisim";
    protected $fillable=["adsoyad", "mail", "telefon", "metin", "create_at", "updated_at"];
}
