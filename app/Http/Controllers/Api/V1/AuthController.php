<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));

        $user->save();

        return response()->json(status: Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::query()->where('email', $request->get('email'))->first();

        if ($user === null || !Hash::check($request->get('password'), $user->password)) {
            return response()->json([
                'data' => [
                    'message' => 'Login credentials are incorrect!',
                ],
            ], 400);
        }

        $token = $user->createToken($request->get('device_name'));

        return response()->json([
            'data' => [
                'access_token' => $token->plainTextToken,
            ],
        ]);
    }
}
