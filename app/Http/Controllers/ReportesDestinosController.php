<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;



class ReportesDestinosController extends Controller
{
    public function ReporteDesglose(Request $request)
    {
        $per_codigo = $request->per_codigo;

        $personal_destinos = DB::table("personal_destinos")
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
                'personals.per_cm',
                'personals.per_foto',
                'personal_destinos.per_codigo',
                'personal_destinos.d1_cod as d1_codigo',
                'personal_destinos.d2_cod as d2_codigo',
                'personal_destinos.d3_cod as d3_codigo',
                'personal_destinos.d4_cod as d4_codigo',
                'personal_destinos.tipo_doc',
                'personal_destinos.nro_doc',
                'personal_destinos.fecha_destino as fechadestino',
                'personal_destinos.promocion',
                'personal_destinos.estado',
                'personal_destinos.observacion',
                'cargos.id as idcargo',
                'cargos.descripcion as cargo'
                )
        ->where('personal_destinos.per_codigo', '=', $per_codigo)
        ->where('personal_destinos.flag',1)
        ->where('personal_cargos.nivel_cargo',1)
        ->orderBy('personal_destinos.fecha_destino','asc')
        ->get();

        $personal_destinos2 = DB::table("personal_destinos")
        ->join('personals','personal_destinos.per_codigo','=','personals.per_codigo')
        ->join('nivel1_destinos','personal_destinos.d1_cod','=','nivel1_destinos.id')
        ->join('nivel2_destinos','personal_destinos.d2_cod','=','nivel2_destinos.id')
        ->join('nivel3_destinos','personal_destinos.d3_cod','=','nivel3_destinos.id')
        ->join('nivel4_destinos','personal_destinos.d4_cod','=','nivel4_destinos.id')
        ->join('personal_cargos','personal_destinos.id','=','personal_cargos.dest_cod')
        ->join('cargos','personal_cargos.car_cod','=','cargos.id')
        ->select('personal_destinos.id as idpersonal_destinos2',
                'nivel1_destinos.descripcion as desc_dn1',
                'nivel2_destinos.descripcion as desc_dn2',
                'nivel3_destinos.descripcion as desc_dn3',
                'nivel4_destinos.descripcion as desc_dn4',
                'personals.per_nombre',
                'personals.per_paterno',
                'personals.per_materno',
                'personals.per_cm',
                'personals.per_foto',
                'personal_destinos.per_codigo',
                'personal_destinos.d1_cod as d1_codigo',
                'personal_destinos.d2_cod as d2_codigo',
                'personal_destinos.d3_cod as d3_codigo',
                'personal_destinos.d4_cod as d4_codigo',
                'personal_destinos.tipo_doc',
                'personal_destinos.nro_doc',
                'personal_destinos.fecha_destino as fechadestino',
                'personal_destinos.promocion',
                'personal_destinos.estado',
                'personal_destinos.observacion',
                'cargos.id as idcargo',
                'cargos.descripcion as cargo2'
                )
        ->where('personal_destinos.per_codigo', '=', $per_codigo)
        ->where('personal_destinos.flag',1)
        ->where('personal_cargos.nivel_cargo',2)
        ->orderBy('personal_destinos.fecha_destino','asc')
        ->get();

        $personal = DB::table('personals')
        ->leftjoin('personal_escalafones','personals.per_codigo','personal_escalafones.per_codigo')
        ->leftjoin('escalafones','escalafones.id','personal_escalafones.esca_cod')
        ->leftjoin('subescalafones','subescalafones.id','personal_escalafones.subesc_cod')
        ->leftjoin('grados','grados.id','personal_escalafones.gra_cod')
        ->leftjoin('personal_estudios','personal_estudios.per_codigo','personals.per_codigo')
        ->leftjoin('estudios','estudios.id','personal_estudios.est_cod')
        ->select('personals.per_codigo',
                'personals.per_paterno',
                'personals.per_materno',
                'personals.per_nombre',
                'personals.per_sexo',
                'personals.per_ci',
                'personals.per_expedido',
                'personals.per_cm',
                'personals.per_foto',
                'grados.abreviatura as gra_abreviatura',
                'estudios.abreviatura as estu_abreviatura',
                'personal_escalafones.estado as escperestado',
                'personal_estudios.id as estperestado')
        ->where('personals.per_codigo',$per_codigo)
        ->where('personal_escalafones.estado',1)
        ->where('personal_estudios.estado',1)
        ->first();
        
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
        $qr = QrCode::encoding('UTF-8')->size(100)->generate("GRADO: $personal->gra_abreviatura$personal->estu_abreviatura\nAPELLIDO(S): $personal->per_paterno $personal->per_materno\nNOMBRE(S): $personal->per_nombre\nC.M.: $personal->per_cm\nC.I.: $personal->per_ci $personal->per_expedido\nFECHA: $fecha_emision");
        $codigo = $qr;

