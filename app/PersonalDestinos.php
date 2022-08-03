<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalDestinos extends Model
{
    //
    protected $table = 'personal_destinos';
    protected $fillable =[
        'id',
        'per_codigo',
        'd1_cod',
        'd2_cod',
        'd3_cod',
        'd4_cod',
        'gra_cod',
        'nro_doc',
        'tipo_doc',
        'fecha_destino',
        'finfechadestino',
        'promocion',
        'observacion',
        'sysuser',
        'flag',
        'estado'
    ];
}
