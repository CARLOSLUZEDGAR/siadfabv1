<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel2Destino extends Model
{
    //
    protected $table = 'nivel2_destinos';
    protected $fillable = [
        'd1_cod',
        'descripcion',
        'prioridad',
        'observacion',
        'estado',
        'ogd',
        'sysuser',
        'created_at',
        'updated_at'
    ];    
    public function nivel1_destinos(){
        return $this->belongsTo('App\Nivel1Destino');
    }

    public function nivel3_destinos()
    {
        return $this->hasMany('App\Nivel3Destino');
    }
}
