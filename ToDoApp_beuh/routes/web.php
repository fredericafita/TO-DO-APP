<?php

use Illuminate\Support\Facades\Route;
use App\Models\ToDo;
use Illuminate\Http\Request;

// Halaman utama: tampilkan semua ToDo
Route::get('/', function () {
    $todos = ToDo::orderBy('created_at', 'desc')->get();
    return view('welcome', compact('todos'));
})->name('home');

// Menyimpan ToDo
Route::post('/store', function(Request $request) {
    $request->validate([
        'title' => 'required'
    ]);

    ToDo::create([
        'title' => $request->title,
        'description' => $request->description,
        'is_done' => $request->has('is_done'),
        'completed_at' => $request->has('is_done') ? now() : null,
    ]);

    return redirect()->route('home')->with('success', 'ToDo berhasil ditambahkan!');
})->name('store');

// Tandai selesai
Route::get('/complete/{id}', function($id) {
    $todo = ToDo::findOrFail($id);
    $todo->update([
        'is_done' => true,
        'completed_at' => now()
    ]);

    return redirect()->route('home');
})->name('complete');

// Hapus
Route::delete('/delete/{id}', function($id) {
    ToDo::destroy($id);
    return redirect()->route('home');
})->name('delete');
