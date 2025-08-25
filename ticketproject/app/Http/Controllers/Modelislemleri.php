<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bilgiler;

class Modelislemleri extends Controller
{
    public function liste(){
        //$bilgi=Bilgiler::whereId(2)->first();
        $bilgi=Bilgiler::find(2);

        echo $bilgi->metin;
    }

    public function ekle(){
        Bilgiler::create([
            "metin"=>"ModelEkle",
        ]);
    }

    public function guncelle(){
        Bilgiler::whereId(4)->update([
            "metin"=>"ModelEklyerdfg",
        ]);
    }

    public function delete(){
        Bilgiler::whereId(4)->delete();
    }
}