        $pdf = PDF::loadView('reportes.desglose',['personal_destinos'=>$personal_destinos,
                                                          'personal_destinos2'=>$personal_destinos2,
                                                          'personal'=>$personal,
                                                          'jefe_dpto'=>$jefe_dpto,
                                                          'qr'=>$codigo])
        ->setPaper('letter', 'portrait');                                               
        
        return $pdf->stream('reporte.pdf');
    }

    public function CertificadoDestAscenso(Request $request)
    {
        $usuario = strtolower(Auth::user()->nick);
        $per_codigo = $request->per_codigo;
        $notaASc = $request->notaAsc;
        $nro_doc = $request->nro_doc;
        $rubrica = $request->rubrica;
        // $fecha_inc = $request->fecha_inc;
        $fecha_fin = $request->fecha_fin;
        $fecha_inicial = $request->fecha_inc;
        list($anio, $mes, $dia) = explode("-",$fecha_inicial);
        echo "Año: $anio <br />";
        echo "Mes: $mes <br />";
        echo "Dia: $dia <br />";
        if ($dia == '01' && $mes == '01'){
        //       if($mes == '01'){
                      $inicio = ($anio-1).'-12-31';
        //       }  
        }else{
                $inicio = $fecha_inicial;
        }

        // $personal_destinos = DB::table("personal_destinos")
        // ->join('personals','personal_destinos.per_codigo','=','personals.per_codigo')
        // ->join('nivel1_destinos','personal_destinos.d1_cod','=','nivel1_destinos.id')
        // ->join('nivel2_destinos','personal_destinos.d2_cod','=','nivel2_destinos.id')
        // ->join('nivel3_destinos','personal_destinos.d3_cod','=','nivel3_destinos.id')
        // ->join('nivel4_destinos','personal_destinos.d4_cod','=','nivel4_destinos.id')
        // ->join('personal_cargos','personal_destinos.id','=','personal_cargos.dest_cod')
        // ->join('cargos','personal_cargos.car_cod','=','cargos.id')
        // ->select('personal_destinos.id as idpersonal_destinos',
        //         'nivel1_destinos.descripcion as desc_dn1',
        //         'nivel2_destinos.descripcion as desc_dn2',
        //         'nivel3_destinos.descripcion as desc_dn3',
        //         'nivel4_destinos.descripcion as desc_dn4',
        //         'personals.per_nombre',
        //         'personals.per_paterno',
        //         'personals.per_materno',
        //         'personals.per_cm',
        //         'personals.per_foto',
        //         'personal_destinos.per_codigo',
        //         'personal_destinos.d1_cod as d1_codigo',
        //         'personal_destinos.d2_cod as d2_codigo',
        //         'personal_destinos.d3_cod as d3_codigo',
        //         'personal_destinos.d4_cod as d4_codigo',
        //         'personal_destinos.tipo_doc',
        //         'personal_destinos.nro_doc',
        //         'personal_destinos.fecha_destino as fechadestino',
        //         'personal_destinos.promocion',
        //         'personal_destinos.estado',
        //         'personal_destinos.observacion',
        //         'cargos.id as idcargo',
        //         'cargos.descripcion as cargo'
        //         )
        // ->where('personal_destinos.per_codigo', '=', $per_codigo)
        // ->where('personal_destinos.fecha_destino','>=',$inicio)
        // ->where('personal_destinos.fecha_destino','<=',$fecha_fin)
        // ->where('personal_destinos.flag',1)
        // ->where('personal_cargos.nivel_cargo',1)
        // ->orderBy('personal_destinos.fecha_destino','asc')
        // ->get();
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
                'personals.per_cm',
                'personals.per_foto',
                'personal_destinos.per_codigo',
                'personal_destinos.d1_cod as d1_codigo',
                'personal_destinos.d2_cod as d2_codigo',
                'personal_destinos.d3_cod as d3_codigo',
                'personal_destinos.d4_cod as d4_codigo',
                'personal_destinos.tipo_doc',
                'personal_destinos.nro_doc',
                'personal_destinos.fecha_destino as fechadestino',
                'personal_destinos.promocion',
                'personal_destinos.estado',
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
        ->where('personal_destinos.fecha_destino','>=',$inicio)
        ->where('personal_destinos.fecha_destino','<=',$fecha_fin)
        ->where('personal_destinos.flag',1)
        ->where('personal_cargos.nivel_cargo',1)
        ->orderBy('personal_destinos.fecha_destino','asc')
        ->get();

        $personal_destinos2 = DB::table("personal_destinos")
        ->join('personals','personal_destinos.per_codigo','=','personals.per_codigo')
        ->join('nivel1_destinos','personal_destinos.d1_cod','=','nivel1_destinos.id')
        ->join('nivel2_destinos','personal_destinos.d2_cod','=','nivel2_destinos.id')
        ->join('nivel3_destinos','personal_destinos.d3_cod','=','nivel3_destinos.id')
        ->join('nivel4_destinos','personal_destinos.d4_cod','=','nivel4_destinos.id')
        ->join('personal_cargos','personal_destinos.id','=','personal_cargos.dest_cod')
        ->join('cargos','personal_cargos.car_cod','=','cargos.id')
        ->select('personal_destinos.id as idpersonal_destinos2',
                'nivel1_destinos.descripcion as desc_dn1',
                'nivel2_destinos.descripcion as desc_dn2',
                'nivel3_destinos.descripcion as desc_dn3',
                'nivel4_destinos.descripcion as desc_dn4',
                'personals.per_nombre',
                'personals.per_paterno',
                'personals.per_materno',
                'personals.per_cm',
                'personals.per_foto',
                'personal_destinos.per_codigo',
                'personal_destinos.d1_cod as d1_codigo',
                'personal_destinos.d2_cod as d2_codigo',
                'personal_destinos.d3_cod as d3_codigo',
                'personal_destinos.d4_cod as d4_codigo',
                'personal_destinos.tipo_doc',
                'personal_destinos.nro_doc',
                'personal_destinos.fecha_destino as fechadestino',
                'personal_destinos.promocion',
                'personal_destinos.estado',
                'personal_destinos.observacion',
                'cargos.id as idcargo',
                'cargos.descripcion as cargo2'
                )
        ->where('personal_destinos.per_codigo', '=', $per_codigo)
        ->where('personal_destinos.fecha_destino','>=',$inicio)
        ->where('personal_destinos.fecha_destino','<=',$fecha_fin)
        ->where('personal_destinos.flag',1)
        ->where('personal_cargos.nivel_cargo',2)
        ->orderBy('personal_destinos.fecha_destino','asc')
        ->get();

        $personal = DB::table('personals')
        ->leftjoin('personal_escalafones','personals.per_codigo','personal_escalafones.per_codigo')
        ->leftjoin('escalafones','escalafones.id','personal_escalafones.esca_cod')
        ->leftjoin('subescalafones','subescalafones.id','personal_escalafones.subesc_cod')
        ->leftjoin('grados','grados.id','personal_escalafones.gra_cod')
        ->leftjoin('personal_estudios','personal_estudios.per_codigo','personals.per_codigo')
        ->leftjoin('estudios','estudios.id','personal_estudios.est_cod')
        ->select('personals.per_codigo',
                'personals.per_paterno',
                'personals.per_materno',
                'personals.per_nombre',
                'personals.per_sexo',
                'personals.per_ci',
                'personals.per_expedido',
                'personals.per_cm',
                'personals.per_foto',
                'grados.abreviatura as gra_abreviatura',
                'estudios.abreviatura as estu_abreviatura',
                'personal_escalafones.estado as escperestado',
                'personal_estudios.id as estperestado')
        ->where('personals.per_codigo',$per_codigo)
        ->where('personal_escalafones.estado',1)
        ->where('personal_estudios.estado',1)
        ->first();
        
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
        
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha_emision = date('d')." de ".$meses[date('n')-1]." del ".date('Y');
        $qr = QrCode::encoding('UTF-8')->size(100)->generate("GRADO: $personal->gra_abreviatura$personal->estu_abreviatura\nAPELLIDO(S): $personal->per_paterno $personal->per_materno\nNOMBRE(S): $personal->per_nombre\nC.M.: $personal->per_cm\nC.I.: $personal->per_ci $personal->per_expedido\nFECHA: $fecha_emision");
        $codigo = $qr;

        $pdf = PDF::loadView('reportes.certificadoDestinosAscenso',['personal_destinos'=>$personal_destinos,
                                                             'personal_destinos2'=>$personal_destinos2,
                                                             'personal'=>$personal,
                                                             'personal_sit'=>$personal_only_sit,
                                                             'jefe_dpto'=>$jefe_dpto,
                                                             'qr'=>$codigo,
                                                             'nota'=>$notaASc,
                                                             'nro_doc'=>$nro_doc,
                                                             'rubrica'=>$rubrica,
                                                             'user'=>$usuario])
        ->setPaper('letter', 'portrait');
        
        return $pdf->stream('reporte.pdf');
    }

    public function CertificadoDestFrontera(Request $request)
    {
        // $usuario = strtolower(Auth::user()->nick);
        $per_codigo = $request->per_codigo;
        $notaFront = $request->notaFront;
        $nro_doc = $request->nro_doc;
        $rubrica = $request->rubrica;

        $personal_destinos_frontera = DB::table("personal_destinos")
        ->join('personals','personal_destinos.per_codigo','=','personals.per_codigo')
        // ->join('nivel1_destinos','personal_destinos.d1_cod','=','nivel1_destinos.id')
        ->join('nivel2_destinos','personal_destinos.d2_cod','=','nivel2_destinos.id')
        ->join('nivel3_destinos','personal_destinos.d3_cod','=','nivel3_destinos.id')
        // ->join('nivel4_destinos','personal_destinos.d4_cod','=','nivel4_destinos.id')
        ->select('personal_destinos.id as idpersonal_destinos',
                // 'nivel1_destinos.descripcion as desc_dn1',
                'nivel2_destinos.descripcion as desc_dn2',
                'nivel3_destinos.descripcion as desc_dn3',
                // 'nivel4_destinos.descripcion as desc_dn4',
                'personal_destinos.fecha_destino',
                'personal_destinos.finfechadestino',
                'nivel3_destinos.frontera'
                )
        ->where('personal_destinos.per_codigo', '=', $per_codigo)
        // ->where('nivel3_destinos.frontera',1)
        ->where('personal_destinos.flag',1)
        ->orderBy('personal_destinos.fecha_destino','asc')
        ->get();

        $fecha_frontera =  DB::table("personal_destinos")
        ->join('personals','personal_destinos.per_codigo','=','personals.per_codigo')
        ->join('nivel3_destinos','personal_destinos.d3_cod','=','nivel3_destinos.id')
        ->select('nivel3_destinos.frontera',
                'personal_destinos.fecha_destino')
        ->where('personal_destinos.per_codigo', '=', $per_codigo)
        ->where('personal_destinos.flag',1)
        ->orderBy('personal_destinos.fecha_destino','asc')
        ->get();


        $personal = DB::table('personals')
        ->leftjoin('personal_escalafones','personals.per_codigo','personal_escalafones.per_codigo')
        ->leftjoin('escalafones','escalafones.id','personal_escalafones.esca_cod')
        ->leftjoin('subescalafones','subescalafones.id','personal_escalafones.subesc_cod')
        ->leftjoin('grados','grados.id','personal_escalafones.gra_cod')
        ->leftjoin('personal_estudios','personal_estudios.per_codigo','personals.per_codigo')
        ->leftjoin('estudios','estudios.id','personal_estudios.est_cod')
        ->select('personals.per_codigo',
                'personals.per_paterno',
                'personals.per_materno',
                'personals.per_nombre',
                'personals.per_sexo',
                'personals.per_ci',
                'personals.per_expedido',
                'personals.per_cm',
                'personals.per_foto',
                'grados.abreviatura as gra_abreviatura',
                'estudios.abreviatura as estu_abreviatura',
                'personal_escalafones.estado as escperestado',
                'personal_estudios.id as estperestado')
        ->where('personals.per_codigo',$per_codigo)
        ->where('personal_escalafones.estado',1)
        ->where('personal_estudios.estado',1)
        ->first();
        
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
        $qr = QrCode::encoding('UTF-8')->size(100)->generate("GRADO: $personal->gra_abreviatura$personal->estu_abreviatura\nAPELLIDO(S): $personal->per_paterno $personal->per_materno\nNOMBRE(S): $personal->per_nombre\nC.M.: $personal->per_cm\nC.I.: $personal->per_ci $personal->per_expedido\nFECHA: $fecha_emision");
        $codigo = $qr;

        $pdf = PDF::loadView('reportes.certificadoDestinosFrontera',['destino_frontera'=>$personal_destinos_frontera,
                                                             'personal'=>$personal,
                                                             'jefe_dpto'=>$jefe_dpto,
                                                             'qr'=>$codigo,
                                                             'nota'=>$notaFront,
                                                             'nro_doc'=>$nro_doc,
                                                             'rubrica'=>$rubrica,
                                                       
                                                             'fechafront'=>$fecha_frontera
                                                             ])
        ->setPaper('letter', 'portrait');
        
        return $pdf->stream('reporte.pdf');
    }

    public function CertificadoDestDesglose(Request $request)
    {
        $usuario = strtolower(Auth::user()->nick);
        $per_codigo = $request->per_codigo;
        $notaDesg = $request->notaDesg;
        $nro_doc = $request->nro_doc;
        $rubrica = $request->rubrica;

        $personal_destinos = DB::table("personal_destinos")
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
                'personals.per_nombre',
                'personals.per_paterno',
                'personals.per_materno',
                'personals.per_cm',
                'personals.per_foto',
                'personal_destinos.per_codigo',
                'personal_destinos.tipo_doc',
                'personal_destinos.nro_doc',
                'personal_destinos.fecha_destino'
                )
        ->where('personal_destinos.per_codigo', '=', $per_codigo)
        ->where('personal_destinos.flag',1)
        ->orderBy('personal_destinos.fecha_destino','asc')
        ->get();

        $personal = DB::table('personals')
        ->leftjoin('personal_escalafones','personals.per_codigo','personal_escalafones.per_codigo')
        ->leftjoin('escalafones','escalafones.id','personal_escalafones.esca_cod')
        ->leftjoin('subescalafones','subescalafones.id','personal_escalafones.subesc_cod')
        ->leftjoin('grados','grados.id','personal_escalafones.gra_cod')
        ->leftjoin('personal_estudios','personal_estudios.per_codigo','personals.per_codigo')
        ->leftjoin('estudios','estudios.id','personal_estudios.est_cod')
        ->select('personals.per_codigo',
                'personals.per_paterno',
                'personals.per_materno',
                'personals.per_nombre',
                'personals.per_sexo',
                'personals.per_ci',
                'personals.per_expedido',
                'personals.per_cm',
                'personals.per_foto',
                'grados.abreviatura as gra_abreviatura',
                'estudios.abreviatura as estu_abreviatura',
                'personal_escalafones.estado as escperestado',
                'personal_estudios.id as estperestado')
        ->where('personals.per_codigo',$per_codigo)
        ->where('personal_escalafones.estado',1)
        ->where('personal_estudios.estado',1)
        ->first();
        
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
        $qr = QrCode::encoding('UTF-8')->size(100)->generate("GRADO: $personal->gra_abreviatura$personal->estu_abreviatura\nAPELLIDO(S): $personal->per_paterno $personal->per_materno\nNOMBRE(S): $personal->per_nombre\nC.M.: $personal->per_cm\nC.I.: $personal->per_ci $personal->per_expedido\nFECHA: $fecha_emision");
        $codigo = $qr;

        $pdf = PDF::loadView('reportes.certificadoDestinosDesglose',['personal_destinos'=>$personal_destinos,                                                     
                                                             'personal'=>$personal,                                                    
                                                             'jefe_dpto'=>$jefe_dpto,
                                                             'qr'=>$codigo,
                                                             'nota'=>$notaDesg,
                                                             'nro_doc'=>$nro_doc,
                                                             'rubrica'=>$rubrica,
                                                             'user'=>$usuario])
        ->setPaper('letter', 'portrait');
        
        return $pdf->stream('reporte.pdf');
    }

    public function CertDesglServicio(Request $request)
    {
        $usuario = strtolower(Auth::user()->nick);
        $per_codigo = $request->per_codigo;
        $notaSer = $request->notaSer;
        $nro_doc = $request->nro_doc;
        $rubrica = $request->rubrica;
        $fecha_fin = $request->fecha_fin;
        $fecha_inicial = $request->fecha_inc;
        list($anio, $mes, $dia) = explode("-",$fecha_inicial);
        echo "Año: $anio <br />";
        echo "Mes: $mes <br />";
        echo "Dia: $dia <br />";
        if ($dia == '01' && $mes == '01'){
        //       if($mes == '01'){
                      $inicio = ($anio-1).'-12-31';
        //       }  
        }else{
                $inicio = $fecha_inicial;
        }

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
                'personals.per_cm',
                'personals.per_foto',
                'personal_destinos.per_codigo',
                'personal_destinos.d1_cod as d1_codigo',
                'personal_destinos.d2_cod as d2_codigo',
                'personal_destinos.d3_cod as d3_codigo',
                'personal_destinos.d4_cod as d4_codigo',
                'personal_destinos.tipo_doc',
                'personal_destinos.nro_doc',
                'personal_destinos.fecha_destino as fechadestino',
                'personal_destinos.promocion',
                'personal_destinos.estado',
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
        ->where('personal_destinos.fecha_destino','>=',$inicio)
        ->where('personal_destinos.fecha_destino','<=',$fecha_fin)
        ->where('personal_destinos.flag',1)
        ->where('personal_cargos.nivel_cargo',1)
        ->orderBy('personal_destinos.fecha_destino','asc')
        ->get();

        $personal_destinos2 = DB::table("personal_destinos")
        ->join('personals','personal_destinos.per_codigo','=','personals.per_codigo')
        ->join('nivel1_destinos','personal_destinos.d1_cod','=','nivel1_destinos.id')
        ->join('nivel2_destinos','personal_destinos.d2_cod','=','nivel2_destinos.id')
        ->join('nivel3_destinos','personal_destinos.d3_cod','=','nivel3_destinos.id')
        ->join('nivel4_destinos','personal_destinos.d4_cod','=','nivel4_destinos.id')
        ->join('personal_cargos','personal_destinos.id','=','personal_cargos.dest_cod')
        ->join('cargos','personal_cargos.car_cod','=','cargos.id')
        ->select('personal_destinos.id as idpersonal_destinos2',
                'nivel1_destinos.descripcion as desc_dn1',
                'nivel2_destinos.descripcion as desc_dn2',
                'nivel3_destinos.descripcion as desc_dn3',
                'nivel4_destinos.descripcion as desc_dn4',
                'personals.per_nombre',
                'personals.per_paterno',
                'personals.per_materno',
                'personals.per_cm',
                'personals.per_foto',
                'personal_destinos.per_codigo',
                'personal_destinos.d1_cod as d1_codigo',
                'personal_destinos.d1_cod as d2_codigo',
                'personal_destinos.d1_cod as d3_codigo',
                'personal_destinos.d1_cod as d4_codigo',
                'personal_destinos.tipo_doc',
                'personal_destinos.nro_doc',
                'personal_destinos.fecha_destino as fechadestino',
                'personal_destinos.promocion',
                'personal_destinos.estado',
                'personal_destinos.observacion',
                'cargos.id as idcargo',
                'cargos.descripcion as cargo2'
                )
        ->where('personal_destinos.per_codigo', '=', $per_codigo)
        ->where('personal_destinos.fecha_destino','>=',$inicio)
        ->where('personal_destinos.fecha_destino','<=',$fecha_fin)
        ->where('personal_destinos.flag',1)
        ->where('personal_cargos.nivel_cargo',2)
        ->orderBy('personal_destinos.fecha_destino','asc')
        ->get();

        $personal = DB::table('personals')
        ->leftjoin('personal_escalafones','personals.per_codigo','personal_escalafones.per_codigo')
        ->leftjoin('escalafones','escalafones.id','personal_escalafones.esca_cod')
        ->leftjoin('subescalafones','subescalafones.id','personal_escalafones.subesc_cod')
        ->leftjoin('grados','grados.id','personal_escalafones.gra_cod')
        ->leftjoin('personal_estudios','personal_estudios.per_codigo','personals.per_codigo')
        ->leftjoin('estudios','estudios.id','personal_estudios.est_cod')
        ->select('personals.per_codigo',
                'personals.per_paterno',
                'personals.per_materno',
                'personals.per_nombre',
                'personals.per_sexo',
                'personals.per_ci',
                'personals.per_expedido',
                'personals.per_cm',
                'personals.per_foto',
                'grados.abreviatura as gra_abreviatura',
                'grados.nombre as gra_nombre',
                'estudios.abreviatura as estu_abreviatura',
                'personal_escalafones.estado as escperestado',
                'personal_estudios.id as estperestado')
        ->where('personals.per_codigo',$per_codigo)
        ->where('personal_escalafones.estado',1)
        ->where('personal_estudios.estado',1)
        ->first();
        
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
        $qr = QrCode::encoding('UTF-8')->size(100)->generate("GRADO: $personal->gra_abreviatura$personal->estu_abreviatura\nAPELLIDO(S): $personal->per_paterno $personal->per_materno\nNOMBRE(S): $personal->per_nombre\nC.M.: $personal->per_cm\nC.I.: $personal->per_ci $personal->per_expedido\nFECHA: $fecha_emision");
        $codigo = $qr;

        $pdf = PDF::loadView('reportes.certificadoDesgloseServicio',['personal_destinos'=>$personal_destinos,
                                                             'personal_destinos2'=>$personal_destinos2,
                                                             'personal'=>$personal,
                                                             'jefe_dpto'=>$jefe_dpto,
                                                             'qr'=>$codigo,
                                                             'nota'=>$notaSer,
                                                             'nro_doc'=>$nro_doc,
                                                             'rubrica'=>$rubrica,
                                                             'user'=>$usuario])
        ->setPaper('letter', 'portrait');
        
        return $pdf->stream('reporte.pdf');
    }

    public function CurriculumComanjefe(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10240M');
      /*  $destinos = DB::table('personal_destinos')
        ->join('personals','personals.per_codigo','personal_destinos.per_codigo')
        ->join('nivel3_destinos','personal_destinos.d3_cod','nivel3_destinos.id')
        ->select('personals.per_cm','personals.per_nombre','personals.per_paterno','nivel3_destinos.descripcion')
        ->where('personal_destinos.estado',1)->get();*/
        $destinos = DB::table('vista_prueba')
        ->select('cm','nombre','paterno','destino')->limit(50)->get();

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

        $pdf = PDF::loadView('reportes.curriculumComanjefe',[
                                                            'jefe_dpto'=>$jefe_dpto, 'destinos'=>$destinos
                                                          ])

        ->setPaper('letter', 'portrait');                                               
        
        return $pdf->stream('reporte.pdf');
    }

}
