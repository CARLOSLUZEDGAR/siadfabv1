<?php

namespace App\Http\Controllers;

use App\Nivel1Destino;
use Barryvdh\DomPDF\PDF as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Nivel1_destinoController extends Controller
{
    //
    public function ListarDestino1(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '' ) {
            $destino1 = DB::table('nivel1_destinos')
            ->orderBy('id','asc')
            ->paginate(10);
        }
        else{
            $destino1 = DB::table('nivel1_destinos')
            ->where($criterio,'like','%'.$buscar.'%')
            ->orderBy('id','asc')
            ->paginate(10);
        }
        return [
            'pagination' => [
                'total'         => $destino1->total(),
                'current_page'  => $destino1->currentPage(),
                'per_page'      => $destino1->perPage(),
                'last_page'     => $destino1->lastPage(),
                'from'          => $destino1->firstItem(),
                'to'            => $destino1->lastItem(),
            
            ],
            'destino1' => $destino1
        ];
    }

    public function RegistrarDestino1(Request $request)
    {
        $destino1 = Nivel1Destino::create([
            'descripcion' => $request->des,
            'observacion' => $request->obs, 
            'estado' => '1', 
            'sysuser' => Auth::user()->id, 
        ]);
        return response()->json($destino1);
    }

    public function EditarDestino1(Request $request)
    {
        $destino1 = Nivel1Destino::Where('id',$request->id)->first();
        $destino1->update([
            'descripcion' => $request->des,
            'observacion' => $request->obs, 
            'estado' => '1', 
            'sysuser' => Auth::user()->id,
        ]);
        return response()->json($destino1); 
    }

    public function DesactivarDestino1(Request $request)
    {
        $destino1 = Nivel1Destino::Where('id',$request->id)->first(); 
        $destino1->update([
            'estado' => '0', 
        ]);
        return response()->json($destino1); 
    }

    public function ActivarDestino1(Request $request)
    {
        $destino1 = Nivel1Destino::Where('id',$request->id)->first();
        $destino1->update([
            'estado' => '1', 
        ]);
        return response()->json($destino1); 
    }

    public function SelectNivel1Destino(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $destino1 = DB::connection('pgsql_server')->table('nivel1_destinos')
        ->where('estado','=','1') //filtramos a todas las categorias que estan activas
        ->select('id','descripcion')
        ->orderBy('descripcion','asc')->get();//seleecionamos los campos id, nombre  con get() se obtiene el listado

        return ['destino1' => $destino1]; //mandamos todo el listado en la variable listado
    }

    // public function GenerarPdfNivel1Destino(Request $request)
    // {
    //     $destino1 = DB::table('nivel1_destinos')
    //     ->orderBy('descripcion','asc')
    //     ->get();

    //     $cont = Nivel1Destino::count();

    //     $pdf = PDF::loadView('reportes.listardestino1', compact('destino1', 'cont'))
    //     ->setPaper('DEFAULT_PDF_PAPER_SIZE', 'portrait')
    //     ->setWarnings(false);
        
    //     return $pdf->download(date('Ymd-H-i-s').'Destino1'.'.pdf');
    // }
}
