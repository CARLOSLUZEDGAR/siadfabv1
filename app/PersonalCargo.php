<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalCargo extends Model
{
    //
    protected $table = 'personal_cargos';
    protected $fillable =[
        'id',
        'per_codigo',
        'dest_cod',
        'car_cod',
        'nivel_cargo',
        'fechadest',
        'observacion',
        'sysuser',
        'estado',
        'flag',
    ];  
}
