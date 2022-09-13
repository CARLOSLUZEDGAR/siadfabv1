<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Personal;
use App\Personal_ascensos_promocion;
use App\Ascenso;
use App\PersonalCargo;
use App\PersonalCursos;
use App\PersonalDestinos;
use App\PersonalEscalafon;
use App\PersonalEspecialidades;
use App\PersonalEstudio;
use App\PersonalLocalidades;
use App\PersonalPericia;
use App\PersonalSituacion;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PersonalController extends Controller
{

    /**
     * FUNCION PARA EL LISTADOR DE PERSONAL EN TIEMPO REAL
     */

    public function ListadorPersonal(Request $request)
    {
        switch (Auth::user()->seccion) {
            case 1:
                $datos = [1];
                break;
            case 2:
                $datos = [2,3];
                break;
            case 3:
                $datos = [4];
                break;
            case 4:
                $datos = [1,2,3,4,5];
                break;
        }


        if ($request->buscar == '') {
            $personal = DB::connection('pgsql_server')->table('personal_escalafones as pe')
                    ->join('subescalafones as se','pe.subesc_cod','se.id')
                    ->join('personals as p','pe.per_codigo','p.per_codigo')
                    ->join('grados as g','pe.gra_cod','g.id')
                    ->join('personal_estudios as pes','p.per_codigo','pes.per_codigo')
                    ->join('estudios as e','pes.est_cod','e.id')
                    ->select('g.id as gid','se.id as subescalafon','p.per_codigo','g.abreviatura as grado','e.abreviatura as complemento','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','p.per_cm as cm','p.per_ci as ci')
                    ->where('pe.estado',1)
                    ->whereIn('g.division',$datos)
                    ->where('pes.estado',1)
                    ->orderBy('pe.esca_cod')
                    ->orderBy('se.orden')
                    ->orderBy('g.orden')
                    ->orderBy('p.per_cm')
                    ->paginate(10);
        } else {
            $personal = DB::connection('pgsql_server')->table('personal_escalafones as pe')
                    ->join('subescalafones as se','pe.subesc_cod','se.id')
                    ->join('personals as p','pe.per_codigo','p.per_codigo')
                    ->join('grados as g','pe.gra_cod','g.id')
                    ->join('personal_estudios as pes','p.per_codigo','pes.per_codigo')
                    ->join('estudios as e','pes.est_cod','e.id')
                    ->select('g.id as gid','se.id as subescalafon','p.per_codigo','g.abreviatura as grado','e.abreviatura as complemento','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','p.per_cm as cm','p.per_ci as ci')
                    ->where($request->criterio,'LIKE','%'.$request->buscar.'%')
                    ->whereIn('g.division',$datos)
                    ->where('pe.estado',1)
                    ->where('pes.estado',1)
                    ->orderBy('pe.esca_cod')
                    ->orderBy('se.orden')
                    ->orderBy('g.orden')
                    ->orderBy('p.per_cm')
                    ->paginate(10);
        }
        
        

        return response()->json([
            'pagination' => [
                'total'         => $personal->total(),
                'current_page'  => $personal->currentPage(),
                'per_page'      => $personal->perPage(),
                'last_page'     => $personal->lastPage(),
                'from'          => $personal->firstItem(),
                'to'            => $personal->lastItem(),
            
            ],
            'personal' => $personal
        ]); 
    }

    public function ListadorPersonalSofSgto(Request $request)
    {
        // if ($request->buscar == '') {
        //     $personal = DB::table('personal_escalafones as pe')
        //             ->join('subescalafones as se','pe.subesc_cod','se.id')
        //             ->join('personals as p','pe.per_codigo','p.per_codigo')
        //             ->join('grados as g','pe.gra_cod','g.id')
        //             ->join('personal_estudios as pes','p.per_codigo','pes.per_codigo')
        //             ->join('estudios as e','pes.est_cod','e.id')
        //             ->select('g.id as gid','se.id as subescalafon','p.per_codigo','g.abreviatura as grado','e.abreviatura as complemento','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','p.per_cm as cm','p.per_ci as ci')
        //             ->where('pe.estado',1)
        //             ->where('g.division',2)
        //             ->where('pes.estado',1)
        //             ->orderBy('pe.esca_cod')
        //             ->orderBy('se.orden')
        //             ->orderBy('g.orden')
        //             ->orderBy('p.per_cm')
        //             ->paginate(10);
        // } else {
        //     $personal = DB::table('personal_escalafones as pe')
        //             ->join('subescalafones as se','pe.subesc_cod','se.id')
        //             ->join('personals as p','pe.per_codigo','p.per_codigo')
        //             ->join('grados as g','pe.gra_cod','g.id')
        //             ->join('personal_estudios as pes','p.per_codigo','pes.per_codigo')
        //             ->join('estudios as e','pes.est_cod','e.id')
        //             ->select('g.id as gid','se.id as subescalafon','p.per_codigo','g.abreviatura as grado','e.abreviatura as complemento','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','p.per_cm as cm','p.per_ci as ci')
        //             ->where($request->criterio,'LIKE','%'.$request->buscar.'%')
        //             ->where('g.division',2)
        //             ->where('pe.estado',1)
        //             ->where('pes.estado',1)
        //             ->orderBy('pe.esca_cod')
        //             ->orderBy('se.orden')
        //             ->orderBy('g.orden')
        //             ->orderBy('p.per_cm')
        //             ->paginate(10);
        // }
        
        

        // return response()->json([
        //     'pagination' => [
        //         'total'         => $personal->total(),
        //         'current_page'  => $personal->currentPage(),
        //         'per_page'      => $personal->perPage(),
        //         'last_page'     => $personal->lastPage(),
        //         'from'          => $personal->firstItem(),
        //         'to'            => $personal->lastItem(),
            
        //     ],
        //     'personal' => $personal
        // ]); 
    }


    //////////////////////////////////////////////////////////////

    public function ListarAscensoPersona(Request $request){
        // $id = $request->per_codigo;
        // $listaascensos = DB::table('personal_ascensos_promocions as pp')
        //     ->join('personal as p','pp.percod','p.per_codigo')
        //     ->join('ascensos as a','pp.codasc','a.asc_cod')
        //     ->join('grados as g','pp.gracod','g.id')
        //     ->select('g.gra_abreviatura as grados','g.id','a.asc_nrodocumento','a.asc_documento as doc','a.asc_fechadocumento as fechadoc','pp.antiguedad','pp.codpromo','pp.promoact','pp.antigfin','pp.id as id_ascenso','pp.codasc','pp.instancia','pp.observaciones','p.per_codigo as personal_id','pp.fechasc')
        //     ->where('pp.percod','=',$id)
        //     ->orderBy('pp.gracod','asc')
        //     ->get();

        //     return response()->json($listaascensos);
    }

    public function ListarAscensoPersonaReporte(Request $request){
        // $id = $request->per_codigo;
        // $listaascensos = DB::table('personal_ascensos_promocions as pp')
        //     ->join('personal as p','pp.percod','p.per_codigo')
        //     ->join('ascensos as a','pp.codasc','a.asc_cod')
        //     ->join('grados as g','pp.gracod','g.id')
        //     ->select('g.gra_abreviatura as grados','g.id','a.asc_nrodocumento','a.asc_documento as doc','a.asc_fechadocumento as fechadoc','pp.antiguedad','pp.codpromo','pp.promoact','pp.antigfin','pp.codasc','pp.instancia','pp.observaciones','p.per_codigo as personal_id','pp.fechasc')
        //     ->where('pp.percod','=',$id)
        //     ->orderBy('pp.gracod','asc')
        //     ->get();

        // $personal = Personal::join('personal_escalafones','personal.per_codigo','=','personal_escalafones.per_codigo')
        //     ->join('grados','personal_escalafones.gra_cod','=','grados.id')
        //     ->join('estudio_personal','personal.per_codigo','=','estudio_personal.per_codigo')
        //     ->join('estudio','estudio_personal.est_codigo','=','estudio.id')
        //    ->select('personal.id','personal.per_codigo as personal_id', 'personal.per_paterno','personal.per_nombre','personal.per_materno','personal.per_ci',
        //    'personal.per_cm','personal.per_promo','personal_escalafones.gra_cod','personal_escalafones.per_codigo','grados.abreviatura','estudio.estu_abreviatura','personal.per_sexo')
        //    ->where('personal_escalafones.escap_flag','=',1)->where('estudio_personal.estp_flag','=',1)->where('personal.per_codigo','=',$id)
        //    ->first();
        //  //return response()->json($personals);

        //     $pdf = PDF::loadView('reportes.personalDestinos',['ascensosPersona'=>$listaascensos, 'personal'=>$personal])
        //     ->setPaper('letter', 'portrait');

        //     return $pdf->stream('reporte.pdf');
    }

    public function listarEscalafonPersonal(Request $request){
        // $id = $request->per_codigo;

        // $listarEscalafon = DB::table('personal_escalafones')
        //    ->join('personal','personal_escalafones.per_codigo','personal.per_codigo')
        //     ->join('grados','personal_escalafones.gra_cod','grados.id')
        //     ->join('escalafones','personal_escalafones.esca_codigo','escalafones.esca_codigo')
        //     ->join('subescalafones','personal_escalafones.subesc_codigo','subescalafones.id')
        //     ->select('grados.gra_abreviatura as grados','grados.id', 'escalafones.esca_nombre', 'escalafones.esca_codigo as escalafon_id', 'subescalafones.subesc_nombre','subescalafones.id',
        //     'personal_escalafones.esca_codigo','personal_escalafones.subesc_codigo','personal_escalafones.gra_cod','personal_escalafones.escap_flag',
        //     'personal_escalafones.escap_documento','personal_escalafones.escap_fecha_doc','personal_escalafones.escap_fecha','personal_escalafones.escap_observaciones',
        //     'personal_escalafones.escap_cm','personal_escalafones.sys_user','personal_escalafones.nro_doc','personal_escalafones.id',
        //     'personal.per_codigo as personal_id')
        //     ->where('personal_escalafones.per_codigo','=',$id)
        //     ->orderBy('personal_escalafones.id','desc')
        //     ->get();

        // return response()->json($listarEscalafon);

    }

    public function listperdest(Request $request)
    {
       // if(!$request->ajax()) return redirect('/');//si la peticion no es tipo ajax que nos rerotne a la pagina prncipal
        // $buscar = $request->buscar;
        // $criterio = $request->criterio;

        // if($criterio == 'per_cm'){
        //      $personal = DB::table('personals')
        //     ->leftjoin('personal_escalafones','personals.per_codigo','personal_escalafones.per_codigo')
        //     ->leftjoin('escalafones','escalafones.id','personal_escalafones.esca_cod')
        //     ->leftjoin('subescalafones','subescalafones.id','personal_escalafones.subesc_cod')
        //     ->leftjoin('grados','grados.id','personal_escalafones.gra_cod')
        //     ->leftjoin('personal_estudios','personal_estudios.per_codigo','personals.per_codigo')
        //     ->leftjoin('estudios','estudios.id','personal_estudios.est_cod')
        //     ->select('personals.per_codigo',
        //             'personals.per_paterno',
        //             'personals.per_materno',
        //             'personals.per_nombre',
        //             'personals.per_sexo',
        //             'personals.per_ci',
        //             'personals.per_cm',
        //             'grados.abreviatura as gra_abreviatura',
        //             'estudios.abreviatura as estu_abreviatura',
        //             'personal_escalafones.estado as escperestado',
        //             'personal_estudios.id as estperid',
        //             'escalafones.id as escalofonesid',
        //             'subescalafones.id as subescalafonesid')
        //     ->where('personal_escalafones.estado',1)
        //     ->where('personal_estudios.estado',1)
        //     ->where('personals.per_cm','like',$buscar.'%')
        //     ->orderBy('grados.id','asc')
        //     ->orderBy('personals.per_cm','asc')
        //     ->take(1)
        //     ->paginate(10);
        // }
        // elseif($criterio == 'per_ci'){
        //     $personal = DB::table('personals')
        //     ->leftjoin('personal_escalafones','personals.per_codigo','personal_escalafones.per_codigo')
        //     ->leftjoin('escalafones','escalafones.id','personal_escalafones.esca_cod')
        //     ->leftjoin('subescalafones','subescalafones.id','personal_escalafones.subesc_cod')
        //     ->leftjoin('grados','grados.id','personal_escalafones.gra_cod')
        //     ->leftjoin('personal_estudios','personal_estudios.per_codigo','personals.per_codigo')
        //     ->leftjoin('estudios','estudios.id','personal_estudios.est_cod')
        //     ->select('personals.per_codigo',
        //             'personals.per_paterno',
        //             'personals.per_materno',
        //             'personals.per_nombre',
        //             'personals.per_sexo',
        //             'personals.per_ci',
        //             'personals.per_cm',
        //             'grados.abreviatura as gra_abreviatura',
        //             'estudios.abreviatura as estu_abreviatura',
        //             'personal_escalafones.estado as escperestado',
        //             'personal_estudios.id as estperid',
        //             'escalafones.id as escalofonesid',
        //             'subescalafones.id as subescalafonesid')
        //     ->where('personal_escalafones.estado',1)
        //     ->where('personal_estudios.estado',1)
        //     ->where('personals.per_ci','like','%'.$buscar.'%')
        //     ->orderBy('grados.id','asc')
        //     ->orderBy('personals.per_cm','asc')
        //     ->take(1)
        //     ->paginate(10);
        // }
        // elseif($criterio == 'per_paterno'){
        //     $personal = DB::table('personals')
        //     ->leftjoin('personal_escalafones','personals.per_codigo','personal_escalafones.per_codigo')
        //     ->leftjoin('escalafones','escalafones.id','personal_escalafones.esca_cod')
        //     ->leftjoin('subescalafones','subescalafones.id','personal_escalafones.subesc_cod')
        //     ->leftjoin('grados','grados.id','personal_escalafones.gra_cod')
        //     ->leftjoin('personal_estudios','personal_estudios.per_codigo','personals.per_codigo')
        //     ->leftjoin('estudios','estudios.id','personal_estudios.est_cod')
        //     ->select('personals.per_codigo',
        //             'personals.per_paterno',
        //             'personals.per_materno',
        //             'personals.per_nombre',
        //             'personals.per_sexo',
        //             'personals.per_ci',
        //             'personals.per_cm',
        //             'grados.abreviatura as gra_abreviatura',
        //             'estudios.abreviatura as estu_abreviatura',
        //             'personal_escalafones.estado as escperestado',
        //             'personal_estudios.id as estperid',
        //             'escalafones.id as escalofonesid',
        //             'subescalafones.id as subescalafonesid')
        //     ->where('personal_escalafones.estado',1)
        //     ->where('personal_estudios.estado',1)
        //     ->where('personals.per_paterno','like','%'.$buscar.'%')
        //     ->orderBy('grados.id','asc')
        //     ->orderBy('personals.per_cm','asc')
        //     ->take(1)
        //     ->paginate(10);
        // }
        // elseif($criterio == 'per_materno'){
        //     $personal = DB::table('personals')
        //     ->leftjoin('personal_escalafones','personals.per_codigo','personal_escalafones.per_codigo')
        //     ->leftjoin('escalafones','escalafones.id','personal_escalafones.esca_cod')
        //     ->leftjoin('subescalafones','subescalafones.id','personal_escalafones.subesc_cod')
        //     ->leftjoin('grados','grados.id','personal_escalafones.gra_cod')
        //     ->leftjoin('personal_estudios','personal_estudios.per_codigo','personals.per_codigo')
        //     ->leftjoin('estudios','estudios.id','personal_estudios.est_cod')
        //     ->select('personals.per_codigo',
        //             'personals.per_paterno',
        //             'personals.per_materno',
        //             'personals.per_nombre',
        //             'personals.per_sexo',
        //             'personals.per_ci',
        //             'personals.per_cm',
        //             'grados.abreviatura as gra_abreviatura',
        //             'estudios.abreviatura as estu_abreviatura',
        //             'personal_escalafones.estado as escperestado',
        //             'personal_estudios.id as estperid',
        //             'escalafones.id as escalofonesid',
        //             'subescalafones.id as subescalafonesid')
        //     ->where('personal_escalafones.estado',1)
        //     ->where('personal_estudios.estado',1)
        //     ->where('personals.per_materno','like','%'.$buscar.'%')
        //     ->orderBy('grados.id','asc')
        //     ->orderBy('personals.per_cm','asc')
        //     ->take(1)
        //     ->paginate(10);
        // }
        // elseif($criterio == 'per_nombre'){
        //     $personal = DB::table('personals')
        //     ->leftjoin('personal_escalafones','personals.per_codigo','personal_escalafones.per_codigo')
        //     ->leftjoin('escalafones','escalafones.id','personal_escalafones.esca_cod')
        //     ->leftjoin('subescalafones','subescalafones.id','personal_escalafones.subesc_cod')
        //     ->leftjoin('grados','grados.id','personal_escalafones.gra_cod')
        //     ->leftjoin('personal_estudios','personal_estudios.per_codigo','personals.per_codigo')
        //     ->leftjoin('estudios','estudios.id','personal_estudios.est_cod')
        //     ->select('personals.per_codigo',
        //             'personals.per_paterno',
        //             'personals.per_materno',
        //             'personals.per_nombre',
        //             'personals.per_sexo',
        //             'personals.per_ci',
        //             'personals.per_cm',
        //             'grados.abreviatura as gra_abreviatura',
        //             'estudios.abreviatura as estu_abreviatura',
        //             'personal_escalafones.estado as escperestado',
        //             'personal_estudios.id as estperid',
        //             'escalafones.id as escalofonesid',
        //             'subescalafones.id as subescalafonesid')
        //     ->where('personal_escalafones.estado',1)
        //     ->where('personal_estudios.estado',1)
        //     ->where('personals.per_nombre','like','%'.$buscar.'%')
        //     ->orderBy('grados.id','asc')
        //     ->orderBy('personals.per_cm','asc')
        //     ->take(1)
        //     ->paginate(10);
        // }

        // return [
        //     'pagination' => [
        //         'total'         => $personal->total(),
        //         'current_page'  => $personal->currentPage(),
        //         'per_page'      => $personal->perPage(),
        //         'last_page'     => $personal->lastPage(),
        //         'from'          => $personal->firstItem(),
        //         'to'            => $personal->lastItem(),

        //     ],
        //     'personal' => $personal
        // ];
        // return response()->json($personal);
    }

    //LISTADO DE PERSONAL DE PABLO
    public function listadoPersona(Request $request)
    {
        // if(!$request->ajax()) return view('/');

        // $buscar = $request->buscar;
        // $criterio = $request->criterio;

        // if ($buscar == "") {
        //     $personal = DB::table('personals as p')
        //                     ->join('personal_escalafones as peresca','p.per_codigo','peresca.per_codigo')
        //                     ->join('grados as g','peresca.gra_cod','g.id')
        //                     ->join('personal_estudios as estp','p.per_codigo','estp.per_codigo')
        //                     ->join('estudios as e','estp.est_cod','e.id')
        //                     ->join('escalafones as esc','peresca.esca_cod','esc.id')
        //                     ->select('g.abreviatura as gra_abreviatura','e.abreviatura as estu_abreviatura','p.per_codigo','p.per_nombre',
        //                             'p.per_paterno','p.per_materno','p.per_sexo','p.per_expedido','p.per_fecha_nacimiento',
        //                             'p.per_estado_civil','p.per_ci','p.per_telefono','p.per_celular','p.per_mail',
        //                             'p.per_cm','p.per_promo','peresca.subesc_cod as subescalafon')
        //                     ->where('peresca.estado','1')
        //                     ->where('estp.estado','1')
        //                     ->where('esc.nombre','=','ARMAS')
        //                     ->orderBy('g.id','asc')
        //                     ->orderBy('e.id','asc')
        //                     ->orderBy('p.per_codigo','asc')
        //                     ->paginate(15);
        // }else{
        //     $personal = DB::table('personals as p')
        //                     ->join('personal_escalafones as peresca','p.per_codigo','peresca.per_codigo')
        //                     ->join('grados as g','peresca.gra_cod','g.id')
        //                     ->join('personal_estudios as estp','p.per_codigo','estp.per_codigo')
        //                     ->join('estudios as e','estp.est_cod','e.id')
        //                     ->join('escalafones as esc','peresca.esca_cod','esc.id')
        //                     ->select('g.abreviatura as gra_abreviatura','e.abreviatura as estu_abreviatura','p.per_codigo','p.per_nombre',
        //                             'p.per_paterno','p.per_materno','p.per_sexo','p.per_expedido','p.per_fecha_nacimiento',
        //                             'p.per_estado_civil','p.per_ci','p.per_telefono','p.per_celular','p.per_mail',
        //                             'p.per_cm','p.per_promo','peresca.subesc_cod as subescalafon')
        //                     ->where('peresca.estado','1')
        //                     ->where('estp.estado','1')
        //                     ->where('esc.nombre','=','ARMAS')
        //                     ->orderBy('g.id','asc')
        //                     ->orderBy('e.id','asc')
        //                     ->where($criterio,'like','%'.$buscar.'%')
        //                     ->orderBy('p.per_codigo','asc')
        //                     ->paginate(15);
        // }
        // return [
        //     'pagination' => [
        //         'total'         =>  $personal->total(),
        //         'current_page'  =>  $personal->currentPage(),
        //         'per_page'      =>  $personal->perPage(),
        //         'last_page'     =>  $personal->lastPage(),
        //         'from'          =>  $personal->firstItem(),
        //         'to'            =>  $personal->lastItem(),
        //     ],
        //     'personal'          =>  $personal
        // ];
    }

    //LISTADO DE PERSONAL DE PABLO
    public function listaPersonalCursos(Request $request)
    {
        // if(!$request->ajax()) return view('/');

        // $buscar = $request->buscar;
        // $criterio = $request->criterio;
        // $personal = [];

        // if ($buscar != "") {
        //     $personal = DB::table('personals as p')
        //                     ->join('personal_escalafones as peresca','p.per_codigo','peresca.per_codigo')
        //                     ->join('grados as g','peresca.gra_cod','g.id')
        //                     ->join('personal_estudios as estp','p.per_codigo','estp.per_codigo')
        //                     ->join('estudios as e','estp.est_cod','e.id')
        //                     ->join('escalafones as esc','peresca.esca_cod','esc.id')
        //                     ->select('g.abreviatura as gra_abreviatura','e.abreviatura as estu_abreviatura','p.per_codigo','p.per_nombre',
        //                             'p.per_paterno','p.per_materno','p.per_sexo','p.per_expedido','p.per_fecha_nacimiento',
        //                             'p.per_estado_civil','p.per_ci','p.per_telefono','p.per_celular','p.per_mail',
        //                             'p.per_cm','p.per_promo','peresca.subesc_cod as subescalafon')
        //                     ->where('peresca.estado','1')
        //                     ->where('estp.estado','1')
        //                     ->orderBy('g.id','asc')
        //                     ->orderBy('e.id','asc')
        //                     ->where($criterio,'like','%'.$buscar.'%')
        //                     ->orderBy('p.per_codigo','asc')
        //                     ->paginate(15);

        //     return [
        //         'pagination' => [
        //             'total'         =>  $personal->total(),
        //             'current_page'  =>  $personal->currentPage(),
        //             'per_page'      =>  $personal->perPage(),
        //             'last_page'     =>  $personal->lastPage(),
        //             'from'          =>  $personal->firstItem(),
        //             'to'            =>  $personal->lastItem(),
        //         ],
        //         'personal'          =>  $personal
        //     ];
        // }
    }

    //LISTADO DE PERSONAL DE PABLO
    public function listarPersonalTribunal(Request $request)
    {
        // if(!$request->ajax()) return view('/');

        // $buscar = $request->buscar;
        // $criterio = $request->criterio;
        // $personal = [];

        // if ($buscar != "") {
        //     $personal = DB::table('personals as p')
        //                     ->join('personal_escalafones as peresca','p.per_codigo','peresca.per_codigo')
        //                     ->join('grados as g','peresca.gra_cod','g.id')
        //                     ->join('personal_estudios as estp','p.per_codigo','estp.per_codigo')
        //                     ->join('estudios as e','estp.est_cod','e.id')
        //                     ->join('escalafones as esc','peresca.esca_cod','esc.id')
        //                     ->select('g.abreviatura as gra_abreviatura','e.abreviatura as estu_abreviatura','p.per_codigo','p.per_nombre',
        //                             'p.per_paterno','p.per_materno','p.per_sexo','p.per_expedido','p.per_fecha_nacimiento',
        //                             'p.per_estado_civil','p.per_ci','p.per_telefono','p.per_celular','p.per_mail',
        //                             'p.per_cm','p.per_promo','peresca.subesc_cod as subescalafon')
        //                     ->where('peresca.estado','1')
        //                     ->where('estp.estado','1')
        //                     ->whereIn('g.id',[1,2,3,4,5,10,11,164,165])
        //                     ->where('esc.nombre','=','ARMAS')
        //                     ->orderBy('g.id','asc')
        //                     ->orderBy('e.id','asc')
        //                     ->where($criterio,'like','%'.$buscar.'%')
        //                     ->orderBy('p.per_codigo','asc')
        //                     ->paginate(15);

        //     return [
        //         'pagination' => [
        //             'total'         =>  $personal->total(),
        //             'current_page'  =>  $personal->currentPage(),
        //             'per_page'      =>  $personal->perPage(),
        //             'last_page'     =>  $personal->lastPage(),
        //             'from'          =>  $personal->firstItem(),
        //             'to'            =>  $personal->lastItem(),
        //         ],
        //         'personal'          =>  $personal
        //     ];
        // }
    }

    public function listarfam(Request $request)
    {
        // $buscar = $request->buscar;
        // $criterio = $request->criterio;

        // if($buscar==''){


        // }
        // else
        // {
        //     $personals = Personal::join('personal_escalafones','personals.per_codigo','=','personal_escalafones.per_codigo')
        //     ->join('grados','personal_escalafones.gra_cod','=','grados.id')
        //     ->join('personal_estudios','personals.per_codigo','=','personal_estudios.per_codigo')
        //     ->join('estudios','personal_estudios.est_cod','=','estudios.id')
        //    ->select('personals.per_codigo as personal_id', 'personals.per_paterno','personals.per_nombre',
        //    'personals.per_materno','personals.per_ci','personals.per_cm','personals.per_promo',
        //    'personal_escalafones.gra_cod','personal_escalafones.per_codigo',
        //    'grados.abreviatura as grad','estudios.abreviatura')
        //    ->orderBy('grados.id','asc')
        //    ->where('personal_escalafones.estado','=',1)
        //    ->where('personal_estudios.estado','=',1)
        //    ->where($criterio, 'like', '%'.$buscar.'%')
        //    ->orderBy('per_cm', 'asc')->paginate(10);


        // }
        // return[
        //     'pagination' => [
        //         'total'         => $personals->total(),
        //         'current_page'  => $personals->currentPage(),
        //         'per_page'      => $personals->perPage(),
        //         'last_page'     => $personals->lastPage(),
        //         'from'          => $personals->firstItem(),
        //         'to'            => $personals->lastItem(),
        //     ],
        //     'personals' => $personals
        // ];
    }

    public function index(Request $request)
    {
        // $buscar = $request->buscar;
        // $criterio = $request->criterio;

        // if($buscar==''){

        //     $personals= Personal::join('personal_escalafones','personals.per_codigo','=','personal_escalafones.per_codigo')
        //                         ->join('grados','personal_escalafones.gra_cod','=','grados.id')
        //                         ->join('personal_estudios','personals.per_codigo','=','personal_estudios.per_codigo')
        //                         ->join('estudios','personal_estudios.est_cod','=','estudios.id')
        //                         ->select('personals.per_codigo as personal_id', 
        //                                 'personals.per_paterno','personals.per_nombre',
        //                                 'personals.per_materno','personals.per_ci',
        //                                 'personals.per_cm','personals.per_promo',
        //                                 'personal_escalafones.gra_cod',
        //                                 'personal_escalafones.per_codigo',
        //                                 'grados.abreviatura','estudios.abreviatura')
        //                         ->where('personal_escalafones.estado','=',1)
        //                         ->where('personal_estudios.estado','=',1)
        //                         ->orderBy('personals.per_cm', 'asc')
        //                         ->paginate(10);
        // }
        // else
        // {
        //     $personals = Personal::join('personal_escalafones','personals.per_codigo','=','personal_escalafones.per_codigo')
        //     ->join('grados','personal_escalafones.gra_cod','=','grados.id')
        //     ->join('personal_estudios','personals.per_codigo','=','personal_estudios.per_codigo')
        //     ->join('estudios','personal_estudios.est_cod','=','estudios.id')
        //    ->select('personals.per_codigo as personal_id', 'personals.per_paterno','personals.per_nombre',
        //    'personals.per_materno','personals.per_ci','personals.per_cm','personals.per_promo',
        //    'personal_escalafones.gra_cod','personal_escalafones.per_codigo',
        //    'grados.abreviatura','estudios.abreviatura')
        //    ->where('personal_escalafones.estado','=',1)
        //    ->where('personal_estudios.estado','=',1)
        //    ->where($criterio, 'like', '%'.$buscar.'%')
        //    ->orderBy('per_cm', 'asc')->paginate(10);


        // }
        // return[
        //     'pagination' => [
        //         'total'         => $personals->total(),
        //         'current_page'  => $personals->currentPage(),
        //         'per_page'      => $personals->perPage(),
        //         'last_page'     => $personals->lastPage(),
        //         'from'          => $personals->firstItem(),
        //         'to'            => $personals->lastItem(),
        //     ],
        //     'personals' => $personals
        // ];
    }
    public function DatosPersonales(Request $request)
    {
        // $percodigo = $request->percodigo;
        // $datos = DB::table('personal_escalafones as ep')
        //     ->join('personals as p','ep.per_codigo','p.per_codigo')
        //     ->join('grados as g','ep.gra_cod','g.id')
        //     ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
        //     ->join('estudios as e','epe.est_cod','e.id')
        //     ->select('p.per_codigo as codigo','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','p.per_cm as cm',
        //                 'p.per_fecha_nacimiento as fechaNacimiento','p.per_sexo as genero', 'p.per_ci as ci', 'p.per_expedido as expedido', 'p.per_celular as celular',
        //                 'p.per_estado_civil as estadoCivil', 'p.per_seguro as seguro', 'p.per_serv_mil as servMil', 'p.per_religion as religion',
        //                 'p.per_mail as email','g.abreviatura as grado','e.abreviatura as complemento')
        //     ->where('ep.per_codigo',$percodigo)
        //     ->where('ep.estado',1)
        //     ->where('epe.estado',1)
        //     ->first();

        //     return response()->json($datos);
    }

    public function ListarPersonal(Request $request)
    {
        // $buscar = $request->buscar;
        // $criterio = $request->criterio;
        // $datos = [];

        // if ($buscar != "") {
        //     $datos = DB::table('personal_escalafones as ep')
        //     ->join('personals as p','ep.per_codigo','p.per_codigo')
        //     ->join('grados as g','ep.gra_cod','g.id')
        //     ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
        //     ->join('estudios as e','epe.est_cod','e.id')
        //     ->select('p.per_codigo as codigo','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','p.per_cm as cm',
        //                  'p.per_ci as ci', 'p.per_expedido as expedido', 'g.abreviatura as grado','e.abreviatura as complemento','p.per_religion')
        //     ->where($criterio,'like','%'.$buscar.'%')
        //     ->where('ep.estado',1)
        //     ->where('epe.estado',1)
        //     ->where('g.fuerza','FAB')
        //     ->orderBy('ep.esca_cod')
        //     ->orderBy('ep.subesc_cod')
        //     ->orderBy('g.orden')
        //     ->paginate(10);

        //     return response()->json([
        //         'pagination' => [
        //             'total'         => $datos->total(),
        //             'current_page'  => $datos->currentPage(),
        //             'per_page'      => $datos->perPage(),
        //             'last_page'     => $datos->lastPage(),
        //             'from'          => $datos->firstItem(),
        //             'to'            => $datos->lastItem(),

        //         ],
        //         'datos' => $datos,
        //         'code' => 200
        //     ]);
        // }else{
        //     return response()->json([

        //         'code' => 400
        //     ]);
        // }

    }


    public function VerDatosPersonales(Request $request)
    {
        // $percodigo = $request->per_codigo;
        // $datos = DB::table('personal_escalafones as ep')
        //     ->join('personals as p','ep.per_codigo','p.per_codigo')
        //     ->join('grados as g','ep.gra_cod','g.id')
        //     ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
        //     ->join('estudios as e','epe.est_cod','e.id')
        //     ->join('personal_localidades','p.per_codigo','=','personal_localidades.per_codigo')
        //     ->select(   'p.per_codigo as codigo',
        //         'p.per_paterno as paterno',
        //         'p.per_materno as materno',
        //         'p.per_nombre as nombre',
        //         'p.per_cm as cm',
        //         'p.per_foto',
        //         'p.per_fecha_nacimiento as fechaNacimiento',
        //         'p.per_estado_civil as estadoCivil',
        //         'p.per_sexo as genero',
        //         'p.per_ci as ci',
        //         'p.per_expedido as expedido',
        //         'p.per_telefono as telefono',
        //         'p.per_celular as celular',
        //         'p.per_mail as email',
        //         'p.per_seguro as seguro',
        //         'p.per_serv_mil as servMil',
        //         'p.per_religion as religion',
        //         'g.abreviatura as grado',
        //         'p.per_boleta_pago',
        //         'p.per_ciudad',
        //         'p.per_zona',
        //         'p.per_calle',
        //         'e.abreviatura as complemento',

        //         'personal_localidades.depa_codigo',
        //         'personal_localidades.prov_codigo',
        //         'personal_localidades.loca_codigo',





        //         )
        //     ->where('ep.per_codigo',$percodigo)
        //     ->where('ep.estado',1)
        //     ->where('epe.estado',1)
        //     ->first();
        //     return response()->json(['datos' => $datos]);
    }

    /***************FUNCIONES PARA ACCESO DE SISTEMA********************* */
    /**
     * FUNCION PARA LISTAR PERSONAL EN UN SELECT-VUE
     */
    public function ListPersonal()
    {
        $datos = DB::connection('pgsql_server')->table('personal_escalafones as ep')
        ->join('personals as p','ep.per_codigo','p.per_codigo')
        ->join('grados as g','ep.gra_cod','g.id')
        ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
        ->join('estudios as e','epe.est_cod','e.id')
        ->join('personal_situaciones as ps', 'p.per_codigo','ps.per_codigo')
        ->select('p.per_codigo as codigo','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno', 'g.abreviatura as grado','e.abreviatura as complemento')
        ->where('ep.estado',1)
        ->where('epe.estado',1)
        ->where('ps.estado',1)
        ->whereIn('ps.detsit_cod',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
        ->where('g.fuerza','FAB')
        ->orderBy('ep.esca_cod')
        ->orderBy('ep.subesc_cod')
        ->orderBy('g.orden')
        ->get();

        $data = [];

        foreach ($datos as $key => $value) {
            $data[$key] = [
                'id' => $value->codigo,
                'text' => $value->grado.' '.$value->complemento.' '.$value->nombre.' '.$value->paterno.' '.$value->materno,
            ];
        }

        return response()->json($data);

    }

    /**
     * MUESTRA LOS DATOS PERSONAL DE UNA PERSONA
     */
    public function DatosPersonalesAcceso(Request $request)
    {
        $percodigo = $request->percodigo;
        $datos = DB::connection('pgsql_server')->table('personal_escalafones as ep')
            ->join('personals as p','ep.per_codigo','p.per_codigo')
            ->join('grados as g','ep.gra_cod','g.id')
            ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->join('personal_situaciones as ps','p.per_codigo','ps.per_codigo')
            ->join('subsituaciones as ss','ps.subsit_cod','ss.id')
            ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
            ->join('nivel3_destinos as nd3','pd.d3_cod','nd3.id')
            ->join('nivel2_destinos as nd2','pd.d2_cod','nd2.id')
            ->select('p.per_codigo as percodigo','p.per_foto as foto','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','p.per_cm as cm',
                        'p.per_ci as ci', 'p.per_expedido as expedido', 'p.per_mail as email','g.abreviatura as grado','e.abreviatura as complemento',
                        'ss.nombre as situacion','nd2.descripcion as des2','nd3.descripcion as des3')
            ->where('ep.per_codigo',$percodigo)
            ->where('ps.estado',1)
            ->where('ep.estado',1)
            ->where('epe.estado',1)
            ->where('pd.estado',1)
            ->first();

            return response()->json($datos);
    }

    // datos personales para demeritos
    public function DatosPersonalesDem(Request $request)
    {
        // $percodigo = $request->percodigo;
        // $datos = DB::table('personal_escalafones as ep')
        //     ->join('personals as p','ep.per_codigo','p.per_codigo')
        //     ->join('grados as g','ep.gra_cod','g.id')
        //     ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
        //     ->join('estudios as e','epe.est_cod','e.id')
        //     ->join('personal_situaciones as ps','p.per_codigo','ps.per_codigo')
        //     ->join('subsituaciones as ss','ps.subsit_cod','ss.id')
        //     ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
        //     ->select('p.per_codigo as codigo','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','p.per_cm as cm',
        //                 'p.per_ci as ci', 'p.per_expedido as expedido',
        //                 'g.id as gid','g.abreviatura as grado','g.division','g.nivFalta','e.abreviatura as complemento','e.id as comid','ss.nombre as situacion',
        //                 'pd.d1_cod as d1','pd.d2_cod as d2','pd.d3_cod as d3','pd.d4_cod as d4','g.divGra','p.per_foto as foto')
        //     ->where('ep.per_codigo',$percodigo)
        //     ->where('ps.estado',1)
        //     ->where('ep.estado',1)
        //     ->where('epe.estado',1)
        //     ->where('pd.estado',1)
        //     ->first();

        //     return response()->json($datos);
    }

    /**
     * LISTA AL PERSONAL DE UNA UNDAD CMPLETA Y REALIZA BUSQUEDA MEDIANTE
     * LOS CRITERIOS DE BUSQUEDA:
     *      -   NOMBRE                  -> p.per_nombre
     *      -   APELLIDOS PATERNO       -> p.per_paterno
     *      -   APELLIDOS MATERNO       -> p.per_matenro
     *      -   CARNET MILITAR          -> p.per_cm
     *      -   CARNET DE IDENTIDAD     -> p.per_ci
     *
     * NOTA: LA FUNCION SIRVE PARA EL LLENADO DE TABLAS
     */
    public function ListarPersonalUnidad(Request $request)
    {
        // $buscar = $request->buscar;
        // $criterio = $request->criterio;

        // $unidad = DB::table('personal_destinos')
        //         ->select('d3_cod')
        //         ->where('per_codigo',Auth::user()->percod)
        //         ->where('estado',1)
        //         ->first();

        // if ($buscar == "") {
        //     $datos = DB::table('personal_escalafones as ep')
        //         ->join('personals as p','ep.per_codigo','p.per_codigo')
        //         ->join('grados as g','ep.gra_cod','g.id')
        //         ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
        //         ->join('estudios as e','epe.est_cod','e.id')
        //         ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
        //         ->join('personal_situaciones as ps', 'p.per_codigo','ps.per_codigo')
        //         ->select('p.per_codigo as codigo','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','p.per_cm as cm',
        //                     'p.per_ci as ci', 'p.per_expedido as expedido', 'g.abreviatura as grado','e.abreviatura as complemento')
        //         ->where('ep.estado',1)
        //         ->where('pd.estado',1)
        //         ->where('epe.estado',1)
        //         ->where('ps.estado',1)
        //         ->where('pd.d3_cod', $unidad->d3_cod)
        //         ->whereIn('ps.detsit_cod',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
        //         ->where('g.fuerza','FAB')
        //         ->orderBy('ep.esca_cod')
        //         ->orderBy('ep.subesc_cod')
        //         ->orderBy('p.per_cm')
        //         ->orderBy('g.orden')
        //         ->paginate(15);
        // }else{
        //     $datos = DB::table('personal_escalafones as ep')
        //         ->join('personals as p','ep.per_codigo','p.per_codigo')
        //         ->join('grados as g','ep.gra_cod','g.id')
        //         ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
        //         ->join('estudios as e','epe.est_cod','e.id')
        //         ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
        //         ->join('personal_situaciones as ps', 'p.per_codigo','ps.per_codigo')
        //         ->select('p.per_codigo as codigo','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','p.per_cm as cm',
        //                     'p.per_ci as ci', 'p.per_expedido as expedido', 'g.abreviatura as grado','e.abreviatura as complemento')
        //         ->where('ep.estado',1)
        //         ->where('pd.estado',1)
        //         ->where('epe.estado',1)
        //         ->where('ps.estado',1)
        //         ->where('pd.d3_cod', $unidad->d3_cod)
        //         ->whereIn('ps.detsit_cod',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
        //         ->where('g.fuerza','FAB')
        //         ->where($criterio,'like','%'.$buscar.'%')
        //         ->orderBy('ep.esca_cod')
        //         ->orderBy('ep.subesc_cod')
        //         ->orderBy('p.per_cm')
        //         ->orderBy('g.orden')
        //         ->paginate(15);
        // }
        // return response()->json([
        //     'pagination' => [
        //         'total'         => $datos->total(),
        //         'current_page'  => $datos->currentPage(),
        //         'per_page'      => $datos->perPage(),
        //         'last_page'     => $datos->lastPage(),
        //         'from'          => $datos->firstItem(),
        //         'to'            => $datos->lastItem(),

        //     ],
        //     'datos' => $datos
        // ]);


    }




    /**
     * FUNCION PARA LISTAR PERSONAL CON GRADOS SUPERIORES
     * La funcion permite listar al personal que tenga mayor o similar rango
     * solo listara personal militar
     * Si es personal  civil devolvera todo el personal militar
     *
     * NOTA: LAS FUNCIONES SON PARA LLENAR DROPLIST
     */
    //FUNCION PARA LA VISTA DEPTO-I
    public function ListarPersonalTotal(Request $request)
    {
        // $datos = DB::table('personal_escalafones as ep')
        //         ->join('personals as p','ep.per_codigo','p.per_codigo')
        //         ->join('grados as g','ep.gra_cod','g.id')
        //         ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
        //         ->join('estudios as e','epe.est_cod','e.id')
        //         ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
        //         ->join('personal_situaciones as ps', 'p.per_codigo','ps.per_codigo')
        //         ->select('p.per_codigo as codigo','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno',
        //                      'g.abreviatura as grado','e.abreviatura as complemento')
        //         ->where('ep.estado',1)
        //         ->where('pd.estado',1)
        //         ->where('epe.estado',1)
        //         ->where('ps.estado',1)
        //         ->where('ep.esca_cod',1)
        //         ->where('p.per_codigo','<>',$request->percodigo)
        //         ->whereIn('ps.detsit_cod',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
        //         ->where('g.fuerza','FAB')
        //         ->where('g.divGra','<=',$request->divGra)
        //         ->orderBy('ep.esca_cod')
        //         ->orderBy('ep.subesc_cod')
        //         ->orderBy('g.orden')
        //         ->orderBy('p.per_cm')

        //         ->get();

        // $data = [];

        // foreach ($datos as $key => $value) {
        //     $data[$key] = [
        //         'id' => $value->codigo,
        //         'text' => $value->grado.' '.$value->complemento.' '.$value->nombre.' '.$value->paterno.' '.$value->materno,
        //     ];
        // }
        // return response()->json($data);


    }

    //FUNCION PARA LA VISTA UNIDAD
    public function ListarPersonalTotalUnidad(Request $request)
    {
        // $unidad = DB::table('personal_destinos')
        //         ->select('d3_cod')
        //         ->where('per_codigo',Auth::user()->percod)
        //         ->where('estado',1)
        //         ->first();

        // $datos = DB::table('personal_escalafones as ep')
        //         ->join('personals as p','ep.per_codigo','p.per_codigo')
        //         ->join('grados as g','ep.gra_cod','g.id')
        //         ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
        //         ->join('estudios as e','epe.est_cod','e.id')
        //         ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
        //         ->join('personal_situaciones as ps', 'p.per_codigo','ps.per_codigo')
        //         ->select('p.per_codigo as codigo','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno',
        //                      'g.abreviatura as grado','e.abreviatura as complemento')
        //         ->where('ep.estado',1)
        //         ->where('pd.estado',1)
        //         ->where('epe.estado',1)
        //         ->where('ps.estado',1)
        //         ->where('ep.esca_cod',1)
        //         ->where('p.per_codigo','<>',$request->percodigo)
        //         ->where('pd.d3_cod', $unidad->d3_cod)
        //         ->whereIn('ps.detsit_cod',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
        //         ->where('g.fuerza','FAB')
        //         ->where('g.divGra','<=',$request->divGra)
        //         ->orderBy('ep.esca_cod')
        //         ->orderBy('ep.subesc_cod')
        //         ->orderBy('p.per_cm')
        //         ->orderBy('g.orden')
        //         ->get();

        // $data = [];

        // foreach ($datos as $key => $value) {
        //     $data[$key] = [
        //         'id' => $value->codigo,
        //         'text' => $value->grado.' '.$value->complemento.' '.$value->nombre.' '.$value->paterno.' '.$value->materno,
        //     ];
        // }
        // return response()->json($data);


    }

    public function ListarPersonalExterna(Request $request)
    {
        // $buscar = $request->buscar;
        // $criterio = $request->criterio;
        // $datos = [];

        // $unidad = DB::table('personal_destinos')
        //         ->select('d3_cod')
        //         ->where('per_codigo',Auth::user()->percod)
        //         ->where('estado',1)
        //         ->first();

        // if ($buscar != "") {
        //     $datos = DB::table('personal_escalafones as ep')
        //     ->join('personals as p','ep.per_codigo','p.per_codigo')
        //     ->join('grados as g','ep.gra_cod','g.id')
        //     ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
        //     ->join('estudios as e','epe.est_cod','e.id')
        //     ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
        //     ->join('personal_situaciones as ps', 'p.per_codigo','ps.per_codigo')
        //     ->select('p.per_codigo as codigo','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','p.per_cm as cm',
        //                  'p.per_ci as ci', 'p.per_expedido as expedido', 'g.abreviatura as grado','e.abreviatura as complemento')
        //     ->where($criterio,'like','%'.$buscar.'%')
        //     ->where('ep.estado',1)
        //     ->where('epe.estado',1)
        //     ->where('pd.estado',1)
        //     ->where('ps.estado',1)
        //     ->where('pd.d3_cod', '<>',$unidad->d3_cod)
        //     ->whereIn('ps.detsit_cod',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
        //     ->where('g.fuerza','FAB')
        //     ->orderBy('ep.esca_cod')
        //     ->orderBy('ep.subesc_cod')
        //     ->orderBy('g.orden')
        //     ->paginate(10);
        // }

        // return response()->json([
        //     'pagination' => [
        //         'total'         => $datos->total(),
        //         'current_page'  => $datos->currentPage(),
        //         'per_page'      => $datos->perPage(),
        //         'last_page'     => $datos->lastPage(),
        //         'from'          => $datos->firstItem(),
        //         'to'            => $datos->lastItem(),

        //     ],
        //     'datos' => $datos
        // ]);
    }

    /**
     * Listado de pesonal para proyectos de ingenieria
     */

    public function ListarPersonalProy(Request $request)
    {
        // $buscar = $request->buscar;
        // $criterio = $request->criterio;
        // if ($buscar == "") {
        //     $datos = DB::table('personal_escalafones as pe')
        //         ->join('personals as p','pe.per_codigo','p.per_codigo')
        //         ->join('personal_estudios as ps','p.per_codigo','ps.per_codigo')
        //         ->join('grados as g','pe.gra_cod','g.id')
        //         ->join('estudios as e','ps.est_cod','e.id')
        //         ->join('subescalafones as se','pe.subesc_cod','se.id')
        //         ->join('personal_situaciones as psi','p.per_codigo','psi.per_codigo')
        //         ->select('p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno',
        //                 'g.abreviatura as grado','e.abreviatura as complemento','p.per_cm as CM', 'p.per_codigo')
        //         ->where('ps.estado',1)
        //         ->where('pe.estado',1)
        //         ->where('psi.estado',1)
        //         ->where('g.fuerza','FAB')
        //         ->whereIn('psi.detsit_cod',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
        //         ->orderBy('pe.esca_cod')
        //         ->orderBy('se.orden')
        //         ->orderBy('g.orden')
        //         ->orderBy('p.per_cm')
        //         ->paginate(20);
        // } else {
        //     $datos = DB::table('personal_escalafones as pe')
        //         ->join('personals as p','pe.per_codigo','p.per_codigo')
        //         ->join('personal_estudios as ps','p.per_codigo','ps.per_codigo')
        //         ->join('grados as g','pe.gra_cod','g.id')
        //         ->join('estudios as e','ps.est_cod','e.id')
        //         ->join('subescalafones as se','pe.subesc_cod','se.id')
        //         ->join('personal_situaciones as psi','p.per_codigo','psi.per_codigo')
        //         ->select('p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno',
        //                 'g.abreviatura as grado','e.abreviatura as complemento','p.per_cm as CM','p.per_codigo')
        //         ->where($criterio,'like', '%'.$buscar.'%')
        //         ->where('ps.estado',1)
        //         ->where('pe.estado',1)
        //         ->where('g.fuerza','FAB')
        //         ->whereIn('psi.detsit_cod',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
        //         ->orderBy('pe.esca_cod')
        //         ->orderBy('se.orden')
        //         ->orderBy('g.orden')
        //         ->orderBy('p.per_cm')
        //         ->paginate(20);
        // }



        // return response()->json([
        //     'pagination' => [
        //         'total'      => $datos->total(),
        //         'current_page' => $datos->currentPage(),
        //         'per_page' => $datos->perPage(),
        //         'last_page' => $datos->lastPage(),
        //         'from' => $datos->firstItem(),
        //         'to' => $datos->lastItem(),
        //     ],
        //     'datos' => $datos
        // ]);
    }

    /**
     * 
     * FUNCION PARA EL REGISTRO DE UN UNEVO PERSONAL
     */

     public function RegistrarPersonal(Request $request)
     {
        //  try {
        //     DB::beginTransaction();
        //      if ($request->data['foto'] != "") {
        //          $exploded = explode(',', $request->data['foto']);
        //          $decoded = base64_decode($exploded[1]);
        //          if (Str::contains($exploded[0], 'jpeg')) {
        //              $extension = 'jpg';
        //          } else {
        //              $extension = 'png';
        //          }
        //          $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        //          $charactersLength = strlen($characters);
        //          $randomString = '';
        //          for ($i=0; $i < 10; $i++) {
        //             $randomString .= $characters[rand(0,$charactersLength - 1)];
        //          }
        //          $fileName = $randomString.($request->data['cm']).$randomString.'.'.$extension;
        //          $path = public_path().'/img/personal/'.$fileName;
        //          file_put_contents($path, $decoded);

        //      } else {
        //          $fileName = 'avatar.jpg';
        //      }
        //      $personal = Personal::create([
        //         'per_paterno' => strtoupper($request->data['paterno']),
        //         'per_materno' => strtoupper($request->data['materno']),
        //         'per_nombre' => strtoupper($request->data['nombre']),
        //         'per_fecha_nacimiento' => $request->data['fechaNacimiento'],
        //         'per_estado_civil' => $request->data['estadoCivil'],
        //         'per_sexo' => strtoupper($request->data['genero']),
        //         'per_ci' => $request->data['ci'],
        //         'per_expedido' => $request->data['expedido'],
        //         'per_telefono' => $request->data['telefono'],
        //         'per_celular' => $request->data['celular'],
        //         'per_mail' => $request->data['email'],
        //         'per_cm' => $request->data['cm'],
        //         'per_ciudad' => strtoupper($request->data['ciudad']),
        //         'per_zona' => strtoupper($request->data['zona']),
        //         'per_calle' => strtoupper($request->data['calle']),
        //         'per_promo' => substr($request->data['cm'],0,5) ,
        //         'per_seguro' => strtoupper($request->data['carnetSeguro']),
        //         'per_serv_mil' => strtoupper($request->data['libreta']),
        //         'per_religion' => $request->data['religion'],
        //         'per_boleta_pago' => strtoupper($request->data['cm']),
        //         'per_foto' => $fileName,
        //         // 'per_observaciones' => $request->data[],
        //         'estado' => 1,
        //         'sysuser' => Auth::user()->id
        //      ]);
        //     $percodigo = $personal->per_codigo;
        //     $perloc = PersonalLocalidades::create([
        //         'per_codigo' => $percodigo,
        //         'depa_codigo' => $request->data['departamento']['id'],
        //         'prov_codigo' => $request->data['provincia']['id'],
        //         'loca_codigo' => $request->data['localidad']['id'],
        //         'estado' => 1,
        //         'sysuser' => Auth::user()->id
        //     ]);
        //     $persit = PersonalSituacion::create([
        //         'per_codigo' => $percodigo,
        //         'sit_cod' => $request->data['situacion']['id'],
        //         'subsit_cod' => $request->data['subsituacion']['id'],
        //         'detsit_cod' => $request->data['detalleSituacion']['id'],
        //         'documento' => $request->data['sitTipoDocumento'],
        //         'fecha_documento' => $request->data['sitFechaDocumento'],
        //         'fecha' => $request->data['sitFechaDocumento'],
        //         'nrodoc' => $request->data['sitNroDocumento'],
        //         'ficticia' => $request->data['sitFechaDocumento'],
        //         'promo' => '2021',
        //         'observacion' => $request->data['sitObser'],
        //         'estado' => 1,
        //         'sysuser' => Auth::user()->id
        //     ]);
        //     $peresc = PersonalEscalafon::create([
        //         'per_codigo' => $percodigo,
        //         'esca_cod' => $request->data['escalafon']['id'],
        //         'subesc_cod' => $request->data['subescalafon']['id'],
        //         'gra_cod' => $request->data['grado']['id'],
        //         'documento' => $request->data['sitTipoDocumento'],
        //         'fecha_doc' => $request->data['sitFechaDocumento'],
        //         'fecha' => $request->data['sitFechaDocumento'],
        //         'cm' => $request->data['cm'],
        //         'nro_doc' => $request->data['sitNroDocumento'],
        //         'observacion' => $request->data['sitObser'],
        //         'estado' => 1,
        //         'sysuser' => Auth::user()->id
        //     ]);
        //     $percom = PersonalEstudio::create([
        //         'per_codigo' => $percodigo,
        //         'est_cod' => $request->data['estudios']['id'],
        //         'documento' => $request->data['comDocumento'],
        //         'fecha_documento' => $request->data['comFechaDocumento'],
        //         'nrodoc' => $request->data['comNroDocumento'],
        //         'observacion' => $request->data['comObser'],
        //         'estado' => 1,
        //         'sysuser' => Auth::user()->id
        //     ]);
        //     $peresp = PersonalEspecialidades::create([
        //         'per_codigo' => $percodigo,
        //         'espe_cod' => $request->data['especialidad']['id'],
        //         'subespe_cod' => $request->data['subespecialidad']['id'],
        //         'documento' => $request->data['comDocumento'],
        //         'fecha_documento' => $request->data['comFechaDocumento'],
        //         'fecha' => $request->data['comFechaDocumento'],
        //         'nrodoc' => $request->data['comNroDocumento'],
        //         'observacion' => $request->data['comObser'],
        //         'estado' => 1,
        //         'sysuser' => Auth::user()->id
        //     ]);
        //     $fechaP = Carbon::parse($request->data['fechDocDest'])->subYear()->isoFormat('YYYY');
        //     $personal_destino = PersonalDestinos::create([
        //         //'CAMPO DE LA TABLA' => $request->NOMBRE Q VIENE DE LA VISTA
        //         'per_codigo' => $percodigo,
        //         'd1_cod' => $request->data['d1']['id'],
        //         'd2_cod' => $request->data['d2']['id'],
        //         'd3_cod' => $request->data['d3']['id'],
        //         'd4_cod' => $request->data['d4']['id'],
        //         'gra_cod' => $request->data['grado']['id'],
        //         'nro_doc' => $request->data['nroDocDest'],
        //         'tipo_doc' => $request->data['tipoDocDest'],
        //         'fecha_destino' =>$request->data['fechDocDest'],
        //         'promocion' => $fechaP,
        //         'sysuser' => Auth::user()->id,
        //         'flag' => '1',
        //     ]);
        //     if($request->data['c2'] == null){
        //         $idcargo2 = 369;
        //     }else{
        //         $idcargo2 = $request->data['c2']['id'];
        //     }
        //     $personal_cargo1 = PersonalCargo::create([
        //         //'CAMPO DE LA TABLA' => $request->NOMBRE Q VIENE DE LA VISTA
        //         'per_codigo' => $percodigo,
        //         'dest_cod' => $personal_destino->id,
        //         'car_cod' => $request->data['c1']['id'],
        //         'nivel_cargo' => '1',
        //         'fechadest' =>$request->data['fechDocDest'],
        //         'sysuser' => Auth::user()->id,
        //         'flag' => '1',
        //     ]);

        //     $personal_cargo2 = PersonalCargo::create([
        //         //'CAMPO DE LA TABLA' => $request->NOMBRE Q VIENE DE LA VISTA
        //         //PARA PONER FUNCION ASIGNARSE COMO DEFAULT
        //         'per_codigo' => $percodigo,
        //         'dest_cod' => $personal_destino->id,
        //         'car_cod' => $idcargo2,
        //         'nivel_cargo' => '2',
        //         'fechadest' => $request->data['fechDocDest'],
        //         'sysuser' => Auth::user()->id,
        //         'flag' => '1',
        //     ]);
        //     $fechaF = '31/12/'.Carbon::parse($request->data['sitFechaDocumento'])->subYear()->isoFormat('YYYY');
        //     $fechaI = '01/01/'.Carbon::parse($request->data['sitFechaDocumento'])->subYear(3)->isoFormat('YYYY');
    
        //     if ($request->data['subescalafon']['id']==4 || $request->data['subescalafon']['id']==5 || $request->data['subescalafon']['id']==6) {
        //         $percur = PersonalCursos::create([
        //             'per_codigo' => $percodigo,
        //             'cur_cod' => 12,
        //             'tipcur_cod'=> 18,
        //             'desgcur_cod' => 26,
        //             'emi_cod' => 2,
        //             'tipemi_cod' => 318,
        //             'descripcion' => 'TECNICO SUPERIOR EN CIENCIAS Y ARTES MILITARES AERONAUTICAS',
        //             'fec_inicio' => date('Y-m-d H:i:s', strtotime($fechaI)),
        //             'fec_final' => date('Y-m-d H:i:s', strtotime($fechaF)),
        //             'lugar' => 'COCHABAMBA',
        //             'documento' => 'CERTIFICADO',
        //             'fecha_otorgacion' => date('Y-m-d H:i:s', strtotime($fechaF)),
        //             'nro_doc' => 0,
        //             'posicion' => 0,
        //             'costo' => 0,
        //             'observacion' => 'NINGUNA',
        //             'estado' => 1,
        //             'sysuser' => Auth::user()->id
        //         ]);
                
        //         $pcurid = $percur->id;
        //         PersonalPericia::create([
        //             'per_codigo' => $percodigo,
        //             'percur_id' => $pcurid,
        //             'pericia' => 1,
        //             'fecha' => $request->data['sitFechaDocumento'],
        //             'observacion' => 'ninguna',
        //             'estado' => 1,
        //             'sysuser' =>  Auth::user()->id
        //         ]);
        //     }
        //     DB::commit();
        //     return response()->json([
        //         'code' => 200
        //     ]);
        //  } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json([
        //         'code' => 400
        //     ]);
        //  }
        
    }

    public function EditarDatosPersonales(Request $request)
    {

        // $localidad_personal = DB::table('personal_localidades')
        //     ->where('per_codigo', $request->codigo)
        //     ->update([
        //         'depa_codigo' => $request->depa_codigo,
        //         'prov_codigo' => $request->prov_codigo,
        //         'loca_codigo' => $request->loca_codigo,
        //         'observacion' => 'NINGUNO',
        //         'estado' => 1, 
        //         'sysuser' => Auth::user()->id
        //     ]);


        // $personal = Personal::findOrFail($request->codigo);
        // $currentPhoto = $personal->per_foto;
        // if($request->per_foto != $currentPhoto){
        //     $exploded = explode(',', $request->per_foto);
        //     $decoded = base64_decode($exploded[1]);
        //     if (Str::contains($exploded[0], 'jpeg')) {
        //         $extension = 'jpg';
        //     } else {
        //         $extension = 'png';
        //     }
        //     $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        //     $charactersLength = strlen($characters);
        //     $randomString = '';
        //     for ($i=0; $i < 10; $i++) { 
        //        $randomString .= $characters[rand(0,$charactersLength - 1)]; 
        //     }
        //     $fileName = $randomString.($request->cm).$randomString.'.'.$extension;
        //     $path = public_path().'/img/personal/'.$fileName;
        //     file_put_contents($path, $decoded);
        //     $request->per_foto=$fileName; 
        // } 
        // $sitper = DB::table('personals')
        //     ->where('per_codigo', $request->codigo)
        //     ->update([
        //         'per_paterno' => strtoupper($request->paterno), 
        //         'per_materno' => strtoupper($request->materno), 
        //         'per_nombre' => strtoupper($request->nombre), 
        //         'per_fecha_nacimiento' => $request->fechaNacimiento, 
        //         'per_estado_civil' => $request->estadoCivil,
        //         'per_sexo' => strtoupper($request->genero), 
        //         'per_ci' => $request->ci, 
        //         'per_expedido' => $request->expedido, 
        //         'per_telefono' => $request->telefono, 
        //         'per_celular' => $request->celular, 
        //         'per_mail' => $request->email,
        //         'per_cm' => $request->cm,  
        //         'per_ciudad' => strtoupper($request->per_ciudad), 
        //         'per_zona' => strtoupper($request->per_zona), 
        //         'per_calle' => strtoupper($request->per_calle), 
        //         'per_promo' => substr($request->cm,0,5) ,
        //         'per_seguro' => strtoupper($request->seguro), 
        //         'per_serv_mil' => strtoupper($request->servMil),
        //         'per_religion' => $request->religion, 
        //         'per_boleta_pago' => strtoupper($request->per_boleta_pago),
        //         'per_foto'  => $request->per_foto,
        //         'estado' => 1, 
        //         'sysuser' => Auth::user()->id
        //     ]);
        // return response()->json([$sitper,$localidad_personal]);
    }

}
