<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uploadimage(Request $request)
    {

        if (!$request->hasFile('image')) {

            return;
        }
        $file = $request->file('image');
        $path = $file->store('uploads', 'public');
        $data['image'] = $path;
        return $path;
    }
}