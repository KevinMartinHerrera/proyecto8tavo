@extends('layouts.admin')

@section('title')
<title>RMJuridico | Edit Task</title>
@endsection

@section('ruta')
  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('boards.index') }}">Boards</a></li>
  <li class="breadcrumb-item active">Edit Task</li> 
@endsection

@section('seccion')
  <h1 class="m-0">Edit Task</h1>
@endsection

@section('container')
<div class="container-fluid">
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Task Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $task->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="board_id">Board</label>
            <select class="form-control" id="board_id" name="board_id" required>
                @foreach($boards as $board)
                    <option value="{{ $board->id }}" {{ $board->id == $task->board_id ? 'selected' : '' }}>{{ $board->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="assigned_to">Assign To</label>
            <select class="form-control" id="assigned_to" name="assigned_to">
                <option value="">Unassigned</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $task->assigned_to ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Task</button>
    </form>
</div>
@endsection
