<?php

namespace App\Http\Controllers\front\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthenticationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('front.auth.two-factor',compact('user'));
    }
}
