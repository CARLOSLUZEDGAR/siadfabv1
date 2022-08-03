<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

use App\PersonalDestinos;
use App\PersonalCargo;
use Illuminate\Support\Facades\Auth;

class PersonalDestinosController extends Controller
{
    public function index(Request $request)
    {
        $per_codigo = $request->per_codigo;

        if($per_codigo==''){
            $personal_destinos = DB::table("personal_destinos")
            ->orderBy('personal_destinos.id','desc')
            ->paginate(10);     
        }
        else
        {
            $personal_destinos = DB::table("personal_destinos")
            ->join('personals','personal_destinos.per_codigo','=','personals.per_codigo')
            ->join('nivel1_destinos','personal_destinos.d1_cod','=','nivel1_destinos.id')
            ->join('nivel2_destinos','personal_destinos.d2_cod','=','nivel2_destinos.id')
            ->join('nivel3_destinos','personal_destinos.d3_cod','=','nivel3_destinos.id')
            ->join('nivel4_destinos','personal_destinos.d4_cod','=','nivel4_destinos.id')
            ->join('personal_cargos','personal_destinos.id','=','personal_cargos.dest_cod')
            ->join('cargos','personal_cargos.car_cod','=','cargos.id')
            ->leftjoin('grados','personal_destinos.gra_cod','=','grados.id')
            ->select('personal_destinos.id as idpersonal_destinos',
                    'nivel1_destinos.descripcion as desc_dn1',
                    'nivel2_destinos.descripcion as desc_dn2',
                    'nivel3_destinos.descripcion as desc_dn3',
                    'nivel4_destinos.descripcion as desc_dn4',
                    'personals.per_nombre',
                    'personals.per_paterno',
                    'personals.per_materno',
                    'personal_destinos.per_codigo',
                    'personal_destinos.d1_cod',
                    'personal_destinos.d2_cod',
                    'personal_destinos.d3_cod',
                    'personal_destinos.d4_cod',
                    'personal_destinos.tipo_doc',
                    'personal_destinos.gra_cod',
                    'personal_destinos.nro_doc',
                    'personal_destinos.fecha_destino as fechadestino',
                    'personal_destinos.promocion',
                    'personal_destinos.estado',
                    'personal_destinos.flag',
                    'personal_destinos.observacion',
                    'cargos.id as idcargo',
                    'cargos.descripcion as cargo',
                    'grados.abreviatura as gra_abreviatura',

                    DB::raw("(CASE WHEN date_part('DAY',personal_destinos.fecha_destino)=31 and date_part('MONTH',personal_destinos.fecha_destino)=12 
                    THEN cast(date_part('YEAR',personal_destinos.fecha_destino + INTERVAL '1 YEAR') as varchar)
                    ELSE cast(personal_destinos.fecha_destino as varchar) END)
                    as fecha_final")
                    )
            ->where('personal_destinos.per_codigo', '=', $per_codigo)
            ->where('personal_cargos.nivel_cargo',1)
            ->where('personal_destinos.flag',1)
            ->orderBy('personal_destinos.fecha_destino','desc')
            ->paginate(10);

            $personal_destinos2 = DB::table("personal_destinos")
            ->join('personals','personal_destinos.per_codigo','=','personals.per_codigo')
            ->join('nivel1_destinos','personal_destinos.d1_cod','=','nivel1_destinos.id')
            ->join('nivel2_destinos','personal_destinos.d2_cod','=','nivel2_destinos.id')
            ->join('nivel3_destinos','personal_destinos.d3_cod','=','nivel3_destinos.id')
            ->join('nivel4_destinos','personal_destinos.d4_cod','=','nivel4_destinos.id')
            ->join('personal_cargos','personal_destinos.id','=','personal_cargos.dest_cod')
            ->join('cargos','personal_cargos.car_cod','=','cargos.id')
            ->select('personal_destinos.id as idpersonal_destinos',
                    'nivel1_destinos.descripcion as desc_dn1',
                    'nivel2_destinos.descripcion as desc_dn2',
                    'nivel3_destinos.descripcion as desc_dn3',
                    'nivel4_destinos.descripcion as desc_dn4',
                    'personals.per_nombre',
                    'personals.per_paterno',
                    'personals.per_materno',
                    'personal_destinos.per_codigo',
                    'personal_destinos.d1_cod',
                    'personal_destinos.d2_cod',
                    'personal_destinos.d3_cod',
                    'personal_destinos.d4_cod',
                    'personal_destinos.tipo_doc',
                    'personal_destinos.gra_cod',
                    'personal_destinos.nro_doc',
                    'personal_destinos.fecha_destino as fechadestino',
                    'personal_destinos.promocion',
                    'personal_destinos.estado',
                    'personal_destinos.flag',
                    'personal_destinos.observacion',
                    'cargos.id as idcargo2',
                    'cargos.descripcion as cargo2'
                    )
            ->where('personal_destinos.per_codigo', '=', $per_codigo)
            ->where('personal_cargos.nivel_cargo',2)
            ->where('personal_destinos.flag',1)
            ->orderBy('personal_destinos.fecha_destino','desc')
            ->get();

            $personal_destinos_frontera = DB::table("personal_destinos")
            ->join('personals','personal_destinos.per_codigo','=','personals.per_codigo')
            ->join('nivel1_destinos','personal_destinos.d1_cod','=','nivel1_destinos.id')
            ->join('nivel2_destinos','personal_destinos.d2_cod','=','nivel2_destinos.id')
            ->join('nivel3_destinos','personal_destinos.d3_cod','=','nivel3_destinos.id')
            ->join('nivel4_destinos','personal_destinos.d4_cod','=','nivel4_destinos.id')
            ->select('personal_destinos.id as idpersonal_destinos',
                    'nivel1_destinos.descripcion as desc_dn1',
                    'nivel2_destinos.descripcion as desc_dn2',
                    'nivel3_destinos.descripcion as desc_dn3',
                    'nivel4_destinos.descripcion as desc_dn4',
                    'personal_destinos.fecha_destino as fechadestino',
                    )
            ->where('personal_destinos.per_codigo', '=', $per_codigo)
            ->where('nivel3_destinos.frontera',1)
            ->orderBy('personal_destinos.fecha_destino','asc')
            ->get();

        //    return response()->json(['cargo1' => $personal_destinos,'cargo2' => $personal_destinos2,'frontera' => $personal_destinos_frontera]);
        }

        return [
            'pagination' => [
                'total'         => $personal_destinos->total(),
                'current_page'  => $personal_destinos->currentPage(),
                'per_page'      => $personal_destinos->perPage(),
                'last_page'     => $personal_destinos->lastPage(),
                'from'          => $personal_destinos->firstItem(),
                'to'            => $personal_destinos->lastItem(),

            ],
            'cargo1' => $personal_destinos,'cargo2' => $personal_destinos2,'frontera' => $personal_destinos_frontera
             //'cargo1' => $personal_destinos
        ];
         //return response()->json(['cargo1' => $personal_destinos,'cargo2' => $personal_destinos2,'frontera' => $personal_destinos_frontera]);
        
    }

