<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carpeta extends Model
{
    use HasFactory;
    protected $fillable =['nombre','carpeta_padre_id'];
    
    public function carpetasHijas()
    {
        return $this->hasMany(Carpeta::class, 'carpeta_padre_id', 'id');
    }
    
    public function archivos(){
        return $this->hasMany(Archivo::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    // Definir la relación con el modelo Caso
    public function casos()
    {
        return $this->hasMany(Caso::class, 'carpeta_id', 'id');
    }
    
}
