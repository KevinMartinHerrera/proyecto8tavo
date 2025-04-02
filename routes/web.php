<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CarpetaController;
use App\Http\Controllers\CasoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UsuarioController;

/* Route::get('/', function () {
    return view('welcome');
}); */

/* //admin
Route::get('/admin', function () {
    return view('admin/admin');
});
 */
Auth::routes();

/* Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); */


Route::get('/admin', [AdminController::class, 'index'])->name ('admin.index')->middleware('auth');

//demientras hacemos el front de la landig page 
Route::get('/', function () {
    return redirect('/admin');
});

//crud usuarios
Route::get('/gestion-usuarios', [UsuarioController::class, 'index'])->name ('usuario.index')->middleware('auth');
Route::get("/create-user", [UsuarioController::class, 'create'])->name ('usuario.create')->middleware('auth');
Route::post("/create-user", [UsuarioController::class, 'store'])->name ('usuario.store')->middleware('auth');
Route::get('/user-edit/{id}', [UsuarioController::class, 'show'])->name('usuarios.edit')->middleware('auth');
Route::put('/user-edit/{id}', [UsuarioController::class, 'update'])->name('usuarios.update')->middleware('auth');
Route::delete('/delete-user/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy')->middleware('auth');

/* gestion de Archivos  */

Route::get('/gestion-de-archivos', [CarpetaController::class, 'index'])->name ('carpetas.index')->middleware('auth');
Route::post('/crear-carpeta', [CarpetaController::class, 'store'])->name ('carpetas.store')->middleware('auth');
Route::get('/carpetas/{id}', [CarpetaController::class, 'show'])->name('carpetas.show')->middleware('auth');
Route::post('/carpetas', [CarpetaController::class, 'crear_subcarpeta'])->name('subcarpetas.create')->middleware('auth');
Route::put('/carpetas/actualizar', [CarpetaController::class, 'update'])->name('carpetas.update')->middleware('auth');
Route::delete('/carpeta/delete/{id}', [CarpetaController::class, 'destroy'])
    ->name('carpetas.destroy')
    ->middleware('auth');


/* rutas para archivos */
Route::post('/archivos-upload', [ArchivoController::class, 'upload'])->name('archivos.upload')->middleware('auth');
Route::delete('/archivos-delete', [ArchivoController::class, 'delete'])->name('archivos.destroy')->middleware('auth');
/* ruta para archivos privado */
Route::get('storage/{carpeta}/{archivo}',function($carpeta,$archivo){
    if(Auth::check()){
        $path = storage_path('app'.DIRECTORY_SEPARATOR.$carpeta.DIRECTORY_SEPARATOR.$archivo);
        return response()->file($path);
    }else{
        abort(403,'no tienes permiso para acceder a este archivo');
    }
})->name('mostrar.archivos.privado');
/* ruta para camn */
Route::get('/compartir-archivos/privado', [ArchivoController::class, 'cambio_status_publico'])
    ->name('Archivos.cambio_estatus.publico')
    ->middleware('auth');
/* ruta para camn */
Route::get('/compartir-archivos/publico', [ArchivoController::class, 'cambio_status_privado'])
    ->name('Archivos.cambio_estatus.privado')
    ->middleware('auth');


/* rutas para administras el perfil */
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

/* rutas para administrar los casos y todo lo que tenga que ver */
Route::get('/casos',[CasoController::class, 'index'])->name('casos.index')->middleware('auth');
Route::get('/casos/create',[CasoController::class, 'create'])->name('casos.create')->middleware('auth');
Route::post('/casos/create',[CasoController::class, 'store'])->name('casos.store')->middleware('auth');
Route::delete('/casos/delete/{id}',[CasoController::class, 'destroy'])->name('casos.destroy')->middleware('auth');
Route::get('casos/{caso}/edit', [CasoController::class, 'edit'])->name('casos.edit')->middleware('auth');
Route::put('casos/{caso}', [CasoController::class, 'update'])->name('casos.update')->middleware('auth');

/* rutas para gestor de tareas */
Route::middleware(['auth'])->group(function () {
    Route::resource('boards', BoardController::class);
   
    Route::resource('tasks', TaskController::class);
});



Route::put('/tasks/{task}/move', [TaskController::class, 'moveTask'])->name('tasks.move')->middleware('auth');
