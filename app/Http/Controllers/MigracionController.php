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
        $gestion4 = date('Y');
        $gestion2 = date('y');
        $fecha = $gestion4.'-12-31';
        $nroDoc = '02/'.$gestion2;
        $doc = 'ORDEN GENERAL DE DESTINOS';
        /**FUNCION PARA TRUNCATE LA TABLA personal_destinos y personal_cargos(foreing_key con tabla personal_destinos) */
        $personal_destinos = DB::connection('pgsql')->statement('TRUNCATE personal_destinos CASCADE');

        $ultimo_destino = DB::connection('pgsql_server')->table('personal_destinos')
                                ->where('estado',1)
                                ->orderBy('id')
                                ->get();

        $ultimo_cargo = DB::connection('pgsql_server')->table('personal_cargos')
                                ->where('estado',1)
                                ->orderBy('id')
                                ->get();

        $cantUltimoDestino = sizeof($ultimo_destino);
        $arrayUltimoDestino = json_decode($ultimo_destino,true);

        $cantUltimoCargo = sizeof($ultimo_cargo);
        $arrayUltimoCargo = json_decode($ultimo_cargo,true);

        for ($i=0; $i < $cantUltimoDestino ; $i++) { 
            $insert_destino = DB::connection('pgsql')->table('personal_destinos')->insert([
                'id' => $arrayUltimoDestino[$i]['id'],
                'per_codigo' => $arrayUltimoDestino[$i]['per_codigo'],
                'd1_cod' => $arrayUltimoDestino[$i]['d1_cod'],
                'd2_cod' => $arrayUltimoDestino[$i]['d2_cod'],
                'd3_cod' => $arrayUltimoDestino[$i]['d3_cod'],
                'd4_cod' => $arrayUltimoDestino[$i]['d4_cod'],
                'gra_cod' => $arrayUltimoDestino[$i]['gra_cod'],
                'nro_doc' => $nroDoc,
                'tipo_doc' => $doc,
                // 'fecha_destino' => $arrayUltimoDestino[$i]['fecha_destino'],
                'fecha_destino' => $fecha,
                'finfechadestino' => $arrayUltimoDestino[$i]['finfechadestino'],
                'promocion' => $arrayUltimoDestino[$i]['promocion'],
                'observacion' => $arrayUltimoDestino[$i]['observacion'],
                'sysuser' => $arrayUltimoDestino[$i]['sysuser'],
                'flag' => $arrayUltimoDestino[$i]['flag'],
                'estado' => $arrayUltimoDestino[$i]['estado'],
                'created_at' => $fecha,
                'updated_at' => $fecha,
            ]);
        }

        for ($j=0; $j < $cantUltimoCargo ; $j++) { 
            $insert_cargo = DB::connection('pgsql')->table('personal_cargos')->insert([
                'id' => $arrayUltimoCargo[$j]['id'],
                'per_codigo' => $arrayUltimoCargo[$j]['per_codigo'],
                'dest_cod' => $arrayUltimoCargo[$j]['dest_cod'],
                'car_cod' => $arrayUltimoCargo[$j]['car_cod'],
                'nivel_cargo' => $arrayUltimoCargo[$j]['nivel_cargo'],
                // 'fechadest' => $arrayUltimoCargo[$j]['fechadest'],
                'fechadest' => $fecha,
                'observacion' => $arrayUltimoCargo[$j]['observacion'],
                'sysuser' => $arrayUltimoCargo[$j]['sysuser'],
                'estado' => $arrayUltimoCargo[$j]['estado'],
                'flag' => $arrayUltimoCargo[$j]['flag'],
                'created_at' => $fecha,
                'updated_at' => $fecha,
            ]);
        }
        // return response()->json([$personal_destinos,$ultimo_destino,$ultimo_cargo]);
        return response()->json([$cantUltimoDestino,$arrayUltimoDestino]);

    }
}
