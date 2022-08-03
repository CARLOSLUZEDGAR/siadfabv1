<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personals';
    protected $primaryKey = 'per_codigo';
    protected $fillable = [
        'per_codigo', 'per_paterno', 'per_materno', 'per_nombre', 'per_fecha_nacimiento', 'per_estado_civil',
        'per_sexo', 'per_ci', 'per_expedido', 'per_telefono', 'per_celular', 'per_mail',
        'per_cm', 'per_ciudad', 'per_zona', 'per_calle', 'per_promo', 'per_seguro', 'per_serv_mil',
        'per_religion', 'per_boleta_pago','per_foto', 'per_observaciones',  'estado', 'sysuser'

    ];


    public function subescalafon()
    {
        return $this->belongsTo('App\Escalafon', 'id');
    }

    //DatosFamiliares
    public function datos_familiares()
    {
        return $this->hasMany('App\Datos_familiares'); // se hace la referencia a la entidad fuerte para utilizar sus atributos
    }

    //Datos_fisicos
    public function datos_fisicos()
    {
        return $this->hasMany('App\Datos_fisicos'); // se hace la referencia a la entidad fuerte para utilizar sus atributos
    }
}
