<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{

    public function upload(Request $request)  
    {
        // Validar el archivo
        $request->validate([
            'file' => 'required|file|max:10240', // tamaño máximo de 10MB
        ]);
    
        $id = $request->id;
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileName = time() . '-' . $originalName;
        
        // Almacenar el archivo DE MANERA PUBLICA
        /* $file->storeAs($id, $fileName, 'public'); */
        //ALMACENAR DE FORMA PRIVADA
        $request ->file('file')->storeAs($id,$fileName);
    
        // Crear nuevo registro en la base de datos
        $archivo = new Archivo();
        $archivo->carpeta_id = $id;
        $archivo->nombre = $fileName;
        $archivo->estado_archivo = 'PRIVADO';
        $archivo->save();
    
        return redirect()->back()
            ->with('mensaje', 'Se cargó el archivo correctamente')
            ->with('icono', 'success');
    }

    public function delete(Request $request){
        $id = $request->id;
        $archivo = Archivo::find($id);
        $estado_del_archivo = $archivo->estado_archivo;
        if($estado_del_archivo == 'PRIVADO'){
            Storage::delete($archivo->carpeta_id.'/'.$archivo->nombre);
        }else{
            Storage::delete('public/'.$archivo->carpeta_id.'/'.$archivo->nombre);
        }
        
        Archivo::destroy($id);
        return redirect()->back()
            ->with('mensaje','Se eliminó el archivo de la manera correcta')
            ->with('icono','success');

    }

    public function cambio_status_publico(Request $request)
    {
        $id = $request->id;
        $archivo = Archivo::find($id);
       
    
        if (!$archivo) {
            return redirect()->back()
                ->with('mensaje', 'Archivo no encontrado.')
                ->with('icono', 'error');
        }
        $carpeta_id = $archivo->carpeta_id;
        $nombre = $archivo->nombre;
        // Cambiar el estado del archivo
        if ($archivo->estado_archivo === 'PRIVADO') {
            $archivo->estado_archivo = 'PUBLICO';
        } else {
            $archivo->estado_archivo = 'PRIVADO';
        }
    
        $archivo->save();


        $ruta_archivo_privado= $carpeta_id.'/'.$nombre;

        $ruta_archivo_public= 'public'.'/'.$carpeta_id.'/'.$nombre;

        Storage::move($ruta_archivo_privado, $ruta_archivo_public);
    
        return redirect()->back()
        ->with('mensaje', 'Se cambió la privacidad del archivo a Público.')
        ->with('icono', 'success');
    }

    public function cambio_status_privado(Request $request)
    {
        $id = $request->id;
        $archivo = Archivo::find($id);
    
        if (!$archivo) {
            return redirect()->back()
                ->with('mensaje', 'Archivo no encontrado.')
                ->with('icono', 'error');
        }
    
        $carpeta_id = $archivo->carpeta_id;
        $nombre = $archivo->nombre;
    
        // Cambiar el estado del archivo
        if ($archivo->estado_archivo === 'PUBLICO') {
            $archivo->estado_archivo = 'PRIVADO';
        } else {
            $archivo->estado_archivo = 'PUBLICO';
        }
    
        $archivo->save();
    
        // Mover archivo en el almacenamiento
        $ruta_archivo_publico = 'public/' . $carpeta_id . '/' . $nombre;
        $ruta_archivo_privado =  $carpeta_id . '/' . $nombre;
    
        Storage::move($ruta_archivo_publico, $ruta_archivo_privado);
    
        return redirect()->back()
            ->with('mensaje', 'Se cambió la privacidad del archivo a Privado.')
            ->with('icono', 'success');
    }
}
