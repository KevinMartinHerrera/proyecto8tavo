<?php

namespace App\Http\Controllers;

use App\Models\Carpeta;
use App\Models\Caso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CasoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $casos = Caso::all();
        return view('admin.casos.index', compact('casos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todos los usuarios con roles de 'abogados' y 'clientes'
        $abogados = User::role('abogados')->get();
        $clientes = User::role('clientes')->get();

        return view('admin.casos.create', compact('abogados', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'numero_caso' => 'required|string',
            'fecha_apertura' => 'required|date',
            'descripcion' => 'required|string',
            'tipo_caso' => 'required|string',
            'estado' => 'required|string',
            'numero_expediente' => 'required|string',
            'abogado_id' => 'required|exists:users,id',
            'cliente_id' => 'required|exists:users,id',
            'fecha_cierre' => 'nullable|date',
        ]);
    
        // Obtener el user_id del usuario autenticado
        $id_user = Auth::user()->id;
    
        // Crear una carpeta asociada al usuario actual
        $carpeta = new Carpeta();
        $carpeta->user_id = $id_user;
        $carpeta->nombre = 'Caso ' . $request->input('numero_caso');
        $carpeta->save();
    
        // Crear un nuevo caso en la base de datos
        Caso::create([
            'numero_caso' => $request->numero_caso,
            'fecha_apertura' => $request->fecha_apertura,
            'descripcion' => $request->descripcion,
            'tipo_caso' => $request->tipo_caso,
            'estado' => $request->estado,
            'fecha_cierre' => $request->fecha_cierre,
            'numero_expediente' => $request->numero_expediente,
            'abogado_id' => $request->abogado_id,
            'cliente_id' => $request->cliente_id,
            'carpeta_id' => $carpeta->id,
        ]);
    
        // Redireccionar a la página de índice de casos u otra vista según tu flujo
        return redirect()->route('casos.index')
        ->with('mensaje','el caso se ha creado de la manera correcta')
        ->with('icono','success');
    }
    




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $caso = Caso::findOrFail($id);
        return view('admin.casos.update', compact('caso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'numero_caso' => 'required|string|max:255',
            'fecha_cierre' => 'nullable|date',
            'descripcion' => 'required|string',
            'tipo_caso' => 'required|string|max:255',
            'estado' => 'required|string|in:Abierto,En proceso,Cerrado,Archivado',
            'numero_expediente' => 'required|string|max:255',
        ]);

        // Buscar el caso por su ID
        $caso = Caso::findOrFail($id);

        // Actualizar los campos del caso con los datos del formulario
        $caso->numero_caso = $request->numero_caso;
        $caso->fecha_cierre = $request->fecha_cierre;
        $caso->descripcion = $request->descripcion;
        $caso->tipo_caso = $request->tipo_caso;
        $caso->estado = $request->estado;
        $caso->numero_expediente = $request->numero_expediente;

        // Guardar el caso actualizado en la base de datos
        $caso->save();

        // Redireccionar a la vista de detalles del caso o a donde desees
        return redirect()->route('casos.index')
        ->with('mensaje','El caso ha sido actualizado correctamente.a')
        ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscar el caso por su caso_id
        $caso = Caso::findOrFail($id);
    
        // Obtener la carpeta asociada al caso
        $carpeta = Carpeta::find($caso->carpeta_id);
    
        // Eliminar el caso
        $caso->delete();
    
        // Comprobar si la carpeta no tiene otros casos asociados y eliminarla si está vacía
        if ($carpeta && $carpeta->casos()->count() == 0) {
            $carpeta->delete();
        }
    
        // Redireccionar a la página de índice de casos con un mensaje de éxito
        return redirect()->route('casos.index')
            ->with('mensaje', 'Caso eliminado correctamente.')
            ->with('icono', 'success');
    }
    
    

}
