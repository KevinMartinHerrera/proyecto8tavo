<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::with('roles')->get();

        return view('admin.usuarios.index',['usuarios'=>$usuarios]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = ModelsRole::all();

        return view('admin.usuarios.create', compact('roles')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
/*         $datos = request()->all();
        return response()->json($datos); */

        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request['password']);
        $usuario->save();

        // Asignar el rol seleccionado al usuario
        $usuario->assignRole($request->role);

        return redirect()->route('usuario.index')
            ->with('mensaje','Se registro al usuario de la manera correcta')
            ->with('icono','success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $usuario = User::findOrFail($id);
        return view ('admin.usuarios.edit',['usuario'=>$usuario]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);
    
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|unique:users,email,'.$usuario->id,
            'password' => 'nullable|confirmed',
        ]);
    
        // Actualizar solo los campos que se han enviado en la solicitud
        if ($request->filled('name')) {
            $usuario->name = $request->name;
        }
    
        if ($request->filled('email')) {
            $usuario->email = $request->email;
        }
    
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }
    
        $usuario->save();
    
        return redirect()->route('usuario.index')
            ->with('mensaje', 'Se actualizó al usuario de manera correcta')
            ->with('icono', 'success');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('usuario.index')
            ->with('mensaje','Se eliminó al usuario de la manera correcta')
            ->with('icono','success');
    }
}
