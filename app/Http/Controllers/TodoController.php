<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function dashboard()
    {
        return view('dashboard', [
            'tasks' => Todo::groupBy('task_status')->selectRaw('task_status, count(id) as task_count')->get()
        ]);
    }

    public function add(Request $request)
    {
        Todo::create([
            'title' => $request->title,
            'details' => $request->details,
            'assignee_id' => $request->assignee_id,
            'creator_id' => Auth::user()->id,
            'task_status' => 'created'
        ]);
        return redirect()->route('todo');
    }

    public function update(Request $request, $id)
    {
        Todo::where('id', $id)->update([
            'title' => $request->title,
            'details' => $request->details,
            'assignee_id' => $request->assignee_id,
            'task_status' => $request->task_status
        ]);
        return redirect()->route('view_todo', ['id' => $id]);
    }

    public function view(Request $request, $id)
    {
        return view('todo.view', [
            'users' => User::select('id', 'name')->get(),
            'task' => Todo::find($id)
        ]);
    }

    public function delete(Request $request, $id)
    {
        Todo::where('id', $id)->delete();
        return redirect()->route('todo');
    }

    public function todo()
    {
        return view('todo', [
            'my_task' => false,
            'users' => User::select('id', 'name')->get(),
            'tasks' => Todo::where('task_status', '!=', 'completed')->with('assignee')->paginate(10)
        ]);
    }

    public function myTodo()
    {
        return view('todo', [
            'my_task' => true,
            'users' => User::select('id', 'name')->get(),
            'tasks' => Todo::where('task_status', '!=', 'completed')->where('assignee_id', Auth::user()->id)->paginate(10)
        ]);
    }
}
