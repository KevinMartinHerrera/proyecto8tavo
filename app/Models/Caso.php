<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Asegúrate de importar el modelo User si aún no lo has hecho

class Caso extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'numero_caso',
        'fecha_apertura',
        'descripcion',
        'tipo_caso',
        'estado',
        'fecha_cierre',
        'numero_expediente',
        'abogado_id',
        'cliente_id',
        'carpeta_id',
    ];
    protected $dates = [
        'fecha_apertura', // Asegúrate de que 'fecha_apertura' esté aquí si es un campo de fecha en tu base de datos
        // Otros campos de fecha si los tienes
    ];

    public function carpeta()
    {
        return $this->belongsTo(Carpeta::class);
    }

    public function abogado()
    {
        return $this->belongsTo(User::class, 'abogado_id');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}