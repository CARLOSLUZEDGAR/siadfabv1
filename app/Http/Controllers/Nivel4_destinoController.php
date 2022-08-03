<?php

namespace App\Http\Controllers;

use App\Nivel4Destino;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Nivel4_destinoController extends Controller
{
    //
    public function ListarDestino4(Request $request)
    {
        # code....
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '' ) {
            $destino4 = DB::table('nivel4_destinos')
            ->join('nivel3_destinos', 'nivel4_destinos.d3_cod', '=', 'nivel3_destinos.id')
            ->join('nivel2_destinos', 'nivel3_destinos.d2_cod', '=', 'nivel2_destinos.id')
            ->join('nivel1_destinos', 'nivel2_destinos.d1_cod', '=', 'nivel1_destinos.id')          
            ->select('nivel1_destinos.id AS id1', 
                    'nivel1_destinos.descripcion AS descripcion1',
                    'nivel2_destinos.id AS id2', 
                    'nivel2_destinos.d1_cod',
                    'nivel2_destinos.descripcion AS descripcion2', 
                    'nivel3_destinos.id AS id3', 
                    'nivel3_destinos.d2_cod',
                    'nivel3_destinos.descripcion AS descripcion3',
                    'nivel4_destinos.id AS id4', 
                    'nivel4_destinos.d3_cod',
                    'nivel4_destinos.descripcion AS descripcion4',
                    'nivel4_destinos.orden',
                    'nivel4_destinos.puntaje',
                    'nivel4_destinos.observacion',
                    'nivel4_destinos.estado',
                    'nivel4_destinos.ogd',
                    ) 
            ->orderBy('nivel1_destinos.id','asc')
            ->orderBy('descripcion2','asc')
            ->orderBy('descripcion3','asc')
            ->orderBy('nivel4_destinos.orden','asc')
            ->paginate(10);

        }
        else{
            $destino4 = DB::table('nivel4_destinos')
            ->join('nivel3_destinos', 'nivel4_destinos.d3_cod', '=', 'nivel3_destinos.id')
            ->join('nivel2_destinos', 'nivel3_destinos.d2_cod', '=', 'nivel2_destinos.id')
            ->join('nivel1_destinos', 'nivel2_destinos.d1_cod', '=', 'nivel1_destinos.id')          
            ->select('nivel1_destinos.id AS id1', 
                    'nivel1_destinos.descripcion AS descripcion1',
                    'nivel2_destinos.id AS id2', 
                    'nivel2_destinos.d1_cod',
                    'nivel2_destinos.descripcion AS descripcion2', 
                    'nivel3_destinos.id AS id3', 
                    'nivel3_destinos.d2_cod',
                    'nivel3_destinos.descripcion AS descripcion3',
                    'nivel4_destinos.id AS id4', 
                    'nivel4_destinos.d3_cod',
                    'nivel4_destinos.descripcion AS descripcion4',
                    'nivel4_destinos.orden',
                    'nivel4_destinos.puntaje',
                    'nivel4_destinos.observacion',
                    'nivel4_destinos.estado',
                    'nivel4_destinos.ogd',
                    )
            ->where($criterio,'like','%'.$buscar.'%')
            ->orderBy('nivel1_destinos.id','asc')
            ->orderBy('descripcion2','asc')
            ->orderBy('descripcion3','asc')
            ->orderBy('nivel4_destinos.orden','asc')
            ->paginate(10);

        }
        
        //return response()->json($destinos2);
        return [
            'pagination' => [
                'total'         => $destino4->total(),
                'current_page'  => $destino4->currentPage(),
                'per_page'      => $destino4->perPage(),
                'last_page'     => $destino4->lastPage(),
                'from'          => $destino4->firstItem(),
                'to'            => $destino4->lastItem(),
            
            ],
            'destino4' => $destino4
        ];
    }

    public function RegistrarDestino4(Request $request) //CUATRO
    {
        $destino4 = Nivel4Destino::create([
            'd3_cod' =>$request->destn3,
            'descripcion' => $request->des,
            'orden' => $request->ord, 
            'puntaje' => $request->pun,
            'observacion' => $request->obs,
            'estado' => '1', 
            'ogd' => $request->ogd,
            'sysuser' => Auth::user()->id
        ]);
        // return response()->json($request); //Con esto podemos ver que estamos recibiendo
        return response()->json($destino4); //Con esto podemos ver los datos que nos devuelve personal
    }

    public function EditarDestino4(Request $request)//CUATRO_4
    {
       // return response()->json($request->ogd);
        $destino4 = Nivel4Destino::Where('id',$request->id)->first(); //con esta linea llamamos al per que es el per_Codigo de la persona
        $destino4->update([
            'd3_cod' =>$request->destn3,
            'descripcion' => $request->des,
            'orden' => $request->ord, 
            'puntaje' => $request->pun,
            'observacion' => $request->obs,
            'estado' => '1',
            'ogd' => $request->ogd,
            'sysuser' => Auth::user()->id
        ]);
        //return response()->json($request);
        return response()->json($destino4); 
    }

    public function DesactivarDestinos4(Request $request)//CUATRO_4
    {
        
        $destino4 = Nivel4Destino::Where('id',$request->id)->first();//con esta linea llamamos al per que es el per_Codigo de la persona
        
        $destino4->update([
            'estado' => '0', 
        ]);

        return response()->json($request); 
    }

    public function ActivarDestinos4(Request $request)//CUATRO_4
    {
        $destino4 = Nivel4Destino::Where('id',$request->id)->first(); //con esta linea llamamos al per que es el per_Codigo de la persona
        $destino4->update([
            'estado' => '1', 
        ]);
        return response()->json($destino4); 
    }

    public function selectDestinosNivel4(Request $request)
    {
        // if(!$request->ajax()) return view('/');
         $destinos_nivel4 = DB::table('nivel4_destinos')
         ->where('estado','=','1')
         ->select('id','descripcion')
         ->orderBy('descripcion','asc')
         ->get();
         return['destino4' => $destinos_nivel4];
    }


    public function selectbuscarDestinosNivel4(Request $request)
    {

        $buscar = $request->buscar;
        // if (!$request->ajax()) return redirect('/');
        $destinos_nivel4 = DB::table('nivel4_destinos')      
        ->where('d3_cod','=',$buscar)
        ->where('estado','=','1')
        ->select('id','descripcion')
        ->orderBy('descripcion', 'asc')
        ->get();
        return ['destino4' => $destinos_nivel4];
    }

    

    // public function GenerarPdfDestinos4(Request $request)
    // {
    //         $destino4 = DB::table('nivel4_destinos')
    //         ->join('nivel3_destinos', 'nivel4_destinos.d3_cod', '=', 'nivel3_destinos.id')
    //         ->join('nivel2_destinos', 'nivel3_destinos.d2_cod', '=', 'nivel2_destinos.id')
    //         ->join('nivel1_destinos', 'nivel2_destinos.d1_cod', '=', 'nivel1_destinos.id')          
    //         ->select('nivel1_destinos.id AS id1', 'nivel1_destinos.descripcion AS descripcion1 ',
    //                  'nivel2_destinos.id AS id2', 'nivel2_destinos.d1_cod','nivel2_destinos.descripcion AS descripcion2', 
    //                  'nivel3_destinos.id AS id3', 'nivel3_destinos.d2_cod','nivel3_destinos.descripcion AS descripcion3',
    //                  'nivel4_destinos.id AS id4', 'nivel4_destinos.d3_cod','nivel4_destinos.descripcion AS descripcion4','nivel4_destinos.orden','nivel4_destinos.puntaje','nivel4_destinos.estado','nivel4_destinos.sysuser','nivel4_destinos.observacion' ) 
    //         ->orderBy('nivel1_destinos.descripcion AS descripcion1 ','asc')
    //         ->orderBy('nivel2_destinos.descripcion AS descripcion2','asc')
    //         ->orderBy('nivel3_destinos.descripcion AS descripcion3','asc')
    //         ->orderBy('nivel4_destinos.descripcion AS descripcion4','asc')
    //         ->get();

        
    //     $cont = Nivel4Destino::count();
    //     $old_limit = ini_set("memory_limit", "120M");
    //     $pdf = PDF::loadView('reportes.listardestino4', compact('destinos4', 'cont'))
    //     ->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')
    //     ->setWarnings(false);
        
    //     return $pdf->download(date('Ymd-H-i-s').'Destinos4'.'.pdf');
    // }
}
