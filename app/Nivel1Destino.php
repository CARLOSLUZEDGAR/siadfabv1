<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel1Destino extends Model
{
    //
    protected $table = 'nivel1_destinos';
    
    protected $fillable = [
        'descripcion',
        'observacion',
        'estado',
        'sysuser',
        'created_at',
        'updated_at'
    ];
    public function nivel2_destinos()
    {
        return $this->hasMany('App\Nivel2Destino');
    }
}