    public function store(Request $request)
    {
         // PARA DEFINIR EL ESTADO
         $fecha_max_update = PersonalDestinos::
         where('per_codigo', $request->perdest_codigocambio)
         ->where('flag',1)
         ->max('fecha_destino');
 
         if ($request->perdest_fechadestino >= $fecha_max_update)
            {
                $perdest_estado = '1';
 
                $excluir = PersonalDestinos::
                where('per_codigo', $request->perdest_codigocambio)
                ->whereNotIn('fecha_destino', [$request->perdest_fechadestino])
                ->update(['estado' => 0]);

                $excluir_cargo = PersonalCargo::
                where('per_codigo', $request->perdest_codigocambio)
                ->whereNotIn('fechadest', [$request->perdest_fechadestino])
                ->update(['estado' => 0]);
            }
         else
             {
                $perdest_estado = '0';
             }
         //FIN DEFINIR ESTADO

         //PARA PONER FUNCION ASIGNARSE COMO DEFAULT

         if($request->perdest_cargo2 == null)
         {
             $idcargo2 = '369';
         }
     else
         {
             $idcargo2 = $request->perdest_cargo2;
         }
     
     //FIN DEFAULT

     //INICIO DETERMINAR GRADO
     
     /*$filtro = $request->filtro;
     if ($filtro==1 || $filtro==2 || $filtro==3)
            {
                $fecha_grado = $request->perdest_fechadestino;
                $promocion = $request->promocion;
               $a = '31/12/'.$promocion;
               $b = '30/12/'.($promocion + 5);
               $c = '31/12/'.($promocion + 5);
               $d = '30/12/'.($promocion + 10);
               $e = '31/12/'.($promocion + 10);
               $f = '30/12/'.($promocion + 15);
               $g = '31/12/'.($promocion + 15);
               $h = '30/12/'.($promocion + 20);
               $i = '31/12/'.($promocion + 20);
               $j = '30/12/'.($promocion + 25);
               $k = '31/12/'.($promocion + 25);
               $l = '30/12/'.($promocion + 30);

                //$grado = 0;
                
                if ($fecha_grado >= $a && $fecha_grado <= $b){
                    $grado = 9;
                }
                if ($fecha_grado >= $c && $fecha_grado <= $d){
                    $grado = 8;
                }
             if ($fecha_grado >= $e && $fecha_grado <= $f){
                    $grado = 7;
                }
             if ($fecha_grado >= $g && $fecha_grado <= $h){
                    $grado = 6;
                }
             if ($fecha_grado >= $i && $fecha_grado <= $j){
                    $grado = 5;
                }
             if ($fecha_grado >= $k && $fecha_grado <= $l){
                    $grado = 4;
                } 
                else{}               
                //return response()->json($grado);
            }
    if ($filtro==4 || $filtro==5 || $filtro==6)
            {
                $fecha_grado = $request->perdest_fechadestino;
                $promocion = $request->promocion;
               $a = '31/12/'.$promocion;
               $b = '30/12/'.($promocion + 3);
               $c = '31/12/'.($promocion + 3);
               $d = '30/12/'.($promocion + 6);
               $e = '31/12/'.($promocion + 6);
               $f = '30/12/'.($promocion + 10);
               $g = '31/12/'.($promocion + 10);
               $h = '30/12/'.($promocion + 15);
               $i = '31/12/'.($promocion + 15);
               $j = '30/12/'.($promocion + 20);
               $k = '31/12/'.($promocion + 20);
               $l = '30/12/'.($promocion + 25);
               $m = '31/12/'.($promocion + 25);
               $n = '30/12/'.($promocion + 30);
                
                if ($fecha_grado >= $a && $fecha_grado <= $b){
                    $grado = 17;
                }
                 if ($fecha_grado >= $c && $fecha_grado <= $d){
                    $grado = 16;
                }
                 if ($fecha_grado >= $e && $fecha_grado <= $f){
                    $grado = 15;
                }
                 if ($fecha_grado >= $g && $fecha_grado <= $h){
                    $grado = 14;
                }
                if ($fecha_grado >= $i && $fecha_grado <= $j){
                    $grado = 13;
                }
                 if ($fecha_grado >= $k && $fecha_grado <= $l){
                    $grado = 12;
                }
                 if ($fecha_grado >= $m && $fecha_grado <= $n){
                    $grado = 11;
                }
                             
                //return response()->json($grado);
            }
           $dest = $grado;*/
        

        
     //FIN DETERMINAR GRADO
        $personal_destino = PersonalDestinos::create([
            //'CAMPO DE LA TABLA' => $request->NOMBRE Q VIENE DE LA VISTA
            'per_codigo' => $request->perdest_codigocambio,
            'd1_cod' => $request->perdest_destn1_codigo,
            'd2_cod' => $request->perdest_destn2_codigo,
            'd3_cod' => $request->perdest_destn3_codigo,
            'd4_cod' => $request->perdest_destn4_codigo,
            'gra_cod' => $request->perdest_grado,
            'nro_doc' => $request->perdest_nro_doc,
            'tipo_doc' => $request->perdest_tipo_doc,
            'fecha_destino' => $request->perdest_fechadestino,
            'finfechadestino' => $request->perdest_fechadestino,
            'promocion' => $request->promocion,
            'observacion' => $request->perdest_observaciones,
            'sysuser' => Auth::user()->id,
            'flag' => '1',
            'estado' => $perdest_estado,
        ]);

        $personal_cargo1 = PersonalCargo::create([
            //'CAMPO DE LA TABLA' => $request->NOMBRE Q VIENE DE LA VISTA
            'per_codigo' => $request->perdest_codigocambio,
            'dest_cod' => $personal_destino->id,
            'car_cod' => $request->perdest_cargo1,
            'nivel_cargo' => '1',
            'fechadest' => $request->perdest_fechadestino,
            'observacion' => $request->perdest_observaciones,
            'sysuser' => Auth::user()->id,
            'estado' => $perdest_estado,
            'flag' => '1',
        ]);

        $personal_cargo2 = PersonalCargo::create([
            //'CAMPO DE LA TABLA' => $request->NOMBRE Q VIENE DE LA VISTA
            //PARA PONER FUNCION ASIGNARSE COMO DEFAULT
            'per_codigo' => $request->perdest_codigocambio,
            'dest_cod' => $personal_destino->id,
            'car_cod' => $idcargo2,
            'nivel_cargo' => '2',
            'fechadest' => $request->perdest_fechadestino,
            'observacion' => $request->perdest_observaciones,
            'sysuser' => Auth::user()->id,
            'estado' => $perdest_estado,
            'flag' => '1',
        ]);
        return response()->json([$personal_destino,$personal_cargo1,$personal_cargo2]);
       
    }

