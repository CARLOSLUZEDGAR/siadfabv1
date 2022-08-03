<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {   
        $email = $request->email;
        $password = $request->password;
        $respuesta = Auth::attempt(['email' => $email, 'password' => $password, 'estado'=>1]);
        if ($respuesta) {
            // User::where('id',Auth::user()->id)
            //     ->update([
            //         'session' => 0
            //     ]);
            Auth::logoutOtherDevices($password);
            return response()->json([
                'authUser' => Auth::user(),
                'code' => 200
            ]);            
        } else {
            // $session = User::where('email',$email)->select('session')->first();
            // if ($session->session == 0) {
            //     return response()->json([
            //         'code' => 400
            //     ]);
            // } else {
                return response()->json([
                    'code' => 401
                ]);
            // }
            
            
        }
    }

    public function logout(Request $request)
    {   
        // User::where('id',Auth::user()->id)
        //     ->update([
        //         'session' => 1
        //     ]);
        Auth::logout();
        return redirect("/");
    }
    public function VistaLogin(Request $request)
    {   
        return redirect("/");
    }

    public function ver()
    {
        return response()->json([
            'authUser' => Auth::user()->per_codigo,
            'code' => 200
        ]);
    }
}
