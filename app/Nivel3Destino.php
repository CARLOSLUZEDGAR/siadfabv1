<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel3Destino extends Model
{
    //
    protected $table = 'nivel3_destinos';
    protected $fillable = [
        'id',
        'd2_cod',
        'depa_cod',
        'prov_cod',
        'descripcion',
        'abreviatura',
        'tipo',
        'prioridad',
        'frontera',
        'orden',
        'cod_mindef',
        'observacion',
        'estado',
        'sysuser'
    ];

    public function nivel2_destinos(){
        return $this->belongsTo('App\Nivel2Destino');
    }

    public function nivel4_destinos()
    {
        return $this->hasMany('App\Nivel4Destino');
    }
}