    public function update(Request $request)
    {
        // PARA DEFINIR EL ESTADO
        $fecha_max_update = PersonalDestinos::
        where('per_codigo', $request->perdest_codigocambio)
        ->where('flag',1)
        ->max('fecha_destino');

        $reg_estado_1 = PersonalDestinos::
            where('per_codigo', $request->perdest_codigocambio)
            ->where('fecha_destino', $fecha_max_update)
            ->where('flag',1)
            ->first();

        $fecha_sub_max = PersonalDestinos::
            where('per_codigo', $request->perdest_codigocambio)
            ->where('estado', 0)
            ->where('flag',1)
            ->max('fecha_destino');

        if ($request->perdest_fechadestino >= $fecha_max_update)
            {
                $perdest_estado = '1';

                $excluir = PersonalDestinos::
                where('per_codigo', $request->perdest_codigocambio)
                ->whereNotIn('fecha_destino', [$request->perdest_fechadestino])
                ->update(['estado' => 0]);

                $excluir_cargo = PersonalCargo::
                where('per_codigo', $request->perdest_codigocambio)
                ->whereNotIn('fechadest', [$request->perdest_fechadestino])
                ->update(['estado' => 0]);

                
            }
        else
            {
                if ($reg_estado_1->id == $request->idPersonalDestino ){
                    if ($request->perdest_fechadestino >= $fecha_sub_max){
                        $perdest_estado = '1';

                        $excluir = PersonalDestinos::
                        where('per_codigo', $request->perdest_codigocambio)
                        ->whereNotIn('fecha_destino', [$request->perdest_fechadestino])
                        ->update(['estado' => 0]);

                        $excluir_cargo = PersonalCargo::
                        where('per_codigo', $request->perdest_codigocambio)
                        ->whereNotIn('fechadest', [$request->perdest_fechadestino])
                        ->update(['estado' => 0]);
                    }
                    else{

                        // $perdest_estado = '0';

                        $excluir = PersonalDestinos::
                        where('per_codigo', $request->perdest_codigocambio)
                        ->where('fecha_destino', $fecha_sub_max)
                        ->where('flag',1)
                        ->update(['estado' => 1]);

                        $excluir_cargo = PersonalCargo::
                        where('per_codigo', $request->perdest_codigocambio)
                        ->where('fechadest', $fecha_sub_max)
                        ->where('flag',1)
                        ->update(['estado' => 1]);

                        $perdest_estado = '0';
                        
                    }
                }
                else{
                    $mayor_dest = PersonalDestinos::
                    where('per_codigo', $request->perdest_codigocambio)
                    ->where('fecha_destino', $fecha_max_update)
                    ->where('flag',1)
                    ->update(['estado' => 1]);
                    $perdest_estado = '0';
                }
            }
        //FIN DEFINIR ESTADO

        $personal_destinos = PersonalDestinos::where('id',$request->idPersonalDestino)
                    ->first();
        $personal_destinos -> update([
            'per_codigo' => $request->perdest_codigocambio,
            'nro_doc' => $request->perdest_nro_doc,
            'tipo_doc' => $request->perdest_tipo_doc,
            'fecha_destino' => $request->perdest_fechadestino,
            'gra_cod' => $request->perdest_gra_doc,
            'd1_cod' => $request->perdest_destn1_codigo,
            'd2_cod' => $request->perdest_destn2_codigo,
            'd3_cod' => $request->perdest_destn3_codigo,
            'd4_cod' => $request->perdest_destn4_codigo,
            'promocion' => $request->promocion,
            'estado' => $perdest_estado,
            'observacion' => $request->perdest_observaciones,
            'sysuser' => Auth::user()->id
        ]);

        $personal_cargo1 = PersonalCargo::where('dest_cod',$request->idPersonalDestino)
                        ->where('nivel_cargo','1')
                        ->first();
        $personal_cargo1 -> update([
            'car_cod' => $request->perdest_cargo1,
            'fechadest' => $request->perdest_fechadestino,
            'observacion' => $request->perdest_observaciones,
            'estado' => $perdest_estado,
            'sysuser' => Auth::user()->id,
        ]);

        $personal_cargo2 = PersonalCargo::where('dest_cod',$request->idPersonalDestino)
                        ->where('nivel_cargo','2')
                        ->first();
        $personal_cargo2 -> update([
            'car_cod' => $request->perdest_cargo2,
            'fechadest' => $request->perdest_fechadestino,
            'observacion' => $request->perdest_observaciones,
            'estado' => $perdest_estado,
            'sysuser' => Auth::user()->id,
        ]);

        return response()->json([$personal_destinos,$personal_cargo1,$personal_cargo2,$fecha_max_update,$fecha_sub_max]);
        
    }

