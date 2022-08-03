<?php

namespace App\Http\Controllers;

use App\User;
use Hamcrest\Core\IsNull;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function ListarRole(Request $request)
    {
        if ($request->buscar == '') {
            $roles = Role::orderBy('name')
            ->paginate(10);
        } else {
            $roles = Role::where('name','LIKE','%'.$request->buscar.'%')
                        ->orderBy('name')
                        ->paginate(10);
        }
        
        

        return response()->json([
            'pagination' => [
                'total'         => $roles->total(),
                'current_page'  => $roles->currentPage(),
                'per_page'      => $roles->perPage(),
                'last_page'     => $roles->lastPage(),
                'from'          => $roles->firstItem(),
                'to'            => $roles->lastItem(),
            
            ],
            'roles' => $roles
        ]); 
    }

    public function ListarRole2(Request $request)
    {
        $roles = DB::table('model_has_roles as rm')
            ->join('roles as r','rm.role_id', 'r.id')
            ->select('r.id')
            ->where('rm.model_id', $request->per_cod)
            ->get();
        $data = [];

        foreach ($roles as $key => $value) {
            $data[$key] = $value->id; 
        }

        $roles = Role::select('name','id')
                        ->whereNotIn('id', $data)
                        ->orderBy('name')
                        ->get();

        
        return response()->json($roles);
    }

    public function ListarRoleUsuario(Request $request)
    {
        $roles = DB::table('model_has_roles as rm')
        ->join('roles as r','rm.role_id', 'r.id')
        ->select('r.id','r.name')
        ->where('rm.model_id', $request->per_cod)
        ->get();

        return response()->json($roles);
    }

    public function ListarPermisos()
    {
        $permisos = DB::table('permissions as p')
        ->join('modulos as m', 'p.mod_cod','m.id')
        ->select('p.id','p.name','p.detalle','m.nombre as modulo')
        ->get();

        return response()->json($permisos);
    }

    public function ListaRolPermiso(Request $request)
    {
        $id = $request->id;
        $rol = Role::find($id);
        $datos = DB::table('role_has_permissions as rp')
        ->select('p.name', 'p.id as idper','rp.role_id', 'p.detalle','m.nombre as modulo'
         ,DB::raw("CASE  WHEN COALESCE(rp.role_id,0) = 0 THEN 0 ELSE 1 END AS checked")
        )
        ->rightJoin('permissions as p', function($join) use ($id){
            $join->on('p.id','=','rp.permission_id')
                ->where('rp.role_id',$id);
        })
        ->join('modulos as m', 'p.mod_cod','m.id')
        ->get();

        return response()->json([
            'rol'=> $rol,
            'permisos' => $datos
        ]);    
    }

    public function GuardarRol(Request $request)
    {
        $rol = Role::create(['name' => $request->nombre, 'detalle'=>$request->descripcion]);
        $data = [];
        $permisos = $request->listarpermisos;
        foreach ($permisos as $key => $value) {
            if ($value['checked']) {
                // $data[$key] = $value['name'];
                array_push($data,$value['name']);
            }
        }
        $rol->syncPermissions($data);

        return response()->json($data);
    }

    public function EditarRol(Request $request)
    {
         Role::where('id',$request->id)
        ->update(['name' => $request->nombre, 'detalle' => $request->descripcion]);

        $rol = Role::find($request->id);
        DB::table('role_has_permissions')
            ->where('role_id',$request->id)
            ->delete();
        
        $data = [];
        $permisos = $request->listarpermisos;
        foreach ($permisos as $key => $value) {
            if ($value['checked']) {
                // $data[$key] = $value['name'];
                array_push($data,$value['name']);
            }
        }
        $rol->syncPermissions($data);

        return response()->json($data);
    }
    
    public function ListarRoles()
    {
        $role = Role::all();

        return response()->json($role);
    }

    public function AgregarRol(Request $request)
    {
        $user = User::find($request->id);
        $user->assignRole($request->rol);
        return response()->json($request);
;    }

    public function QuitarRol(Request $request)
    {
        $user = User::find($request->id);
        $user->removeRole($request->rol);
        return response()->json($request);
        # code...
    }
}
