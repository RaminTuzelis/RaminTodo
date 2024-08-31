<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TodoController extends Controller
{
    public function index() {
        $todos = Todo::all();
        return Inertia::render('Todos/Index', [
            'todos' => $todos,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Todo::create($request->only('title'));
        return redirect()->back();
    }

    public function update(Request $request, Todo $todo) {
        $request->validate([
           'title' => 'required|string|max:255',
           'completed' => 'boolean',
        ]);

        $todo->update($request->only('title', 'completed'));
        return redirect()->route('todos.index');
    }

    public function destroy(Todo $todo) {
        $todo->delete();
        return redirect()->route('todos.index');
    }


}
