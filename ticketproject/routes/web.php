<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ornek;
use App\Http\Controllers\Dashyonetim;
use App\Http\Controllers\Formyonet;
use App\Http\Controllers\Veritabaniislem;
Route::get('/', function () {
    return view('welcome');
});

//Route::get('/deneme', function (){
//    return view('deneme');
//});

Route::get("/phpturkey/{isim}", [Ornek::class,'test']);

Route::get("/dashboard",[Dashyonetim::class,'site'])->name("mainweb");

Route::get("/form", [Formyonet::class, 'gorunum']);

Route::middleware('arakontrol')->post("/form-sonuc", [Formyonet::class, 'sonuc'])->name('sonuc');

Route::get("/ekle", [Veritabaniislem::class, 'ekle']);

Route::get("/duzenle", [Veritabaniislem::class, 'guncelle']);

Route::get("/delete", [Veritabaniislem::class, 'delete']);

Route::get("/listele",[Veritabaniislem::class, 'bilgiler']);