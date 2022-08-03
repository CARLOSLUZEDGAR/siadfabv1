<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

use Illuminate\Support\Facades\Auth;

class PruebaReportesController extends Controller
{

    public function update(Request $request)
    {
        // return response()->json([$personal_destinos,$personal_cargo1,$personal_cargo2,$fecha_max_update]);
    }

    // AJATA
    public function cuadroPericias (Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10240M');

        $grados_pericia_cant = DB::table('vista_pericia_grado_cant')
                                ->join('pericias','vista_pericia_grado_cant.pericia','pericias.id')
                                    ->select('idgrado',
                                            'abreviaturagrado',
                                            'pericias.nivel_pericia as pericia',
                                            'total')
                                    ->get();

        $destino_grado_pericia = DB::table('vista_destino_grado_pericia_cant')
                                        ->select('idd3',
                                                'descripciond3',
                                                'idgrado',
                                                'abreviaturagrado',
                                                'nombregrado',
                                                'pericia',
                                                'nivelgrado',
                                                'total')
                                        ->where('nivelgrado',3)
                                        ->get();
                                    
        $destinos = DB::table('personals as p')
                        ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
                        ->join('nivel3_destinos as nd3','nd3.id','pd.d3_cod')
                        ->join('personal_escalafones as pe','pe.per_codigo','pd.per_codigo')
                        ->join('grados as g','g.id','pe.gra_cod')
                        ->join('nivel2_destinos as nd2','nd2.id','pd.d2_cod')
                        ->join('personal_situaciones as ps','ps.per_codigo','p.per_codigo')
                        ->join('situaciones as s','s.id','ps.sit_cod')
                        ->join('detalle_situaciones as ds as pd','ds.id','ps.detsit_cod')
                        ->select('nd3.id as d3id',
                                'nd3.descripcion as d3descripcion',
                                DB::raw('count(nd3.id) as d3cantidad'))
                        ->where('pd.estado',1)
                        ->where('pe.estado',1)
                        ->where('s.id',1)
                        ->whereIn('ds.id',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
                        ->where('ps.estado',1)
                        ->where('per_cm','like','312%')
                        ->whereIn('g.id',[10,11,12,13,14,15,16,17])
                        ->groupBy('nd2.prioridad')
                        ->groupBy('nd2.id')
                        ->groupBy('nd3.id')
                        ->groupBy('pd.d3_cod')
                        ->groupBy('nd3.descripcion')
                        // ->groupBy('g.nivFalta')
                        ->orderBy('nd2.prioridad')
                        ->orderBy('nd2.id')
                        ->orderBy('nd3.id')
                        ->get();


        $grados_cant = DB::table('vista_grados_cant')
                    ->select('idgrado',
                        'abreviaturagrado',
                        'nombregrado',
                        'cantidadgrado')
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

        $pdf = PDF::loadView('reportes.cuadroPericias',['grados_pericia_cant'=>$grados_pericia_cant,
                                                        'destinos'=>$destinos,
                                                        'grados_cant'=>$grados_cant,
                                                        'destino_grado_pericia'=>$destino_grado_pericia,
                                                        'jefe_dpto'=>$jefe_dpto
                                                            ])

        ->setPaper('letter', 'portrait');                                               
        
        return $pdf->stream('reporte.pdf');
    }

    public function cuadroEfectivoTotal (Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10240M');

        $escalafon = DB::table('escalafones')
                        ->select('id',
                                'nombre')
                        ->where('estado',1)
                        ->get();

        $subescalafon_genero = DB::table('vista_subescalafon_grado_genero_cant')
                                ->select('idsubescalafon',
                                        'nombresubescalafon',
                                        'idgrado',
                                        'nombregrado',
                                        'generopersonal',
                                        'cantidad')
                                ->get();

        $genero = DB::table('vista_subescalafon_grado_genero_cant')
                                ->select('generopersonal')
                                ->groupBy('generopersonal')
                                ->orderBy('generopersonal')
                                ->get();

        $femenino = DB::table('vista_subescalafon_grado_genero_cant')
                                ->select('idsubescalafon',
                                'nombresubescalafon',
                                'idgrado',
                                'nombregrado',
                                'generopersonal',
                                'cantidad')
                                ->where('generopersonal','FEMENINO')
                                ->get();

        $masculino = DB::table('vista_subescalafon_grado_genero_cant')
                                ->select('idsubescalafon',
                                'nombresubescalafon',
                                'idgrado',
                                'nombregrado',
                                'generopersonal',
                                'cantidad')
                                ->where('generopersonal','MASCULINO')
                                ->get();

        $subescalafon_cant = DB::table('vista_subescalafon_cant')
                                ->select('idsubescalafon',
                                        'nombresubescalafon',
                                        'cantidad')
                                ->get();

        $genero_cant = DB::table('vista_genero_cant')
                                ->select('genero',
                                        'cantidad')
                                ->get();

        $grados_pericia_cant = DB::table('vista_pericia_grado_cant')
                                    ->select('idgrado',
                                            'abreviaturagrado',
                                            'pericia',
                                            'total')
                                    ->get();

        $destino_grado_pericia = DB::table('vista_destino_grado_pericia_cant')
                                        ->select('idd3',
                                                'descripciond3',
                                                'idgrado',
                                                'abreviaturagrado',
                                                'nombregrado',
                                                'pericia',
                                                'nivelgrado',
                                                'total')
                                        ->where('nivelgrado',3)
                                        ->get();
                                    
        $destinos = DB::table('personals as p')
                        ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
                        ->join('nivel3_destinos as nd3','nd3.id','pd.d3_cod')
                        ->join('personal_escalafones as pe','pe.per_codigo','pd.per_codigo')
                        ->join('grados as g','g.id','pe.gra_cod')
                        ->join('nivel2_destinos as nd2','nd2.id','pd.d2_cod')
                        ->join('personal_situaciones as ps','ps.per_codigo','p.per_codigo')
                        ->join('situaciones as s','s.id','ps.sit_cod')
                        ->join('detalle_situaciones as ds as pd','ds.id','ps.detsit_cod')
                        ->select('nd3.id as d3id',
                                'nd3.descripcion as d3descripcion',
                                DB::raw('count(nd3.id) as d3cantidad'))
                        ->where('pd.estado',1)
                        ->where('pe.estado',1)
                        ->where('s.id',1)
                        ->whereIn('ds.id',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
                        ->where('ps.estado',1)
                        ->where('per_cm','like','3%')
                        ->whereIn('g.id',[10,11,12,13,14,15,16,17])
                        ->groupBy('nd2.prioridad')
                        ->groupBy('nd2.id')
                        ->groupBy('nd3.id')
                        ->groupBy('pd.d3_cod')
                        ->groupBy('nd3.descripcion')
                        // ->groupBy('g.nivFalta')
                        ->orderBy('nd2.prioridad')
                        ->orderBy('nd2.id')
                        ->orderBy('nd3.id')
                        ->get();


        $grados_cant = DB::table('vista_grados_cant')
                    ->select('idgrado',
                        'abreviaturagrado',
                        'nombregrado',
                        'cantidadgrado')
                    ->get();

        $cantidad = DB::table('vista_destino_grado_cant')
        ->select('idd3',
                'descripciond3',
                'idgrado',
                'abreviaturagrado',
                'nombregrado',
                'nivelgrado',
                'total')
        ->where('nivelgrado',3)
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

        $pdf = PDF::loadView('reportes.cuadroEfectivoTotal',[
                                                        'subescalafon_genero'=>$subescalafon_genero,
                                                        'genero'=>$genero,
                                                        'femenino'=>$femenino,
                                                        'masculino'=>$masculino,
                                                        'subescalafon_cant'=>$subescalafon_cant,
                                                        'genero_cant'=>$genero_cant,
                                                        'escalafon'=>$escalafon,
                                                        'grados_pericia_cant'=>$grados_pericia_cant,
                                                        'destinos'=>$destinos,
                                                        'grados_cant'=>$grados_cant,
                                                        'destino_grado_pericia'=>$destino_grado_pericia,
                                                        'jefe_dpto'=>$jefe_dpto
                                                            ])
        ->setPaper('letter', 'portrait');                                               
        
        return $pdf->stream('reporte.pdf');

    }

    public function cuadroEgresadosNoEgresados(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10240M');
        $escalafon = $request->esc;

        switch ($escalafon) {
            case 'O':
                $egresado = DB::table('vista_egresado_noegresado')
                                ->select('per_cm',
                                        'nivelfalta',
                                        'idgrado',
                                        'grado',
                                        'paterno',
                                        'materno',
                                        'nombre',
                                        'situacion',
                                        'instituto')
                                ->whereIn('nivelfalta',[1,2])
                                ->get();
                break;
            case 'ST':
                $egresado = DB::table('vista_egresado_noegresado')
                                ->select('per_cm',
                                        'nivelfalta',
                                        'idgrado',
                                        'grado',
                                        'paterno',
                                        'materno',
                                        'nombre',
                                        'situacion',
                                        'instituto')
                                ->whereIn('idgrado',[10,11,12,13,14,15,16,17])
                                ->where('nivelfalta',3)
                                ->get();
                break;
            case 'SM':
                $egresado = DB::table('vista_egresado_noegresado')
                                ->select('per_cm',
                                        'nivelfalta',
                                        'idgrado',
                                        'grado',
                                        'paterno',
                                        'materno',
                                        'nombre',
                                        'situacion',
                                        'instituto')
                                ->whereIn('idgrado',[164,165,166,168,169,170,171,172])
                                ->where('nivelfalta',3)
                                ->get();
                break;
            case 'C':
                $egresado = DB::table('vista_egresado_noegresado')
                                ->select('per_cm',
                                        'nivelfalta',
                                        'idgrado',
                                        'grado',
                                        'paterno',
                                        'materno',
                                        'nombre',
                                        'situacion',
                                        'instituto')
                                ->where('nivelfalta',4)
                                ->get();
                break;
            case 'T':
                $egresado = DB::table('vista_egresado_noegresado')
                                ->select('per_cm',
                                        'nivelfalta',
                                        'idgrado',
                                        'grado',
                                        'paterno',
                                        'materno',
                                        'nombre',
                                        'situacion',
                                        'instituto')
                                ->get();
                break;
            
            default:
                # code...
                break;
        }
        
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

        $pdf = PDF::loadView('reportes.cuadroEgresadoNoEgresado',['egresado'=>$egresado,
                                                        'jefe_dpto'=>$jefe_dpto
                                                            ])
        ->setPaper('letter', 'portrait');                                               

        return $pdf->stream('reporte.pdf');
    }

    public function cuadroFamiliaresPersonal(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10240M');
        $escalafon = $request->esc;

        switch ($escalafon) {
                case 'O':
                        $familiar = DB::table('vista_familiares_personal')
                                        ->select('per_cm',
                                                'nivelfalta',
                                                'idgrado',
                                                'grado',
                                                'gradofin',
                                                'nombretitular',
                                                'nombrefamiliar',
                                                'parentesco')
                                        ->whereIn('nivelfalta',[1,2])
                                        ->get();
                        break;
                case 'ST':
                        $familiar = DB::table('vista_familiares_personal')
                                        ->select('per_cm',
                                                'nivelfalta',
                                                'idgrado',
                                                'grado',
                                                'gradofin',
                                                'nombretitular',
                                                'nombrefamiliar',
                                                'parentesco')
                                        ->whereIn('idgrado',[10,11,12,13,14,15,16,17])
                                        ->where('nivelfalta',3)
                                        ->get();
                        break;
                case 'SM':
                        $familiar = DB::table('vista_familiares_personal')
                                        ->select('per_cm',
                                                'nivelfalta',
                                                'idgrado',
                                                'grado',
                                                'gradofin',
                                                'nombretitular',
                                                'nombrefamiliar',
                                                'parentesco')
                                        ->whereIn('idgrado',[164,165,166,168,169,170,171,172])
                                        ->where('nivelfalta',3)
                                        ->get();
                        break;
                case 'C':
                        $familiar = DB::table('vista_familiares_personal')
                                        ->select('per_cm',
                                                'nivelfalta',
                                                'idgrado',
                                                'grado',
                                                'gradofin',
                                                'nombretitular',
                                                'nombrefamiliar',
                                                'parentesco')
                                        ->where('nivelfalta',4)
                                        ->get();
                        break;
                case 'T':
                        $familiar = DB::table('vista_familiares_personal')
                                        ->select('per_cm',
                                                'nivelfalta',
                                                'idgrado',
                                                'grado',
                                                'gradofin',
                                                'nombretitular',
                                                'nombrefamiliar',
                                                'parentesco')
                                        ->get();
                        break;
                
                default:
                        # code...
                        break;
        }
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

        $pdf = PDF::loadView('reportes.cuadroFamiliaresPersonal',['familiar'=>$familiar,
                                                        'jefe_dpto'=>$jefe_dpto
                                                            ])
        ->setPaper('letter', 'portrait');                                               

        return $pdf->stream('reporte.pdf');
    }

    public function cuadroPromocionCant(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10240M');
        $escalafon = $request->esc;
        
        switch ($escalafon) {
                case 'O':
                        $grados = DB::table('vista_grados_cant')
                                        ->select('idgrado',
                                                'abreviaturagrado',
                                                'nombregrado',
                                                'nivelgrado',
                                                'cantidadgrado')
                                        ->whereIn('nivelgrado',[1,2])
                                        ->get();

                        $promocion = DB::table('vista_promocion_cant')
                                        ->select('promocion',
                                                'division',
                                                'cantidad')
                                        ->where('division',1)
                                        ->get();

                        $promocion_grados = DB::table('vista_promocion_grado_cant')
                                                ->select('promocion',
                                                        'nivelfalta',
                                                        'divisiongrado',
                                                        'idgrado',
                                                        'abreviaturagrado',
                                                        'nombregrado',
                                                        'cantidad')
                                                ->where('divisiongrado',1)
                                                ->get();
                        break;
                case 'ST':
                        $grados = DB::table('vista_grados_cant')
                                        ->select('idgrado',
                                                'abreviaturagrado',
                                                'nombregrado',
                                                'nivelgrado',
                                                'cantidadgrado')
                                        ->whereIn('idgrado',[10,11,12,13,14,15,16,17])
                                        ->where('nivelgrado',3)
                                        ->get();

                        $promocion = DB::table('vista_promocion_cant')
                                        ->select('promocion',
                                                'division',
                                                'cantidad')
                                        ->where('division',2)
                                        ->get();

                        $promocion_grados = DB::table('vista_promocion_grado_cant')
                                                ->select('promocion',
                                                        'nivelfalta',
                                                        'divisiongrado',
                                                        'idgrado',
                                                        'abreviaturagrado',
                                                        'nombregrado',
                                                        'cantidad')
                                                ->where('divisiongrado',2)
                                                ->get();
                        break;
                case 'SM':
                        $grados = DB::table('vista_grados_cant')
                                        ->select('idgrado',
                                                'abreviaturagrado',
                                                'nombregrado',
                                                'nivelgrado',
                                                'cantidadgrado')
                                        ->whereIn('idgrado',[164,165,166,168,169,170,171,172])
                                        ->where('nivelgrado',3)
                                        ->get();

                        $promocion = DB::table('vista_promocion_cant')
                                        ->select('promocion',
                                                'division',
                                                'cantidad')
                                        ->where('division',3)
                                        ->get();

                        $promocion_grados = DB::table('vista_promocion_grado_cant')
                                                ->select('promocion',
                                                        'nivelfalta',
                                                        'divisiongrado',
                                                        'idgrado',
                                                        'abreviaturagrado',
                                                        'nombregrado',
                                                        'cantidad')
                                                ->where('divisiongrado',3)
                                                ->get();
                        break;
                case 'C':
                        $grados = DB::table('vista_grados_cant')
                                        ->select('idgrado',
                                                'abreviaturagrado',
                                                'nombregrado',
                                                'nivelgrado',
                                                'cantidadgrado')
                                        ->where('nivelgrado',4)
                                        ->get();

                        $promocion = DB::table('vista_promocion_cant')
                                        ->select('promocion',
                                                'division',
                                                'cantidad')
                                        ->whereIn('division',[0,4])
                                        ->orderBy('division','asc')
                                        ->get();

                        $promocion_grados = DB::table('vista_promocion_grado_cant')
                                                ->select('promocion',
                                                        'nivelfalta',
                                                        'divisiongrado',
                                                        'idgrado',
                                                        'abreviaturagrado',
                                                        'nombregrado',
                                                        'cantidad')
                                                ->whereIn('divisiongrado',[0,4])
                                                ->orderBy('divisiongrado','asc')
                                                ->get();
                        break;
                case 'T':
                        $grados = DB::table('vista_grados_cant')
                                        ->select('idgrado',
                                                'abreviaturagrado',
                                                'nombregrado',
                                                'nivelgrado',
                                                'cantidadgrado')
                                        // ->where('nivelgrado',4)
                                        ->get();

                        $promocion = DB::table('vista_promocion_cant')
                                        ->select('promocion',
                                                'division',
                                                'cantidad')
                                        // ->whereIn('division',[0,4])
                                        ->get();

                        $promocion_grados = DB::table('vista_promocion_grado_cant')
                                                ->select('promocion',
                                                        'nivelfalta',
                                                        'divisiongrado',
                                                        'idgrado',
                                                        'abreviaturagrado',
                                                        'nombregrado',
                                                        'cantidad')
                                                // ->whereIn('divisiongrado',[0,4])
                                                ->get();
                        break;
                
                default:
                        # code...
                        break;
        }

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

        $pdf = PDF::loadView('reportes.cuadroPromocionCant',['grados'=>$grados,
                                                        'promocion'=>$promocion,
                                                        'promociongrados'=>$promocion_grados,
                                                        'jefe_dpto'=>$jefe_dpto
                                                            ])
        ->setPaper('letter', 'portrait');                                               

        return $pdf->stream('reporte.pdf');
    }

    public function cuadroSituacionPersonal(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10240M');
        $escalafon = $request->esc;

        switch ($escalafon) {
                case 'O':
                        $situacion = DB::table('vista_situacion_personal')
                                        ->select('cm',
                                                'idgrado',
                                                'nivelfalta',
                                                'division',
                                                'grado',
                                                'nombre',
                                                'nomsit',
                                                'nomdetsit')
                                        ->whereIn('nivelfalta',[1,2])
                                        ->get();
                        break;
                case 'ST':
                        $situacion = DB::table('vista_situacion_personal')
                                        ->select('cm',
                                                'idgrado',
                                                'nivelfalta',
                                                'division',
                                                'grado',
                                                'nombre',
                                                'nomsit',
                                                'nomdetsit')
                                        ->whereIn('idgrado',[10,11,12,13,14,15,16,17])
                                        ->where('nivelfalta',3)
                                        ->get();
                        break;
                case 'SM':
                        $situacion = DB::table('vista_situacion_personal')
                                        ->select('cm',
                                                'idgrado',
                                                'nivelfalta',
                                                'division',
                                                'grado',
                                                'nombre',
                                                'nomsit',
                                                'nomdetsit')
                                        ->whereIn('idgrado',[164,165,166,168,169,170,171,172])
                                        ->where('nivelfalta',3)
                                        ->get();
                        break;
                case 'C':
                        $situacion = DB::table('vista_situacion_personal')
                                        ->select('cm',
                                                'idgrado',
                                                'nivelfalta',
                                                'division',
                                                'grado',
                                                'nombre',
                                                'nomsit',
                                                'nomdetsit')
                                        ->where('nivelfalta',4)
                                        ->get();
                        break;
                case 'T':
                        $situacion = DB::table('vista_situacion_personal')
                                        ->select('cm',
                                                'idgrado',
                                                'nivelfalta',
                                                'division',
                                                'grado',
                                                'nombre',
                                                'nomsit',
                                                'nomdetsit')
                                        ->get();
                        break;
                
                default:
                        # code...
                        break;
        }
        
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

        $pdf = PDF::loadView('reportes.cuadroSituacionPersonal',['situacion'=>$situacion,
                                                        'jefe_dpto'=>$jefe_dpto
                                                            ])
        ->setPaper('letter', 'portrait');                                               

        return $pdf->stream('reporte.pdf');
    }

    public function cuadroFechaIncorporacion(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10240M');
        $escalafon = $request->esc;

        switch ($escalafon) {
                case 'O':
                        $incorporacion = DB::table('vista_fecha_incorporacion')
                                        ->select('cm',
                                                'idgrado',
                                                'nivelfalta',
                                                'division',
                                                'grado',
                                                'gradofin',
                                                'nombre',
                                                'fechaincorporacion',
                                                'nomsit')
                                        ->whereIn('nivelfalta',[1,2])
                                        ->get();
                        break;
                case 'ST':
                        $incorporacion = DB::table('vista_fecha_incorporacion')
                                        ->select('cm',
                                                'idgrado',
                                                'nivelfalta',
                                                'division',
                                                'grado',
                                                'gradofin',
                                                'nombre',
                                                'fechaincorporacion',
                                                'nomsit')
                                        ->whereIn('idgrado',[10,11,12,13,14,15,16,17])
                                        ->where('nivelfalta',3)
                                        ->get();
                        break;
                case 'SM':
                        $incorporacion = DB::table('vista_fecha_incorporacion')
                                        ->select('cm',
                                                'idgrado',
                                                'nivelfalta',
                                                'division',
                                                'grado',
                                                'gradofin',
                                                'nombre',
                                                'fechaincorporacion',
                                                'nomsit')
                                        ->whereIn('idgrado',[164,165,166,168,169,170,171,172])
                                        ->where('nivelfalta',3)
                                        ->get();
                        break;
                case 'C':
                        $incorporacion = DB::table('vista_fecha_incorporacion')
                                        ->select('cm',
                                                'idgrado',
                                                'nivelfalta',
                                                'division',
                                                'grado',
                                                'gradofin',
                                                'nombre',
                                                'fechaincorporacion',
                                                'nomsit')
                                        ->where('nivelfalta',4)
                                        ->get();
                        break;
                case 'T':
                        $incorporacion = DB::table('vista_fecha_incorporacion')
                                        ->select('cm',
                                                'idgrado',
                                                'nivelfalta',
                                                'division',
                                                'grado',
                                                'gradofin',
                                                'nombre',
                                                'fechaincorporacion',
                                                'nomsit')
                                        ->get();
                        break;
                
                default:
                        # code...
                        break;
        }
        
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

        $pdf = PDF::loadView('reportes.cuadroFechaIncorporacion',['incorporacion'=>$incorporacion,
                                                        'jefe_dpto'=>$jefe_dpto
                                                            ])
        ->setPaper('letter', 'portrait');                                               

        return $pdf->stream('reporte.pdf');
    }
    
}
