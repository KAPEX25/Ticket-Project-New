<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashyonetim extends Controller
{
    public function site(){
        $data["yazi1"]="PHP Turkiye";
        $data["yazi2"]="Hoşgeldiniz";
        $data["yazi3"]="Hizmetlerimiz";
        $data["yazi4"]="Web Tasarımı ve yazılım Hizmetleri";
        $data["yazi5"]="Bize Ulaşın";
        return view("dashboard",$data);
    }
}
