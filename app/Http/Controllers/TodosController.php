<?php

namespace App\Http\Controllers;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodosController extends Controller
{
    public function index(Request $request){
    
    $search = $request->input('q');
    $status = $request->input('status');
    $order = $request->input('order');

    $todos = $request->user()->todos();

    if($search){
        $todos = $todos->search($search);
    }
    if($status){
         $todos = $todos->status($status);
    }

    if($order){
         $todos = $order->order($order);
    }

    $todos = $todos-> paginate(4);
    return view('todos.index', compact('todos'));
     
    }

    public function create(){
        return view('todos.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
    ]);

    $request->user()->todos()->create([
        'title' => $validated['title'],
        'description' => $validated['description'] ?? null,
    ]);

    return redirect()
        ->route('todos.index')
        ->with('success', 'Todo added successfully!');
}
   public function edit(Todo $todo){
    return view('todos.edit', compact('todo'));

   }

 public function update(Request $request, Todo $todo)
{
    $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable',
    ]);

    $todo->update([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    return redirect()
        ->route('todos.index')
        ->with('success', 'Todo updated successfully!');
}


public function complete(Todo $todo)
{
    if ($todo->completed) {
        return redirect()
            ->route('todos.index')
            ->with('error', 'This task is already completed.');
    }

    $todo->update([
        'completed' => true,
        'completed_at' => now(),
    ]);

    return redirect()
        ->route('todos.index')
        ->with('success', 'Todo completed successfully!');
}
    
public function destroy(Todo $todo)
{
    $todo->delete();

    return redirect()
        ->route('todos.index')
        ->with('success', 'Todo deleted successfully.');
}

}