<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create()
    {
        $boards = Board::all();
        $users = User::all();
        return view('admin.tasks.create', compact('boards', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'board_id' => 'required',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        Task::create($data);

        return redirect()->route('boards.show', $request->board_id)
        ->with('mensaje','la tarea se ha creado de la manera correcta')
        ->with('icono','success');
    }

    public function edit(Task $task)
    {
        $boards = Board::all();
        $users = User::all();
        return view('admin.tasks.edit', compact('task', 'boards', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required',
            'board_id' => 'required',
        ]);

        $task->update($request->all());

        return redirect()->route('boards.show', $task->board_id);
    }
    public function moveTask(Task $task, Request $request)
    {
        $request->validate([
            'status' => 'required|in:todo,in_progress,done'
        ]);
    
        $task->update([
            'status' => $request->status
        ]);
    
        return response()->json(['message' => 'Tarea movida exitosamente']);
    }
    
    public function destroy(Task $task)
    {
        $boardId = $task->board_id;
        $task->delete();

        return redirect()->route('boards.show', $boardId)
        ->with('mensaje', 'tarea eliminada correctamente.')
        ->with('icono', 'success');
    }
}
