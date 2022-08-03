<?php

namespace App\Http\Controllers;

use App\Modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatosController extends Controller
{
    /**
     * Funciones para listar en vue selects
     */

    public function Especialidades()
    {
        $especialidad = DB::table('especialidades')
            ->select('id','nombre')
            ->get();
        
        return response()->json($especialidad);
    }

    public function SubEspecialidades(Request $request)
    {
        $id = $request->id;
        $subespecialidad = DB::table('subespecialidades')
            ->select('id','nombre')
            ->where('espe_cod', $id)
            ->get();
        
        return response()->json($subespecialidad);
    }

    public function ListarModulos()
    {
        $modulos = Modulo::all();

        return response()->json($modulos);
    }

    public function ListarRoles()
    {
        $role = Role::all();

        return response()->json($role);
    }

    /**
     * FUNCIONES PARA 
     */
    public function Escalafon()
    {
        $escalafon = DB::table('escalafones')
            ->select('id', 'nombre')
            ->where('estado',1)
            ->get();
        
        return response()->json($escalafon);
    }

    public function SubEscalafon(Request $request)
    {
        $escalafon = $request->escalafon;
        $subescalafon = DB::table('subescalafones')
            ->select('id','nombre')
            ->where('esca_cod', $escalafon)
            ->where('estado',1)
            ->orderBy('orden')
            ->get();
        return response()->json($subescalafon);

    }

    /**
     * Grados por escalafon
     */
    public function Grado(Request $request)
    {
        $subescalafon = $request->subescalafon;
        $grado = DB::table('grados')
            ->select('id', 'nombre', 'abreviatura')
            ->where('subesc_cod',$subescalafon)
            ->where('estado',1)
            ->orderBy('orden')
            ->get();
        return response()->json($grado);
    }

    /**
     * Grados por Division
     */
    public function GradoClasificacion(Request $request)
    {
        $division = $request->division;
        $grado = DB::table('grados')
            ->select('id', 'nombre as descripcion')
            ->where('division',$division)
            ->where('estado',1)
            ->orderBy('orden')
            ->get();
        return response()->json($grado);
    }

    public function Estudios()
    {
        $estudio = DB::table('estudios')
            ->select('id','descripcion as nombre','abreviatura')
            ->orderBy('correlativo')
            ->where('estado',1)
            ->get();
        return response()->json($estudio);
    }

    public function EstudiosDem()
    {
        $estudio = DB::table('estudios')
            ->select('id','descripcion as nombre','abreviatura')
            ->whereBetween('id', [1, 36])
            ->orderBy('correlativo')
            ->where('estado',1)
            ->get();
        return response()->json($estudio);
    }

    public function Situacion()
    {
        $situacion = DB::table('situaciones')
            ->select('id','nombre')
            ->orderBy('nombre')
            ->where('estado',1)
            ->get();
        return response()->json($situacion);
    }

    public function SubSituacion(Request $request)
    {
        $situacion = $request->situacion;
        $subsituacion = DB::table('subsituaciones')
            ->select('id','nombre')
            ->where('sit_cod',$situacion)
            ->where('estado',1)
            ->orderBy('nombre')
            ->get();
        return response()->json($subsituacion);
    }

    public function DetalleSituacion(Request $request)
    {
        $subsituacion = $request->subsituacion;
        $detallesituacion = DB::table('detalle_situaciones')
            ->select('id','nombre')
            ->where('subsit_cod',$subsituacion)
            ->where('estado',1)
            ->orderBy('nombre')
            ->get();
        return response()->json($detallesituacion);
    }

    public function Departamentos()
    {
        $departamento = DB::table('departamentos')
            ->select('id','nombre')
            ->where('estado',1)
            ->orderBy('nombre')
            ->get();
        return response()->json($departamento);
    }

    public function Provincias(Request $request)
    {
        $departamento = $request->departamento;
        $provincia = DB::table('provincias')
            ->select('id','nombre')
            ->where('depa_codigo',$departamento)
            ->where('estado',1)
            ->orderBy('nombre')
            ->get();
        return response()->json($provincia);
    }

    public function Localidades(Request $request)
    {
        $provincia = $request->provincia;
        $localidad = DB::table('localidades')
            ->select('id', 'nombre')
            ->where('prov_codigo',$provincia)
            ->where('estado',1)
            ->orderBy('nombre')
            ->get();
        return response()->json($localidad);
    }

    /**
     * FUNCION PARA FALTAS DICIPLINARIAS ojo rehacer
     */
    public function NombreUnidad()
    {
        $unidad = DB::table('personal_destinos as pd')
                ->join('nivel3_destinos as d3','pd.d3_cod','d3.id')
                ->select('d3.descripcion','d3.id')
                ->where('pd.per_codigo',Auth::user()->percod)
                ->where('pd.estado',1)
                ->first();
        return response()->json($unidad);            
    }

    /**
     * ACCEDE A LOS DATOS DEL USUARIO LOGUEADO
     */
    public function datosP()
    {
        $datos = DB::table('personal_escalafones as ep')
            ->join('personals as p','ep.per_codigo','p.per_codigo')
            ->join('grados as g','ep.gra_cod','g.id')
            ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->join('personal_situaciones as ps','p.per_codigo','ps.per_codigo')
            ->join('subsituaciones as ss','ps.subsit_cod','ss.id')
            ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
            ->select('p.per_nombre as nombre','p.per_paterno as paterno','g.abreviatura as grado','e.abreviatura as complemento')
            ->where('ep.per_codigo',Auth::user()->percod)
            ->where('ps.estado',1)
            ->where('ep.estado',1)
            ->where('epe.estado',1)
            ->where('pd.estado',1)
            ->first();
        
            return response()->json($datos);
    }

    /**
     * Validacion si existe abreviatura del registro en nivel3_destinos
     */

    public function ValidarAbrevDestino3(Request $request)
    {
        $unidad = DB::table('personal_destinos as pd')
                ->join('nivel3_destinos as d3','pd.d3_cod','d3.id')
                ->select('d3.abreviatura')
                ->where('pd.per_codigo',Auth::user()->percod)
                ->where('pd.estado',1)
                ->first();
        
        if ($unidad->abreviatura) {
            $code = 200;
        } else {
            $code = 400;
        }
        return response()->json($code);
    }

    public function guardarAbreviaturaDestino3(Request $request)
    {
        DB::table('nivel3_destinos')
            ->where('id',$request->unidad)
            ->update([
                'abreviatura' => $request->abreviatura
            ]);
        return response()->json($request);
    }
}
