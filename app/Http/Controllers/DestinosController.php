<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestinosController extends Controller
{
    public function Destinos1()
    {
        $dest1 = DB::table('nivel1_destinos')
            ->select('id','descripcion')
            ->where('estado',1)
            ->orderBy('descripcion')
            ->get();
        
        return response()->json($dest1);
    }

    public function Destinos2(Request $request)
    {
        $dest1 = $request->dest1;
        $dest2 = DB::table('nivel2_destinos')
            ->select('id','descripcion')
            ->where('d1_cod',$dest1)
            ->where('estado',1)
            ->orderBy('descripcion')
            ->get();
        
        return response()->json($dest2);
    }
    
    public function Destinos3(Request $request)
    {
        $dest2 = $request->dest2;
        $dest3 = DB::table('nivel3_destinos')
            ->select('id','descripcion')
            ->where('d2_cod',$dest2)
            ->where('estado',1)
            ->orderBy('descripcion')
            ->get();
        
        return response()->json($dest3);
    }
    
    public function Destinos4(Request $request)
    {
        $dest3 = $request->dest3;
        $dest4 = DB::table('nivel4_destinos')
            ->select('id','descripcion')
            ->where('d3_cod',$dest3)
            ->where('estado',1)
            ->orderBy('descripcion')
            ->get();
        
        return response()->json($dest4);
    }
}
