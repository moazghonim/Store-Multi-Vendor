<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required',
            'device_name' => 'string',
            'abilities'   => 'nullable|array',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && hash::check($request->password, $user->password)) {

            $device_name = $request->post('device_name', $request->userAgent());
            $token = $user->createToken($device_name, $request->post('abilities'));

            return Response::json([
                'code'  => 1,
                'token' => $token->plainTextToken,
                'user'  => $user,
            ]);
        }

        return Response::json([
            'code' => 0,
            'message' => 'invalid credentials',
        ]);
    }



    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();
        // delete all tokens
        $user->tokens()->delete();

        if (null === $token) {
            $user->currentAccessToken()->delete();
            return;
        }

        $personalAccessToken = PersonalAccessToken::findToken($token);
        if (
            $user->id == $personalAccessToken->tokenable_id
            && get_class($user) == $personalAccessToken->tokenable_type
        ) {

            $personalAccessToken->delete();
        }

    }
}
