<?php



namespace App\Actions\Fortify;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class AuthUser {

    public function auth($request)
    {
        $username = $request->post(Config('fortify.username'));
        $password = $request->post('password');

        $user = Admin::where('username', $username)
            ->orwhere('email', $username)
            ->orwhere('phone_number', $username)
            ->first();

        if($user && hash::check($password, $user->password)) {
            return $user;
        }
        return false;
    }
}

