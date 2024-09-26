<?php

use Illuminate\Support\Facades\Route;
use App\Models\User; // Importamos correctamente el modelo User

Route::get('/', function () {
    $users = User::all(); // Usamos el espacio de nombres correcto
    return view('welcome', ['users' => $users]); // Pasamos los datos a la vista correctamente
});

Route::get('profiles/{id}', function ($id) {
    $user = User::find($id);
    
    $posts   = $user->posts()->withCount('comments')->get(); // Obtenemos los posts con el conteo de comentarios
    $videos  = $user->videos()->withCount('comments')->get(); // Obtenemos los videos con el conteo de comentarios

    return view('profile', [
        'user' => $user,
        'posts' => $posts,
        'videos' => $videos // Corregimos la sintaxis del array
    ]);
})->name('profile');
