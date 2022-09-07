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
        // return response()->json([$cantUltimoDestino,$arrayUltimoDestino]);
        return response()->json(['code' => 200]);
    }

    public function migrarPersonalEscalafones(Request $request)
    {   
        // $personal_escalafones = DB::connection('pgsql')->statement('TRUNCATE personal_escalafones');
        // // DB::statement('ALTER your_table DISABLE TRIGGER ALL;');
        // $grados = DB::connection('pgsql')->statement('TRUNCATE grados');
        // $subescalafones = DB::connection('pgsql')->statement('TRUNCATE subescalafones');
        // $escalafones = DB::connection('pgsql')->statement('TRUNCATE escalafones');

        // $ultimo_escalafon = DB::connection('pgsql_server')->table('personal_escalafones')
        //                         ->where('estado',1)
        //                         ->orderBy('id')
        //                         ->get();
        // $ultimo_grados = DB::connection('pgsql_server')->table('grados')
        //                         ->orderBy('id')
        //                         ->get();
        // $ultimo_subescalafones = DB::connection('pgsql_server')->table('subescalafones')
        //                         ->orderBy('id')
        //                         ->get();
        // $ultimo_escalafones = DB::connection('pgsql_server')->table('escalafones')
        //                         ->orderBy('id')
        //                         ->get();

        // $cantUltimoEscalafon = sizeof($ultimo_escalafon);
        // $arrayUltimoEscalafon = json_decode($ultimo_escalafon,true);
        // $cantUltimoEscalafones = sizeof($ultimo_escalafones);
        // $arrayUltimoEscalafones = json_decode($ultimo_escalafones,true);
        // $cantUltimoSubescalafones = sizeof($ultimo_subescalafones);
        // $arrayUltimoSubescalafones = json_decode($ultimo_subescalafones,true);
        // $cantUltimoGrados = sizeof($ultimo_grados);
        // $arrayUltimoGrados = json_decode($ultimo_grados,true);

        // for ($i=0; $i < $cantUltimoEscalafones ; $i++) { 
        //     $insert_escalafones = DB::connection('pgsql')->table('escalafones')->insert([
        //         'id' => $arrayUltimoEscalafones[$i]['id'],
        //         'nombre' => $arrayUltimoEscalafones[$i]['nombre'],
        //         'observacion' => $arrayUltimoEscalafones[$i]['observacion'],
        //         'estado' => $arrayUltimoEscalafones[$i]['estado'],
        //         'sysuser' => $arrayUltimoEscalafones[$i]['sysuser'],
        //         'created_at' => $arrayUltimoEscalafones[$i]['fecha_doc'],
        //         'updated_at' => $arrayUltimoEscalafones[$i]['fecha_doc']
        //     ]);
        // }
        // for ($i=0; $i < $cantUltimoSubescalafones ; $i++) { 
        //     $insert_subescalafones = DB::connection('pgsql')->table('subescalafones')->insert([
        //         'id' => $arrayUltimoSubescalafones[$i]['id'],
        //         'esca_cod' => $arrayUltimoSubescalafones[$i]['esca_cod'],
        //         'nombre' => $arrayUltimoSubescalafones[$i]['nombre'],
        //         'orden' => $arrayUltimoSubescalafones[$i]['orden'],
        //         'observacion' => $arrayUltimoSubescalafones[$i]['observacion'],
        //         'estado' => $arrayUltimoSubescalafones[$i]['estado'],
        //         'sysuser' => $arrayUltimoSubescalafones[$i]['sysuser'],
        //         'created_at' => $arrayUltimoSubescalafones[$i]['fecha_doc'],
        //         'updated_at' => $arrayUltimoSubescalafones[$i]['fecha_doc']
        //     ]);
        // }
        // for ($i=0; $i < $cantUltimoGrados ; $i++) { 
        //     $insert_grados = DB::connection('pgsql')->table('grados')->insert([
        //         'id' => $arrayUltimoGrados[$i]['id'],
        //         'subesc_cod' => $arrayUltimoGrados[$i]['subesc_cod'],
        //         'abreviatura' => $arrayUltimoGrados[$i]['abreviatura'],
        //         'nombre' => $arrayUltimoGrados[$i]['nombre'],
        //         'fuerza' => $arrayUltimoGrados[$i]['fuerza'],
        //         'orden' => $arrayUltimoGrados[$i]['orden'],
        //         'divGra' => $arrayUltimoGrados[$i]['divGra'],
        //         'division' => $arrayUltimoGrados[$i]['division'],
        //         'nivFalta' => $arrayUltimoGrados[$i]['nivFalta'],
        //         'observacion' => $arrayUltimoGrados[$i]['observacion'],
        //         'estado' => $arrayUltimoGrados[$i]['estado'],
        //         'sysuser' => $arrayUltimoGrados[$i]['sysuser'],
        //         'created_at' => $arrayUltimoGrados[$i]['fecha_doc'],
        //         'updated_at' => $arrayUltimoGrados[$i]['fecha_doc']
        //     ]);
        // }
        // for ($i=0; $i < $cantUltimoEscalafon ; $i++) { 
        //     $insert_escalafon = DB::connection('pgsql')->table('personal_escalafones')->insert([
        //         'id' => $arrayUltimoEscalafon[$i]['id'],
        //         'per_codigo' => $arrayUltimoEscalafon[$i]['per_codigo'],
        //         'esca_cod' => $arrayUltimoEscalafon[$i]['esca_cod'],
        //         'subesc_cod' => $arrayUltimoEscalafon[$i]['subesc_cod'],
        //         'gra_cod' => $arrayUltimoEscalafon[$i]['gra_cod'],
        //         'documento' => $arrayUltimoEscalafon[$i]['documento'],
        //         'fecha_doc' => $arrayUltimoEscalafon[$i]['fecha_doc'],
        //         'fecha' => $arrayUltimoEscalafon[$i]['fecha'],
        //         'cm' => $arrayUltimoEscalafon[$i]['cm'],
        //         'nro_doc' => $arrayUltimoEscalafon[$i]['nro_doc'],
        //         'observacion' => $arrayUltimoEscalafon[$i]['observacion'],
        //         'estado' => $arrayUltimoEscalafon[$i]['estado'],
        //         'sysuser' => $arrayUltimoEscalafon[$i]['sysuser'],
        //         'created_at' => $arrayUltimoEscalafon[$i]['fecha_doc'],
        //         'updated_at' => $arrayUltimoEscalafon[$i]['fecha_doc'],
        //         'flag' => $arrayUltimoEscalafon[$i]['flag']
        //     ]);
        // }
        // return response()->json(['code' => 200]);
    }
}
