<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function redirect()
    {
        $response['status'] = 1;
        try {
            $googleAuthScopes = [
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile',
            ];

            $response ['msg'] = Socialite::driver('google')->scopes($googleAuthScopes)->redirect()->getTargetUrl();

        }catch (\Exception $e) {
            $response['msg'] = $e->getMessage();
            $response['status'] = 0;
        }

        return response()->json($response);
    }

    public function createUser()
    {
        $response['status'] = 1;

        try {
            $auth_user = Socialite::driver('google')->stateless()->user();

            $existUser = User::where('email', $auth_user->email)->first();

            if (!isset($existUser)) {
                $user = new User();
                $user->google_id = $auth_user->id;
                $user->name = $auth_user->name;
                $user->email = $auth_user->email;
                $user->save();

                $response['msg'] = "Usuario creado";
                $response['user'] = $user;
                $response['status'] = 1;
            } else {
                $response['msg'] = "Usuario ya existe";
                $response['status'] = 0;
            }
        }catch (\Exception $e) {
            $response['msg'] = $e->getMessage();
            $response['status'] = 0;
        }

        return response()->json($response);
    }
}
