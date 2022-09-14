<?php

namespace App\Http\Controllers;

use App\Mail\AccesoUsuarios;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;

class UsuarioController extends Controller
{
    public function DatosUsuario()
    {
        $usuario = DB::table('users as u')
            ->join('personals as p','u.percod','p.per_codigo')
            ->join('personal_escalafones as pe','u.percod','pe.per_codigo')
            ->join('grados as g','pe.gra_cod','g.id')
            ->join('personal_estudios as epe','u.percod','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->join('personal_situaciones as ps','p.per_codigo','ps.per_codigo')
            ->join('subsituaciones as ss','ps.subsit_cod','ss.id')
            ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
            ->join('nivel3_destinos as nd3','pd.d3_cod','nd3.id')
            ->join('nivel2_destinos as nd2','pd.d2_cod','nd2.id')
            ->select('u.id','u.nick','u.estado','u.email','p.per_nombre as nombre','p.per_paterno as paterno',
                    'p.per_materno as materno','p.per_cm as cm','p.per_foto as foto',
                    'g.abreviatura as grado','e.abreviatura as complemento',
                    'p.per_cm as cm','p.per_ci as ci','p.per_expedido as expedido',
                    'ss.nombre as situacion','nd2.descripcion as des2','nd3.descripcion as des3')
            ->where('pe.estado',1)
            ->where('epe.estado',1)
            ->where('pd.estado',1)
            ->where('ps.estado',1)
            ->where('u.id',Auth::user()->id)
            ->first();
        
        return response()->json($usuario);
    }

    public function CrearUsuario(Request $request)
    {
        // Generador de Contraseña aleatoria
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i=0; $i < 10; $i++) {
            $randomString .= $characters[rand(0,$charactersLength - 1)];
        }
        // $randomString = 1;
        
        $verificacion = User::where('email',$request->email)->exists();
        
        if ($verificacion) {
            return response()->json(['code' => $verificacion, 'mensaje' => 'El correo ya fue registrado revise sus datos.','tipo'=>'error', 'titulo'=>'Error']);
        } else {
            try {
                DB::beginTransaction();
                $user = User::create([
                    'percod' => $request->percodigo,
                    'nick' => $request->nick,
                    'email' => $request->email,
                    'password' => Hash::make($randomString),
                    'seccion' => 4
                ]);

                $user->assignRole($request->rol);
                DB::commit();

                Mail::to($request->email)
                ->send(new AccesoUsuarios($request, $randomString));
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['code' => $verificacion, 'mensaje' => 'Ocurrio un error al momento de registra al usuario.','tipo' => 'error', 'titulo'=>'Error']);
            }
            return response()->json(['code' => $verificacion, 'mensaje' => 'Usuario creado correctamente.','tipo' => 'success', 'titulo'=>'Aceptado']);
        }
        // return response()->json($request);
    }
    public function ListarUsuarios(Request $request)
    {
        // $conexion_server = DB::connection('pgsql_server');
        // $conexion_local = DB::connection('pgsql');

        // $buscar = $request->buscar;
        // if ($buscar == '') {
        //     // $users_percod = DB::connection('pgsql')->table('users')
        //     //                 ->select('percod')
        //     //                 ->where('estado',1)
        //     //                 ->get();

        //     // $arrayPerCodigo = json_decode($users_percod,true);

        //     // $users_local = DB::connection('pgsql')->table('users as u')
        //     //                 ->join('model_has_roles as mr', 'u.id','mr.model_id')
        //     //                 ->join('roles as r','mr.role_id','r.id')
        //     //                 ->select('u.id','u.percod','u.nick','u.estado','r.name as role')
        //     //                 ->where('u.estado',1)
        //     //                 ->orderBy('u.percod')
        //     //                 ->paginate(10); 
            

        //     // $users_personal = DB::connection('pgsql_server')->table('personals as p')
        //     //         ->join('personal_escalafones as pe','p.per_codigo','pe.per_codigo')
        //     //         ->join('grados as g','pe.gra_cod','g.id')
        //     //         ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
        //     //         ->join('estudios as e','epe.est_cod','e.id')
        //     //         // ->join('model_has_roles as mr', 'u.id','mr.model_id')
        //     //         // ->join('roles as r','mr.role_id','r.id')
        //     //         ->select('p.per_nombre as nombre',
        //     //                 'p.per_paterno as paterno','p.per_materno as materno',
        //     //                 'p.per_cm as cm','g.abreviatura as grado',
        //     //                 'e.abreviatura as complemento',
        //     //                 // 'r.name as role'
        //     //                 )
        //     //         ->whereIn('p.per_codigo',$arrayPerCodigo)
        //     //         ->where('pe.estado',1)
        //     //         ->where('epe.estado',1)
        //     //         ->orderBy('p.per_codigo')
        //     //         ->paginate(10); 

        //     // $union = DB::connection('pgsql_server')->table('personals as p')
        //     //         ->join('personal_escalafones as pe','p.per_codigo','pe.per_codigo')
        //     //         ->join('grados as g','pe.gra_cod','g.id')
        //     //         ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
        //     //         ->join('estudios as e','epe.est_cod','e.id')
        //     //         // ->join('model_has_roles as mr', 'u.id','mr.model_id')
        //     //         // ->join('roles as r','mr.role_id','r.id')
        //     //         ->select('p.per_nombre as nombre',
        //     //                 'p.per_paterno as paterno','p.per_materno as materno',
        //     //                 'p.per_cm as cm','g.abreviatura as grado',
        //     //                 'e.abreviatura as complemento',
        //     //                 // 'r.name as role'
        //     //                 )
        //     //         ->whereIn('p.per_codigo',$arrayPerCodigo)
        //     //         ->where('pe.estado',1)
        //     //         ->where('epe.estado',1)
        //     //         ->orderBy('p.per_codigo')
        //     //         ->union($users_local)
        //     //         ->get();
        //             // ->paginate(10); 

        //     // $arrayUserLocal = json_decode($user_local,true);
        //     // $usuarios = DB::connection('pgsql_server')->table('personals as p')
        //     //         ->join('personal_escalafones as pe','u.percod','pe.per_codigo')
        //     //         ->join('grados as g','pe.gra_cod','g.id')
        //     //         ->join('personal_estudios as epe','u.percod','epe.per_codigo')
        //     //         ->join('estudios as e','epe.est_cod','e.id')
        //     //         ->join('model_has_roles as mr', 'u.id','mr.model_id')
        //     //         ->join('roles as r','mr.role_id','r.id')
        //     //         ->select('u.id','u.nick','u.estado','p.per_nombre as nombre',
        //     //                 'p.per_paterno as paterno','p.per_materno as materno',
        //     //                 'p.per_cm as cm','g.abreviatura as grado',
        //     //                 'e.abreviatura as complemento',
        //     //                 'r.name as role'
        //     //                 )
        //     //         ->where('pe.estado',1)
        //     //         ->where('epe.estado',1)
        //     //         ->orderBy('u.id','desc')
        //     //         ->paginate(10);
            
        //     $usuarios = DB::connection('pgsql')->table('users as u')
        //     ->join($conexion_server.'personals as p','u.percod','p.per_codigo')
        //     ->join($conexion_server.'personal_escalafones as pe','u.percod','pe.per_codigo')
        //     ->join($conexion_server.'grados as g','pe.gra_cod','g.id')
        //     ->join($conexion_server.'personal_estudios as epe','u.percod','epe.per_codigo')
        //     ->join($conexion_server.'estudios as e','epe.est_cod','e.id')
        //     ->join($conexion_local.'model_has_roles as mr', 'u.id','mr.model_id')
        //     ->join($conexion_local.'roles as r','mr.role_id','r.id')
        //     ->select('u.id','u.nick','u.estado','p.per_nombre as nombre',
        //             'p.per_paterno as paterno','p.per_materno as materno',
        //             'p.per_cm as cm','g.abreviatura as grado',
        //             'e.abreviatura as complemento',
        //             'r.name as role'
        //             )
        //     ->where($conexion_server.'pe.estado',1)
        //     ->where($conexion_server.'epe.estado',1)
        //     ->orderBy($conexion_local.'u.id','desc')
        //     ->paginate(10);
        // } else {
        //     $usuarios = DB::table('users as u')
        //     ->join('personals as p','u.percod','p.per_codigo')
        //     ->join('personal_escalafones as pe','u.percod','pe.per_codigo')
        //     ->join('grados as g','pe.gra_cod','g.id')
        //     ->join('personal_estudios as epe','u.percod','epe.per_codigo')
        //     ->join('estudios as e','epe.est_cod','e.id')
        //     ->join('model_has_roles as mr', 'u.id','mr.model_id')
        //     ->join('roles as r','mr.role_id','r.id')
        //     ->select('u.id','u.nick','u.estado','p.per_nombre as nombre','p.per_paterno as paterno',
        //             'p.per_materno as materno','p.per_cm as cm','g.abreviatura as grado','e.abreviatura as complemento',
        //             'r.name as role'
        //             )
        //     ->where(function($q) use ($buscar){
        //         $q->where('p.per_paterno','LIKE','%'.$buscar.'%')
        //         ->orWhere('p.per_cm','LIKE','%'.$buscar.'%')
        //         ->orWhere('p.per_nombre','LIKE','%'.$buscar.'%')
        //         ->orWhere('p.per_materno','LIKE','%'.$buscar.'%');
        //     })
        //     ->where('pe.estado',1)
        //     ->where('epe.estado',1)
        //     ->orderBy('u.id','desc')
        //     ->paginate(10);
            
        // }
        
        // return response()->json([
        //     'pagination' => [
        //         'total'         => $usuarios->total(),
        //         'current_page'  => $usuarios->currentPage(),
        //         'per_page'      => $usuarios->perPage(),
        //         'last_page'     => $usuarios->lastPage(),
        //         'from'          => $usuarios->firstItem(),
        //         'to'            => $usuarios->lastItem(),
            
        //     ],
        //     // 'users_local'=>$users_local,'users_personal' => $users_personal
        //     // 'union'=>$union
        //     'usuarios' => $usuarios

        // ]);       
        // return response()->json(['usuarios'=>$user_local]);

        //ORIGIN

        $buscar = $request->buscar;
        if ($buscar == '') {
            $usuarios = DB::table('users as u')
            ->join('personals as p','u.percod','p.per_codigo')
            ->join('personal_escalafones as pe','u.percod','pe.per_codigo')
            ->join('grados as g','pe.gra_cod','g.id')
            ->join('personal_estudios as epe','u.percod','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->join('model_has_roles as mr', 'u.id','mr.model_id')
            ->join('roles as r','mr.role_id','r.id')
            ->select('u.id','u.nick','u.estado','p.per_nombre as nombre',
                    'p.per_paterno as paterno','p.per_materno as materno',
                    'p.per_cm as cm','g.abreviatura as grado',
                    'e.abreviatura as complemento',
                    'r.name as role'
                    )
            ->where('pe.estado',1)
            ->where('epe.estado',1)
            ->orderBy('u.id','desc')
            ->paginate(10);
        } else {
            $usuarios = DB::table('users as u')
            ->join('personals as p','u.percod','p.per_codigo')
            ->join('personal_escalafones as pe','u.percod','pe.per_codigo')
            ->join('grados as g','pe.gra_cod','g.id')
            ->join('personal_estudios as epe','u.percod','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->join('model_has_roles as mr', 'u.id','mr.model_id')
            ->join('roles as r','mr.role_id','r.id')
            ->select('u.id','u.nick','u.estado','p.per_nombre as nombre','p.per_paterno as paterno',
                    'p.per_materno as materno','p.per_cm as cm','g.abreviatura as grado','e.abreviatura as complemento',
                    'r.name as role'
                    )
            ->where(function($q) use ($buscar){
                $q->where('p.per_paterno','LIKE','%'.$buscar.'%')
                ->orWhere('p.per_cm','LIKE','%'.$buscar.'%')
                ->orWhere('p.per_nombre','LIKE','%'.$buscar.'%')
                ->orWhere('p.per_materno','LIKE','%'.$buscar.'%');
            })
            ->where('pe.estado',1)
            ->where('epe.estado',1)
            ->orderBy('u.id','desc')
            ->paginate(10);
            
        }
        
        return response()->json([
            'pagination' => [
                'total'         => $usuarios->total(),
                'current_page'  => $usuarios->currentPage(),
                'per_page'      => $usuarios->perPage(),
                'last_page'     => $usuarios->lastPage(),
                'from'          => $usuarios->firstItem(),
                'to'            => $usuarios->lastItem(),
            
            ],
            'usuarios' => $usuarios
        ]);       
    }

    public function DatosUsuarios(Request $request)
    {
        $id = $request->id;
        $usuarios = DB::table('users as u')
            ->join('personals as p','u.percod','p.per_codigo')
            ->join('personal_escalafones as pe','u.percod','pe.per_codigo')
            ->join('grados as g','pe.gra_cod','g.id')
            ->join('personal_estudios as epe','u.percod','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->join('personal_situaciones as ps','p.per_codigo','ps.per_codigo')
            ->join('subsituaciones as ss','ps.subsit_cod','ss.id')
            ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
            ->join('nivel3_destinos as nd3','pd.d3_cod','nd3.id')
            ->join('nivel2_destinos as nd2','pd.d2_cod','nd2.id')
            ->select('u.id','u.nick','u.estado','u.seccion','p.per_nombre as nombre','p.per_paterno as paterno',
                    'p.per_materno as materno','p.per_cm as cm','p.per_foto as foto',
                    'g.abreviatura as grado','e.abreviatura as complemento',
                    'p.per_cm as cm','p.per_ci as ci','p.per_expedido as expedido',
                    'ss.nombre as situacion','nd2.descripcion as des2','nd3.descripcion as des3')
            ->where('pe.estado',1)
            ->where('epe.estado',1)
            ->where('pd.estado',1)
            ->where('ps.estado',1)
            ->where('u.id',$id)
            ->first();
        $rol = DB::table('model_has_roles as mr')
            ->join('roles as r','mr.role_id','r.id')
            ->select('r.id','r.name')
            ->where('mr.model_id',$id)
            ->first();
        return response()->json(['usuarios'=>$usuarios,'role'=>$rol]);
    }

    public function EditarUsuario(Request $request)
    {
        $id = $request->id;
        DB::table('users')
            ->where('id',$id)
            ->update([
                'seccion' => $request->seccion
            ]);
        return response()->json($request);
    }

    public function ListarPermisos(Request $request)
    {
        $user = User::find($request->id);
        $roles = $user->getAllPermissions();
        return response()->json($roles);
    }

    public function EditContrasena(Request $request)
    {
        $u = DB::table('users')
            ->select('password')
            ->where('id',Auth::user()->id)
            ->first();
        if (Hash::check($request->contrasenaA, $u->password)) {
            DB::table('users')
                ->where('id',Auth::user()->id)
                ->update([
                    'password' => Hash::make($request->contrasena)
                ]);
            Auth::logout();
            $code = 200;
            return response()->json($code);
        } else {
            $code = 400;
            return response()->json($code);
        }
        
        
    }

    public function CambiarEstadoUsuario(Request $request)
    {
        $estado = 1 - $request->estado;
        $usuario = User::find($request->id);
        $usuario->estado = $estado;
        $usuario->save();

         return response()->json($estado);
    }
}
