<?php

namespace App\Http\Controllers;

use App\Nivel2Destino;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Nivel2_destinoController extends Controller
{
    //
    public function ListarDestino2(Request $request)
    {
        # code....
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '' ) {
            $destino2 = DB::table('nivel2_destinos')
            ->join('nivel1_destinos', 'nivel2_destinos.d1_cod', '=', 'nivel1_destinos.id')
            ->select('nivel1_destinos.id AS id1', 
                    'nivel1_destinos.descripcion',
                    'nivel2_destinos.id AS id2', 
                    'nivel2_destinos.d1_cod', 
                    'nivel2_destinos.descripcion AS descripcion2', 
                    'nivel2_destinos.prioridad',
                    'nivel2_destinos.observacion',
                    'nivel2_destinos.estado',
                    'nivel2_destinos.ogd')
            ->orderBy('nivel1_destinos.id','asc')
            ->orderBy('prioridad','asc')
            ->orderBy('descripcion2','asc')
            ->paginate(10);

        }
        else{
            $destino2 = DB::table('nivel2_destinos')
            ->join('nivel1_destinos', 'nivel2_destinos.d1_cod', '=', 'nivel1_destinos.id')
            ->select('nivel1_destinos.id AS id1', 
                    'nivel1_destinos.descripcion',
                    'nivel2_destinos.id AS id2', 
                    'nivel2_destinos.d1_cod', 
                    'nivel2_destinos.descripcion AS descripcion2', 
                    'nivel2_destinos.prioridad',
                    'nivel2_destinos.observacion',
                    'nivel2_destinos.estado',
                    'nivel2_destinos.ogd')
            ->where($criterio,'like','%'.$buscar.'%')
            ->orderBy('nivel1_destinos.id','asc')
            ->orderBy('prioridad','asc')
            ->orderBy('descripcion2','asc')
            ->paginate(10);
        }
        
        //return response()->json($destino2);
        return [
            'pagination' => [
                'total'         => $destino2->total(),
                'current_page'  => $destino2->currentPage(),
                'per_page'      => $destino2->perPage(),
                'last_page'     => $destino2->lastPage(),
                'from'          => $destino2->firstItem(),
                'to'            => $destino2->lastItem(),
            
            ],
            'destino2' => $destino2
        ];
    }

    public function RegistrarDestino2(Request $request) //CUATRO
    {
        $destino2 = Nivel2Destino::create([
            'd1_cod' => $request->iddestino1,
            'descripcion' => $request->des,
            'prioridad' => $request->pri, 
            'observacion' => $request->obs,
            'estado' => '1',
            'ogd' => $request->ogd,
            'sysuser' => Auth::user()->id
        ]);
         //return response()->json($request); //Con esto podemos ver que estamos recibiendo
        return response()->json($destino2); //Con esto podemos ver los datos que nos devuelve personal
    }

    public function EditarDestino2(Request $request)//CUATRO_4
    {
        $destinos2 = Nivel2Destino::Where('id',$request->id)->first(); //con esta linea llamamos al per que es el per_Codigo de la persona
        $destinos2->update([
            'd1_cod' =>$request->destn1,
            'descripcion' => $request->des,
            'prioridad' => $request->pri, 
            'observacion' => $request->obs,
            'estado' => '1',
            'ogd' => $request->ogd,
            'sysuser' => Auth::user()->id
        ]);
        
        return response()->json($destinos2); 
    }

    public function DesactivarDestino2(Request $request)//CUATRO_4
    {
        
        $destinos2 = Nivel2Destino::Where('id',$request->id)->first();//con esta linea llamamos al per que es el per_Codigo de la persona
        
        $destinos2->update([
            'estado' => '0', 
        ]);

        return response()->json($request); 
    }

    public function ActivarDestino2(Request $request)//CUATRO_4
    {
        $destinos2 = Nivel2Destino::Where('id',$request->id)->first(); //con esta linea llamamos al per que es el per_Codigo de la persona
        $destinos2->update([
            'estado' => '1', 
        ]);
        return response()->json($destinos2); 
    }

    public function selectDestinosNivel2(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $destinos2 = DB::table('nivel2_destinos')
        ->where('estado','=','1') //filtramos a todas las categorias que estan activas
        ->select('id','descripcion')
        ->orderBy('descripcion','asc')->get();//seleecionamos los campos id, nombre  con get() se obtiene el listado

        return ['destinos2' => $destinos2]; //mandamos todo el listado en la variable listado
    }

    public function selectbuscarDestinosNivel2(Request $request){
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $destinos2 = DB::table('nivel2_destinos')
        ->where('d1_cod','=',$buscar)
        ->where('estado','=','1')
        ->select('id','descripcion')
        ->orderBy('descripcion', 'asc')->get();
        return ['destinos2' => $destinos2];
    }

    // public function GenerarPdfDestinos2(Request $request)
    // {
    //     $destinos2 = DB::table('nivel2_destinos')
    //     ->join('nivel1_destinos', 'nivel2_destinos.d1codigo', '=', 'nivel1_destinos.id')
    //     ->orderBy('nivel1_destinos.descripcion','asc')
    //     ->get();

    //     $cont = Nivel2Destino::count();

    //     $pdf = PDF::loadView('reportes.listardestino2', compact('destinos2', 'cont'))
    //     ->setPaper('DEFAULT_PDF_PAPER_SIZE', 'portrait')
    //     ->setWarnings(false);
        
    //     return $pdf->download(date('Ymd-H-i-s').'Destinos2'.'.pdf');
    // }
}
