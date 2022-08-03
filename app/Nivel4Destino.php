<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel4Destino extends Model
{
    //
    protected $table = 'nivel4_destinos';
    protected $fillable = [
        'id',
        'd3_cod',
        'descripcion',
        'orden',
        'puntaje',
        'observacion',
        'estado',
        'sysuser',
        'created_at',
        'updated_at'
    ];

    public function nivel3_destinos(){
        return $this->belongsTo('App\Nivel3Destino');
    }
}
