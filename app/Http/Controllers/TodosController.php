<?php

namespace App\Http\Controllers;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    public function index()
    {
        $todos = Todo::all(); // Fetch todos from database
        
        return view('todos.index', compact('todos')); // Pass to view
    }
    public function create(){
        return view('todos.create');
    }
    public function store(Request $request){
    $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable',
    ]);

    Todo::create([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    return redirect()->route('todos.index');
}
   public function edit(Todo $todo){
    return view('todos.edit', compact('todo'));
   }

   public function update(Request $request, Todo $todo){
    $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable',
    ]);

    $todo->update([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    return redirect()->route('todos.index');
   }

  public function destroy(Todo $todo)
{
    $todo->delete();

    return redirect()->route('todos.index');
}

public function complete(Todo $todo)
{
    $todo->update([
        'completed' => !$todo->completed,
    ]);

    return redirect()->route('todos.index');
}

}