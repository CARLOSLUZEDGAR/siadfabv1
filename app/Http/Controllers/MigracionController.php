<?php

namespace App\Http\Controllers;

use App\PersonalCargo;
use App\PersonalDestinos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MigracionController extends Controller
{
    public function migrarPersonalDestinos(Request $request)
    {   
        /**FUNCION PARA TRUNCATE LA TABLA personal_destinos y personal_cargos(foreing_key con tabla personal_destinos) */
        $personal_destinos = DB::connection('pgsql')->statement('TRUNCATE personal_destinos CASCADE');

        $ultimo_destino = DB::connection('pgsql_server')->table('personal_destinos')
                                ->where('estado',1)
                                ->get();

        $ultimo_cargo = DB::connection('pgsql_server')->table('personal_cargos')
                                ->where('estado',1)
                                ->get();

        // $insert_destino = PersonalDestinos::create([

        // ]);
        
        // $insert_cargo = PersonalCargo::create([

        // ]);
    }
}
