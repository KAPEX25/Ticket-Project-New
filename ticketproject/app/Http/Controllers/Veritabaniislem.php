<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class Veritabaniislem extends Controller
{
    public function ekle(){
        DB::table("bilgiler")->insert([
            "metin"=>"Örnek Metin"
        ]);
    }

    public function guncelle(){
        DB::table("bilgiler")->where("id",2)->update([
            "metin"=>"Örnek Metin 2s"
        ]);
    }

    public function delete(){
        DB::table("bilgiler")->where("id",1)->delete();
    }

    public function bilgiler(){
        /*$list=DB::table("bilgiler")->get();
        foreach ($list as $key => $bilgi) {
            echo $bilgi->metin."</br>";
        }*/
        $list=DB::table("bilgiler")->where("id", 2)->first();
        echo $list->metin;
    }
    

}
