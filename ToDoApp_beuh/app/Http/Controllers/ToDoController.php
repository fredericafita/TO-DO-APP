<?php

namespace App\Http\Controllers;

use App\Models\ToDo;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    // Tampilkan semua data ToDo
    public function index()
    {
        $todos = ToDo::orderBy('created_at', 'desc')->get();
        return view('todos.index', compact('todos'));
    }

    // Form tambah ToDo
    public function create()
    {
        return view('todos.create');
    }

    // Simpan ToDo ke DB
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        ToDo::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_done' => $request->has('is_done'),
            'completed_at' => $request->has('is_done') ? now() : null,
        ]);

        return redirect()->route('todos.index')->with('success', 'ToDo berhasil ditambahkan!');
    }

    // Menandai selesai
    public function complete($id)
    {
        $todo = ToDo::findOrFail($id);
        $todo->is_done = true;
        $todo->completed_at = now();
        $todo->save();

        return redirect()->back()->with('success', 'ToDo selesai!');
    }

    // Hapus ToDo
    public function destroy($id)
    {
        ToDo::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'ToDo dihapus!');
    }
}
