<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Iletisimmodel;

class Iletisim extends Controller
{
    public function index(){
        return view("iletisim");
    }

    public function ekleme(Request $bilgiler){
        $adsoyad =$bilgiler->adsoyad;
        $telefon =$bilgiler->telefon;
        $mail =$bilgiler->mail;
        $metin =$bilgiler->metin;
        
        Iletisimmodel::create([
            "adsoyad"=>$adsoyad,
            "telefon"=>$telefon,
            "mail"=>$mail,
            "metin"=>$metin,
        ]);
        echo "Bilgileriniz Kaydedildi";
        
    }
}
