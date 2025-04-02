<?php

namespace App\Http\Controllers;

use App\Models\Carpeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarpetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_user = Auth::user()->id;
        $carpetas = Carpeta::whereNull('carpeta_padre_id')
                            ->where('user_id',$id_user)
                            ->get();
        /* $carpetas = Carpeta::whereNull('carpeta_padre_id')->get(); */


        return view('admin.gestion_de_archivos.index',['carpetas'=>$carpetas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
    
        // Crear una nueva carpeta
        $carpeta = new Carpeta();
        $carpeta->nombre = $request->nombre;
        $carpeta->user_id = $request->user_id;
        // Si hay un campo para carpeta padre, asegúrate de manejarlo también
        // $carpeta->carpeta_padre_id = $request->carpeta_padre_id; // Opcional, si tienes carpetas anidadas
        $carpeta->save();
    
        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->route('carpetas.index')
        ->with('mensaje','Se creo la carpeta de la manera correcta')
        ->with('icono','success');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $carpeta= Carpeta::findOrFail($id);
        $subcarpetas= $carpeta->carpetasHijas;
        $archivos =$carpeta->archivos;
    
        return view('admin.gestion_de_archivos.show', compact('carpeta','subcarpetas','archivos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:191'
        ]);
    
        $id = $request->id;
        $carpeta = Carpeta::find($id);
    
        if (!$carpeta) {
            return redirect()->back()
                ->with('mensaje', 'No se encontró la carpeta')
                ->with('icono', 'error');
        }
    
        $carpeta->nombre = $request->nombre;
        $carpeta->save();
    
        return redirect()->back()
            ->with('mensaje', 'Se actualizó la carpeta con éxito')
            ->with('icono', 'success');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Carpeta::destroy($id);
        Storage::deleteDirectory($id);
        Storage::deleteDirectory('public/'.$id);

        return redirect()->back()
        ->with('mensaje','Se eliminó la carpeta de la manera correcta')
        ->with('icono','success');

        
    }

    public function crear_subcarpeta(Request $request){
        $request->validate([
            'nombre' => 'required|string|max:255',
            'carpeta_padre_id'=> 'required'
        ]);
    
        // Crear una nueva carpeta
        $carpeta = new Carpeta();
        $carpeta->nombre = $request->nombre;
        $carpeta->user_id = $request->user_id;
        // Si hay un campo para carpeta padre, asegúrate de manejarlo también
        $carpeta->carpeta_padre_id = $request->carpeta_padre_id; // Opcional, si tienes carpetas anidadas
        $carpeta->save();
    
        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->back()
        ->with('mensaje','Se creo la carpeta de la manera correcta')
        ->with('icono','success'); 
    }
}
