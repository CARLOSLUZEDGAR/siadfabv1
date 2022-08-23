<?php

namespace App\Http\Controllers;

use App\Modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermisoController extends Controller
{
    public function ListarPermisos(Request $request)
    {
        if ($request->buscar == '') {
            $permisos = DB::table('permissions as p')
                ->join('modulos as m', 'p.mod_cod','m.id')
                ->select('p.*','m.nombre as modnom')
                ->orderBy('m.nombre')
                ->paginate(10);
        } else {
            $permisos = DB::table('permissions as p')
                ->join('modulos as m', 'p.mod_cod','m.id')
                ->select('p.*','m.nombre as modnom')
                ->where($request->criterio,'LIKE','%'.$request->buscar.'%')
                ->orderBy('m.nombre')
                ->paginate(10);
        }
        
        

        return response()->json([
            'pagination' => [
                'total'         => $permisos->total(),
                'current_page'  => $permisos->currentPage(),
                'per_page'      => $permisos->perPage(),
                'last_page'     => $permisos->lastPage(),
                'from'          => $permisos->firstItem(),
                'to'            => $permisos->lastItem(),
            
            ],
            'permisos' => $permisos
        ]); 
    }

    public function GuardarPermisos(Request $request)
    {
        Permission::create([
            'mod_cod' => $request->modulo,
            'name' => $request->nombre,
            'guard_name' => 'web',
            'detalle' => $request->detalle
        ]);

        return response()->json($request);
    }

    public function DatosPermiso(Request $request)
    {
        $datos = DB::table('permissions as p')
            ->join('modulos as m','p.mod_cod','m.id')
            ->select('p.*','m.id as idmod','m.nombre as modnom')
            ->where('p.id',$request->id)
            ->first();

        return response()->json($datos);
    }

    public function EditarPermisos(Request $request)
    {
        $editar = Permission::where('id',$request->id)
                    ->update([
                        'mod_cod' => $request->modulo,
                        'name' => $request->nombre,
                        'detalle' => $request->detalle
                    ]);

        return response()->json($editar);
    }

    public function ListarModulos()
    {
        $modulos = Modulo::all();

        return response()->json($modulos);
    }
}
