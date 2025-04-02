<?php
namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index()
    {
        $boards = Board::all();
        return view('admin.boards.index', compact('boards'));
    }

/*     public function create()
    {
        return view('admin.boards.create');
    }
 */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Board::create($request->all());

        return redirect()->route('boards.index')
        ->with('mensaje','el tablero se ha creado de la manera correcta')
        ->with('icono','success');
    }

    public function show(Board $board)
    {
        $board->load('tasks');
        $users = User::all();
        return view('admin.boards.show', compact('board','users'));
    }

/*     public function edit(Board $board)
    {
        return view('admin.boards.edit', compact('board'));
    } */

    public function update(Request $request, Board $board)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $board->update($request->all());

        return redirect()->route('boards.index')
        ->with('mensaje','el tablero se ha aactualizado de la manera correcta')
        ->with('icono','success');
    }

    public function destroy(Board $board)
    {
        $board->delete();

        return redirect()->route('boards.index')
        ->with('mensaje', 'Tablero eliminado correctamente.')
        ->with('icono', 'success');
    }
}

