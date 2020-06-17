<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class RecipeApiController extends Controller
{
    //
    public $successStatus = 200;

    public function details(Request $request) 
    {         
        return response()->json(['success' => "auth success","request"=>$request->all()], $this->successStatus); 
    }
    
    public function insert(){
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus); 
    }
}
