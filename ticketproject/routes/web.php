<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('pages.welcometicket');
})->name("mainwelcome");

Route::get('/register', function () {
    if(auth()->check()){
        return redirect()->route("filament.admin.pages.dashboard");
    }else{
        return view('pages.mainregister');
    }
    
})->name("register");

Route::post('/register', function(Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);
    $user->assignRole('user');

    return redirect()->route('filament.admin.auth.login');
});
