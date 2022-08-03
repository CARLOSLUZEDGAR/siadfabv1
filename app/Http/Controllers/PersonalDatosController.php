<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonalDatosController extends Controller
{
    public function index(Request $request){
        $per_codigo = $request->per_codigo;
        
        $personal_datos = DB::table('personal')
        ->join('escalafon_personal','personal.per_codigo','escalafon_personal.per_codigo')
        ->join('escalafones','escalafones.esca_codigo','escalafon_personal.esca_codigo')
        ->join('subescalafones','subescalafones.id','escalafon_personal.subesc_codigo')
        ->join('grados','grados.id','escalafon_personal.gra_codigo')
        ->select('personal.per_codigo',
                'personal.per_paterno',
                'personal.per_materno',
                'personal.per_nombre',
                'personal.per_sexo',
                'personal.per_ci',
                'personal.per_cm',
                'personal.per_promo',
                'grados.gra_abreviatura',
                'escalafon_personal.gra_codigo',
                'escalafon_personal.estado as escperestado')
        ->where('personal.per_codigo',$per_codigo)
        ->where('escalafon_personal.estado',1)->first();
        return response()->json($personal_datos);

    }

    public function  perdatdest(Request $request)
    {
        $per_codigo = $request->per_codigo;
        $division = $request->division;
        $personal_datos = DB::table('personals')
        ->leftjoin('personal_escalafones','personals.per_codigo','personal_escalafones.per_codigo')
        ->leftjoin('escalafones','escalafones.id','personal_escalafones.esca_cod')
        ->leftjoin('subescalafones','subescalafones.id','personal_escalafones.subesc_cod')
        ->leftjoin('grados','grados.id','personal_escalafones.gra_cod')
        ->leftjoin('personal_estudios','personal_estudios.per_codigo','personals.per_codigo')
        ->leftjoin('estudios','estudios.id','personal_estudios.est_cod')
        ->leftjoin('personal_especialidades','personal_especialidades.per_codigo','personals.per_codigo')
        ->leftjoin('especialidades','especialidades.id','personal_especialidades.espe_cod')
        ->leftjoin('subespecialidades','subespecialidades.id','personal_especialidades.subespe_cod')
        ->leftjoin('personal_destinos','personal_destinos.per_codigo','personals.per_codigo')
        ->leftjoin('nivel3_destinos','nivel3_destinos.id','personal_destinos.d3_cod')
        ->leftjoin('nivel4_destinos','nivel4_destinos.id','personal_destinos.d4_cod')
        ->leftjoin('personal_situaciones','personals.per_codigo','personal_situaciones.per_codigo')
        ->leftjoin('situaciones','personal_situaciones.sit_cod','situaciones.id')
        ->leftjoin('subsituaciones','personal_situaciones.subsit_cod','subsituaciones.id')
        ->leftjoin('detalle_situaciones','personal_situaciones.detsit_cod','detalle_situaciones.id')
        ->select('personals.per_codigo',
                'personals.per_paterno',
                'personals.per_materno',
                'personals.per_nombre',
                'personals.per_sexo',
                'personals.per_ci',
                'personals.per_expedido',
                'personals.per_cm',
                'personals.per_promo',
                'personals.per_foto',
                'grados.division',
                'grados.id as idgrado',
                'grados.abreviatura as gra_abreviatura',
                'estudios.abreviatura as estu_abreviatura',
                'subescalafones.id as subescid',
                'subescalafones.nombre',
                'especialidades.nombre as nomespe',
                'subespecialidades.nombre as nomsubespe',
                'nivel3_destinos.descripcion as nomd3',
                'nivel4_destinos.descripcion as nomd4',
                'personal_escalafones.estado as escperestado',
                'personal_estudios.estado as estperestado',
                'escalafones.id as escaid',
                'escalafones.nombre as esca_nombre',
                'subescalafones.nombre as subesca_nombre',
                'grados.nombre as gra_nombre',
                'situaciones.nombre as sitnombre',
                'subsituaciones.nombre as subsitnombre',
                'detalle_situaciones.nombre as detsitnombre')
        ->where('personals.per_codigo',$per_codigo)
        ->where('personal_escalafones.estado',1)
        ->where('personal_estudios.estado',1)
        ->where('personal_especialidades.estado',1)
        ->where('personal_destinos.estado',1)
        ->where('personal_situaciones.estado',1)
       // ->orderBy('personals.per_codigo','desc')
        ->first();

        // $personal_only_sit = DB::table('personals')
        // ->leftjoin('situacion_personal','situacion_personal.per_codigo','personals.per_codigo')
        // ->leftjoin('situacion','situacion.id','situacion_personal.sit_codigo')
        // ->leftjoin('subsituacion','subsituacion.id','situacion_personal.subsit_codigo')
        // ->leftjoin('detalle_situacion','detalle_situacion.id','situacion_personal.detsit_codigo')
        // ->select('situacion.id',
        //         'situacion.sit_nombre',
        //         'subsituacion.id',
        //         'subsituacion.subsit_nombre',
        //         'detalle_situacion.id',
        //         'detalle_situacion.detsit_nombre')
        // ->where('personals.per_codigo',$per_codigo)
        // ->get();
        $personal_only_sit = DB::table('personals')
        ->leftjoin('personal_situaciones','personal_situaciones.per_codigo','personals.per_codigo')
        ->leftjoin('situaciones','situaciones.id','personal_situaciones.sit_cod')
        ->leftjoin('subsituaciones','subsituaciones.id','personal_situaciones.subsit_cod')
        ->leftjoin('detalle_situaciones','detalle_situaciones.id','personal_situaciones.detsit_cod')
        ->select('situaciones.id',
                'situaciones.nombre as sit_nombre',
                'subsituaciones.id',
                'subsituaciones.nombre as subsit_nombre',
                'detalle_situaciones.id',
                'detalle_situaciones.nombre as detsit_nombre',
                'personal_situaciones.documento as sitper_documento',
                'personal_situaciones.fecha_documento as sitper_fecha_documento',
                'personal_situaciones.nrodoc as sitper_nrodoc',
                'personal_situaciones.observacion as obs'
                )
        ->where('personals.per_codigo',$per_codigo)
        ->orderBy('personal_situaciones.fecha_documento','asc')
        ->get();

        $listar_grado = DB::table('grados')
                        ->select('id',
                                'abreviatura',
                                'nombre',
                                'division')
                        ->where('division',$division)
                        ->orderBy('id','asc')
                        ->get();
        return response()->json(['personal_datos' => $personal_datos,'personal_only_sit' => $personal_only_sit, 'listar_grado' => $listar_grado]);
       // return response()->json($personal_datos);

    }

    
}
