<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getUser($id){
        return response()->json([
            'data' => User::find($id)
        ]);
    }

    public function getalluser(){
        return response()->json([
            'status' => true,
            'data' => User::all()
        ]);
    }
}
