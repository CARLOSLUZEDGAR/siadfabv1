<?php

namespace App\Http\Controllers;

use App\Nivel3Destino;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Nivel3_destinoController extends Controller
{
    //
    public function ListarDestino3(Request $request)
    {
        # code....
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '' ) {
            $destino3 = DB::table('nivel3_destinos')
            ->join('nivel2_destinos', 'nivel3_destinos.d2_cod', '=', 'nivel2_destinos.id')
            ->join('nivel1_destinos', 'nivel2_destinos.d1_cod', '=', 'nivel1_destinos.id')   
            ->join('departamentos','nivel3_destinos.depa_cod', '=', 'departamentos.id')
            ->join('provincias','nivel3_destinos.prov_cod','=', 'provincias.id')       
            ->select('nivel1_destinos.id AS id1', 
                    'nivel1_destinos.descripcion AS descripcion1',
                    'nivel2_destinos.id AS id2', 
                    'nivel2_destinos.d1_cod', 
                    'nivel2_destinos.descripcion AS descripcion2',
                    'nivel3_destinos.id AS id3', 
                    'nivel3_destinos.d2_cod',
                    'nivel3_destinos.depa_cod',
                    'nivel3_destinos.prov_cod',
                    'nivel3_destinos.descripcion AS descripcion3',
                    'nivel3_destinos.abreviatura',
                    'nivel3_destinos.tipo',
                    'nivel3_destinos.prioridad',
                    'nivel3_destinos.frontera',
                    'nivel3_destinos.orden',
                    'nivel3_destinos.cod_mindef',
                    'nivel3_destinos.observacion',
                    'nivel3_destinos.estado',
                    'nivel3_destinos.ogd',
                    'departamentos.nombre AS depa_nombre',
                    'provincias.nombre AS prov_nombre'
                    )
            ->orderBy('nivel1_destinos.id','asc')
            ->orderBy('descripcion2','asc')
            ->orderBy('descripcion3','asc')
            ->paginate(10);

        }
        else{
            $destino3 = DB::table('nivel3_destinos')
            ->join('nivel2_destinos', 'nivel3_destinos.d2_cod', '=', 'nivel2_destinos.id')
            ->join('nivel1_destinos', 'nivel2_destinos.d1_cod', '=', 'nivel1_destinos.id')
            ->join('departamentos','nivel3_destinos.depa_cod', '=', 'departamentos.id')       
            ->join('provincias','nivel3_destinos.prov_cod','=', 'provincias.id')      
            ->select('nivel1_destinos.id AS id1', 
                    'nivel1_destinos.descripcion AS descripcion1',
                    'nivel2_destinos.id AS id2', 
                    'nivel2_destinos.d1_cod', 
                    'nivel2_destinos.descripcion AS descripcion2',
                    'nivel3_destinos.id AS id3', 
                    'nivel3_destinos.d2_cod',
                    'nivel3_destinos.depa_cod',
                    'nivel3_destinos.prov_cod',
                    'nivel3_destinos.descripcion AS descripcion3',
                    'nivel3_destinos.abreviatura',
                    'nivel3_destinos.tipo',
                    'nivel3_destinos.prioridad',
                    'nivel3_destinos.frontera',
                    'nivel3_destinos.orden',
                    'nivel3_destinos.cod_mindef',
                    'nivel3_destinos.observacion',
                    'nivel3_destinos.estado',
                    'nivel3_destinos.ogd',
                    'departamentos.nombre AS depa_nombre',
                    'provincias.nombre AS prov_nombre'
                    )
            ->where($criterio,'like','%'.$buscar.'%')
            ->orderBy('nivel1_destinos.id','asc')
            ->orderBy('descripcion2','asc')
            ->orderBy('descripcion3','asc')
            ->paginate(10);
        }
        
        //return response()->json($destino3);
        return [
            'pagination' => [
                'total'         => $destino3->total(),
                'current_page'  => $destino3->currentPage(),
                'per_page'      => $destino3->perPage(),
                'last_page'     => $destino3->lastPage(),
                'from'          => $destino3->firstItem(),
                'to'            => $destino3->lastItem(),
            
            ],
            'destino3' => $destino3
        ];
    }

    public function RegistrarDestino3(Request $request) //CUATRO
    {
        //return response()->json($request);
        $destino3 = Nivel3Destino::create([
            'd2_cod' =>$request->destn2,
            'depa_cod' => $request->depa_cod,
            'prov_cod' => $request->prov_cod,
            'descripcion' => $request->des,
            'abreviatura' => $request->abreviatura,
            'tipo' => $request->tip, 
            'prioridad' => $request->pri,
            'frontera' => $request->fro,
            'orden' => $request->ord,
            'cod_mindef' => $request->cod,
            'observacion' => $request->obs,
            'estado' => '1', 
            'ogd' => $request->ogd,
            'sysuser' => Auth::user()->id

        ]);
        // return response()->json($request); //Con esto podemos ver que estamos recibiendo
        return response()->json($destino3); //Con esto podemos ver los datos que nos devuelve personal
    }

    public function EditarDestino3(Request $request)//CUATRO_4
    {
        //return response()->json($request);
        $destino3 = Nivel3Destino::Where('id',$request->id)->first(); //con esta linea llamamos al per que es el per_Codigo de la persona
        $destino3->update([
            'd2_cod' =>$request->destn2,
            'depa_cod' => $request->depa_cod,
            'prov_cod' => $request->prov_cod,
            'descripcion' => $request->des,
            'abreviatura' => $request->abreviatura,
            'tipo' => $request->tip, 
            'prioridad' => $request->pri,
            'frontera' => $request->fro,
            'orden' => $request->ord,
            'cod_mindef' => $request->cod,
            'observacion' => $request->obs,
            'estado' => '1', 
            'ogd' => $request->ogd,
            'sysuser' => Auth::user()->id
        ]);
        //return response()->json($request);
        return response()->json($destino3); 
    }

    public function DesactivarDestino3(Request $request)//CUATRO_4
    {
        
        $destino3 = Nivel3Destino::Where('id',$request->id)->first();//con esta linea llamamos al per que es el per_Codigo de la persona
        
        $destino3->update([
            'estado' => '0', 
        ]);

        return response()->json($request); 
    }

    public function ActivarDestino3(Request $request)//CUATRO_4
    {
        $destino3 = Nivel3Destino::Where('id',$request->id)->first(); //con esta linea llamamos al per que es el per_Codigo de la persona
        $destino3->update([
            'estado' => '1', 
        ]);
        return response()->json($destino3); 
    }

    public function selectDestinosNivel3(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $destino3 = DB::connection('pgsql_server')->table('nivel3_destinos')
        ->where('estado','=','1') //filtramos a todas las categorias que estan activas
        ->select('id','descripcion')
        ->orderBy('descripcion','asc')->get();//seleecionamos los campos id, nombre  con get() se obtiene el listado

        return ['destino3' => $destino3]; //mandamos todo el listado en la variable listado
    }

    public function selectbuscarDestinosNivel3(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $destino3 = DB::connection('pgsql_server')->table('nivel3_destinos')
        ->where('d2_cod','=',$buscar)
        ->where('estado','=','1')
        ->select('id','descripcion')
        ->orderBy('descripcion', 'asc')->get();
        return ['destino3' => $destino3];
    }

    

    // public function GenerarPdfDestinos3(Request $request)
    // {
    //     $destino3 = DB::table('nivel3_destinos')
    //         ->join('nivel2_destinos', 'nivel3_destinos.d2_cod', '=', 'nivel2_destinos.id')
    //         ->join('nivel1_destinos', 'nivel2_destinos.d1_cod', '=', 'nivel1_destinos.id')          
    //         ->select('nivel1_destinos.id AS id1', 'nivel1_destinos.descripcion AS descripcion1','nivel2_destinos.id AS id2', 'nivel2_destinos.d1_cod', 'nivel2_destinos.descripcion AS descripcion2', 'nivel3_destinos.id AS id3','nivel3_destinos.d2_cod','nivel3_destinos.descripcion AS descripcion3','nivel3_destinos.tipo','nivel3_destinos.prioridad','nivel3_destinos.frontera','nivel3_destinos.orden','nivel3_destinos.cod_mindef','nivel3_destinos.estado','nivel3_destinos.observacion') 
    //         ->orderBy('nivel1_destinos.descripcion AS descripcion1','asc')
    //         ->orderBy('nivel2_destinos.descripcion AS descripcion2','asc')
    //         ->orderBy('nivel3_destinos.descripcion AS descripcion3','asc')
    //         ->get();

    //     $cont = Nivel3Destino::count();

    //     $pdf = PDF::loadView('reportes.listardestino3', compact('destinos3', 'cont'))
    //     ->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')
    //     ->setWarnings(false);
        
    //     return $pdf->stream(date('Ymd-H-i-s').'Destinos3'.'.pdf');
    // }
}
