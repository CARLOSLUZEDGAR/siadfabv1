<?php

namespace App\Http\Controllers;

use App\Cargo;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CargoController extends Controller
{
    //
    public function ListarCargo(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '' ) {
            $cargo = DB::table('cargos')
            ->orderBy('descripcion','asc')
            ->paginate(10);
        }
        else{
            $cargo = DB::table('cargos')
            ->where($criterio,'like','%'.$buscar.'%')
            ->orderBy('descripcion','asc')
            ->paginate(10);
        }

        // return response()->json($destinos1);
        return [
            'pagination' => [
                'total'         => $cargo->total(),
                'current_page'  => $cargo->currentPage(),
                'per_page'      => $cargo->perPage(),
                'last_page'     => $cargo->lastPage(),
                'from'          => $cargo->firstItem(),
                'to'            => $cargo->lastItem(),
            
            ],
            'cargo' => $cargo
        ];
    }

    public function RegistrarCargo(Request $request) //CUATRO
    {
        $cargo = DB::table('cargos')->create([
            'descripcion' => $request->descripcion,
            'puntaje' => $request->puntaje, 
            'asignacion' => $request->asignacion, 
            'area' => $request->area, 
            'estado' => '1', 
            'sysuser' => Auth::user()->id, 
            'observaciones' => $request->observaciones, 
        ]);
         //return response()->json($request); //Con esto podemos ver que estamos recibiendo
        return response()->json($cargo); //Con esto podemos ver los datos que nos devuelve personal
    }

    public function EditarCargo(Request $request)//CUATRO_4
    {
        $cargo = DB::table('cargos')->Where('id',$request->id)->first(); //con esta linea llamamos al per que es el per_Codigo de la persona
        $cargo->update([
            'descripcion' => $request->descripcion,
            'puntaje' => $request->puntaje, 
            'asignacion' => $request->asignacion, 
            'area' => $request->area, 
            'estado' => '1', 
            'sysuser' => 'ADMIN', 
            'observaciones' => $request->observaciones,  
        ]);
        return response()->json($cargo); 
    }

    public function DesactivarCargo(Request $request)//CUATRO_4
    {
        $cargo = DB::table('cargos')->Where('id',$request->id)->first(); //con esta linea llamamos al per que es el per_Codigo de la persona
        $cargo->update([
            'estado' => '0', 
        ]);
        return response()->json($cargo); 
    }

    public function ActivarCargo(Request $request)//CUATRO_4
    {
        $cargo = DB::table('cargos')->Where('id',$request->id)->first(); //con esta linea llamamos al per que es el per_Codigo de la persona
        $cargo->update([
            'estado' => '1', 
        ]);
        return response()->json($cargo); 
    }


    // public function GenerarPdfCargo(Request $request)
    // {
    //     $cargo = DB::table('cargo')
    //     ->orderBy('descripcion','asc')
    //     ->get();

    //     $cont = Cargo::count();

    //     $pdf = PDF::loadView('reportes.listarcargo', compact('cargo', 'cont'))
    //     ->setPaper('DEFAULT_PDF_PAPER_SIZE', 'portrait')
    //     ->setWarnings(false);
        
    //     return $pdf->download(date('Ymd-H-i-s').'cargo'.'.pdf');
    // }

    public function ListarCargos(Request $request)
    {
        $filtro = $request->filtro;

        if ($filtro==1 || $filtro==2 || $filtro==3)
            {
                $cargos = DB::table('cargos')
                ->select('id','descripcion')
                ->where('asignacion','like', '%' . 'O'.  '%')
                ->where('estado',1)
                ->orderBy('descripcion','asc')
                ->get();
                return response()->json($cargos);
            }
            else if ($filtro==4 || $filtro==5 || $filtro==6)
            {
                $cargos = DB::table('cargos')
                ->select('id','descripcion')
                ->where('asignacion','like', '%' . 'S' .  '%')
                ->where('estado',1)
                ->orderBy('descripcion','asc')
                ->get();
                return response()->json($cargos);
            }
            else if ($filtro==21)
            {
                $cargos = DB::table('cargos')
                ->select('id','descripcion')
                ->where('asignacion','like', '%' . 'M' .  '%')
                ->where('estado',1)
                ->orderBy('descripcion','asc')
                ->get();
                return response()->json($cargos);
            }
            else if ($filtro==7 || $filtro==8 || $filtro==9 || $filtro==10 || $filtro==11 || $filtro==12)
            {
                $cargos = DB::table('cargos')
                ->select('id','descripcion')
                ->where('asignacion','like', '%' . 'C'.  '%')
                ->where('estado',1)
                ->orderBy('descripcion','asc')
                ->get();
                return response()->json($cargos);
            }

        else{

        }
    }
}