    public function cambiarGrado(Request $request)
    {
        $perdestid = $request->perdestid;
        $grado = $request->grado;

        $personal_destinos = PersonalDestinos::where('id',$perdestid)
                    ->first();
        $personal_destinos -> update([
            'gra_cod' => $grado
        ]);

        return response()->json($personal_destinos);
        // return response()->json($request);
    }

    public function desactivarDestino(request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $personal_destinos = PersonalDestinos::findOrFail($request->idPersonalDestino);
        $personal_destinos->flag = '0';
        $personal_destinos->estado = '0';
        $personal_destinos->save();

        $desacCargo = PersonalCargo::
            where('dest_cod',$request->idPersonalDestino)
            ->update(['estado' => 0,
                    'flag' => 0]);

        $fecha_max_update = PersonalDestinos::
            where('per_codigo', $request->per_codigo)
            ->where('flag',1)
            ->max('fecha_destino');

        $mayor_dest = PersonalDestinos::
            where('per_codigo', $request->per_codigo)
            ->where('fecha_destino', $fecha_max_update)
            ->update(['estado' => 1]);

        $fecha_max_cargo = PersonalCargo::
            where('per_codigo', $request->per_codigo)
            ->where('flag',1)
            ->max('fechadest');

        $mayor_cargo = PersonalCargo::
            where('per_codigo', $request->per_codigo)
            ->where('fechadest', $fecha_max_cargo)
            ->update(['estado' => 1]);

        return response()->json([$personal_destinos,$fecha_max_update,$mayor_dest]);
    }

    public function cuadroEfectivos (Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10240M');

        $destinos = DB::table('vista_d3_personal')
                        ->select('d3id','d3descripcion','d3cantidad')
                        ->get();

        $grados_cant = DB::table('vista_grados_cant')
                    ->select('idgrado',
                        'abreviaturagrado',
                        'nombregrado',
                        'cantidadgrado')
                    ->get();

        $cantidad = DB::table('personal_destinos as pd')
                    ->join('personal_escalafones as pe','pd.per_codigo','pe.per_codigo')
                    ->join('personal_situaciones as ps','ps.per_codigo','pd.per_codigo')
                    ->join('grados as g','pe.gra_cod','g.id')
                    ->select('g.id',
                            'g.abreviatura',
                            DB::raw('count(g.abreviatura) as cantgrado')
                            )
                    ->where('pd.d2_cod',60)
                    ->where('pd.estado',1)
                    ->where('pe.estado',1)
                    ->where('ps.estado',1)
                    ->where('ps.sit_cod',1)
                    ->where('ps.subsit_cod',1)
                    ->where('ps.detsit_cod',1)
                    ->groupBy('g.id')
                    ->groupBy('g.abreviatura')
                    ->orderBy('g.id')
                    ->get();

        $cantidad2 = DB::table('personal_escalafones as pe')
                    ->join('grados as g','pe.gra_cod','g.id')
                    ->join('personals as p','pe.per_codigo','p.per_codigo')
                    ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
                    ->join('nivel4_destinos as d4','pd.d4_cod','d4.id')
                    ->join('nivel3_destinos as d3','pd.d3_cod','d3.id')
                    ->join('nivel2_destinos as d2','pd.d2_cod','d2.id')
                    ->join('personal_situaciones as ps','p.per_codigo','ps.per_codigo')
                    // ->join('personal_estudios as pestu','p.per_codigo','pestu.per_codigo')
                    // ->join('personal_especialidades as pespe','p.per_codigo','pespe.per_codigo')
                    // ->join('estudios as e','pestu.est_cod','e.id')
                    ->select('g.id',
                            'g.abreviatura as grado',
                            'g.nombre',
                            DB::raw('count(pe.gra_cod) as total'),
                            'd3.id as idd3',
                            'd3.descripcion')
                    ->where('pe.estado',1)
                    ->where('pd.estado',1)
                    ->where('ps.sit_cod',1)
                    ->whereIn('ps.detsit_cod',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
                    ->where('ps.estado',1)
                    // ->where('pestu.estado',1)
                    // ->where('pespe.estado',1)
                    ->where('g.fuerza','FAB')
                    ->groupBy('d3.d2_cod')
                    ->groupBy('d3.id')
                    ->groupBy('d3.orden')
                    ->groupBy('d4.d3_cod')
                    ->groupBy('d2.prioridad')
                    ->groupBy('g.abreviatura')
                    ->groupBy('g.nombre')
                    ->groupBy('g.id')
                    ->groupBy('g.fuerza')
                    ->groupBy('d3.descripcion')
                    ->groupBy('d3.prioridad')
                    ->groupBy('pe.esca_cod')
                    // ->groupBy('pe.subesc_cod')
                    ->groupBy('pe.gra_cod')
                    ->orderBy('d2.prioridad')
                    ->orderBy('d3.d2_cod')
                    ->orderBy('d3.orden')
                    ->orderBy('d4.d3_cod')
                    ->orderBy('g.nivFalta')
                    ->orderBy('g.id')
                    ->orderBy('pe.esca_cod')
                    // ->orderBy('pe.subesc_cod')
                    ->orderBy('pe.gra_cod')
                    ->get();

        $jefe_dpto = DB::table('personals')
                ->join('personal_destinos','personal_destinos.per_codigo','personals.per_codigo')
                ->join('personal_escalafones','personals.per_codigo','personal_escalafones.per_codigo')
                ->join('escalafones','escalafones.id','personal_escalafones.esca_cod')
                ->join('subescalafones','subescalafones.id','personal_escalafones.subesc_cod')
                ->join('grados','grados.id','personal_escalafones.gra_cod')
                ->join('personal_estudios','personal_estudios.per_codigo','personals.per_codigo')
                ->join('estudios','estudios.id','personal_estudios.est_cod')
                ->join('nivel3_destinos','nivel3_destinos.id','personal_destinos.d3_cod')
                ->join('nivel4_destinos','nivel4_destinos.id','personal_destinos.d4_cod')
                ->join('personal_cargos','personal_cargos.dest_cod','personal_destinos.id')
                ->join('cargos','cargos.id','personal_cargos.car_cod')
                ->select('personals.per_codigo',
                        'personals.per_paterno',
                        'personals.per_materno',
                        'personals.per_nombre',
                        'personals.per_sexo',
                        'personals.per_ci',
                        'personals.per_cm',
                        'personals.per_foto',
                        'grados.abreviatura as gra_abreviatura',
                        'estudios.abreviatura as estu_abreviatura',
                        'personal_escalafones.estado as escperestado',
                        'personal_estudios.id as estperestado')
                ->where('nivel3_destinos.id',22)
                ->where('nivel4_destinos.id',69)
                ->where('cargos.id',68)
                ->where('personal_escalafones.estado',1)
                ->where('personal_estudios.estado',1)
                ->where('personal_cargos.nivel_cargo',1)
                ->orderBy('personal_destinos.fecha_destino','desc')
                ->first();

        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha_emision = date('d')." de ".$meses[date('n')-1]." del ".date('Y');
        // $qr = QrCode::encoding('UTF-8')->size(100)->generate("GRADO: $personal->gra_abreviatura$personal->estu_abreviatura\nAPELLIDO(S): $personal->per_paterno $personal->per_materno\nNOMBRE(S): $personal->per_nombre\nC.M.: $personal->per_cm\nC.I.: $personal->per_ci $personal->per_expedido\nFECHA: $fecha_emision");
        // $codigo = $qr;

        $pdf = PDF::loadView('reportes.cuadroEfectivos',['grados_cant'=>$grados_cant,
                                                        'destinos'=>$destinos,
                                                        'cantidad'=>$cantidad,
                                                        'cantidad2'=>$cantidad2,
                                                        'jefe_dpto'=>$jefe_dpto
                                                            ])

        ->setPaper(array(0, 0, 612.28, 935.43), 'landscape');                                               
        
        return $pdf->stream('reporte.pdf');
    }

    public function destact(Request $request)
    {
        $per_codigo = $request->per_codigo;

        if($per_codigo==''){
            $personal_destinos = DB::table("personal_destinos")
            ->orderBy('personal_destinos.id','desc')
            ->paginate(10);     
        }
        else
        
        {
            $personal_destinos = DB::table("personal_destinos")
            ->join('personals','personal_destinos.per_codigo','=','personals.per_codigo')
            ->join('nivel1_destinos','personal_destinos.d1_cod','=','nivel1_destinos.id')
            ->join('nivel2_destinos','personal_destinos.d2_cod','=','nivel2_destinos.id')
            ->join('nivel3_destinos','personal_destinos.d3_cod','=','nivel3_destinos.id')
            ->join('nivel4_destinos','personal_destinos.d4_cod','=','nivel4_destinos.id')
            ->join('personal_cargos','personal_destinos.id','=','personal_cargos.dest_cod')
            ->join('cargos','personal_cargos.car_cod','=','cargos.id')
            ->leftjoin('grados','personal_destinos.gra_cod','=','grados.id')
            ->select('personal_destinos.id as idpersonal_destinos',
                    'nivel1_destinos.descripcion as desc_dn1',
                    'nivel2_destinos.descripcion as desc_dn2',
                    'nivel3_destinos.descripcion as desc_dn3',
                    'nivel4_destinos.descripcion as desc_dn4',
                    'personal_destinos.per_codigo',
                    'personal_destinos.tipo_doc',
                    'personal_destinos.nro_doc',
                    'personal_destinos.fecha_destino as fechadestino',
                    'personal_destinos.promocion',
                    'cargos.descripcion as cargo',

                    DB::raw("(CASE WHEN date_part('DAY',personal_destinos.fecha_destino)=31 and date_part('MONTH',personal_destinos.fecha_destino)=12 
                    THEN cast(date_part('YEAR',personal_destinos.fecha_destino + INTERVAL '1 YEAR') as varchar)
                    ELSE cast(personal_destinos.fecha_destino as varchar) END)
                    as fecha_final")
                    )
            ->where('personal_destinos.per_codigo', '=', $per_codigo)
            ->where('personal_cargos.nivel_cargo',1)
            ->where('personal_destinos.flag',1)
            ->where('personal_destinos.estado',1)
            ->orderBy('personal_destinos.fecha_destino','desc')
            ->first();

            $personal_destinos2 = DB::table("personal_destinos")
            ->join('personals','personal_destinos.per_codigo','=','personals.per_codigo')
            ->join('nivel1_destinos','personal_destinos.d1_cod','=','nivel1_destinos.id')
            ->join('nivel2_destinos','personal_destinos.d2_cod','=','nivel2_destinos.id')
            ->join('nivel3_destinos','personal_destinos.d3_cod','=','nivel3_destinos.id')
            ->join('nivel4_destinos','personal_destinos.d4_cod','=','nivel4_destinos.id')
            ->join('personal_cargos','personal_destinos.id','=','personal_cargos.dest_cod')
            ->join('cargos','personal_cargos.car_cod','=','cargos.id')
            ->select('personal_destinos.id as idpersonal_destinos',
                    'nivel1_destinos.descripcion as desc_dn1',
                    'nivel2_destinos.descripcion as desc_dn2',
                    'nivel3_destinos.descripcion as desc_dn3',
                    'nivel4_destinos.descripcion as desc_dn4',
                    'personal_destinos.per_codigo',
                    'personal_destinos.tipo_doc',
                    'personal_destinos.nro_doc',
                    'personal_destinos.fecha_destino as fechadestino',
                    'cargos.descripcion as cargo2'
                    )
            ->where('personal_destinos.per_codigo', '=', $per_codigo)
            ->where('personal_cargos.nivel_cargo',2)
            ->where('personal_destinos.flag',1)
            ->where('personal_destinos.estado',1)
            ->orderBy('personal_destinos.fecha_destino','desc')
            ->first();

        }

            return response()->json(['cargo1' => $personal_destinos,'cargo2' => $personal_destinos2]);
        
    }
}