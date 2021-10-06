<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller 
{

public function login(Request $request){ 
    //User check
    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
      $user = Auth::user(); 
    //Setting login response

    $success['token'] =mt_rand(1000000000, 9999999999);
    $success['name'] =  $user->name;
      return response()->json([
        'status' => 'success',
        'data' => $success
      ]); 
    } else { 
      return response()->json([
        'status' => 'error',
        'data' => 'Unauthorized Access'
      ]); 
    } 
  }

public function loginauth(Request $request){ 
    //User check

$this->validate($request , [
'email'=>'required|max:255',
'password'=>'required'
]);

$login = $request->only('email', 'password');

    if(!Auth::attempt($login)){ 
    return response(['message'=>'Invalid login credential!!', 'statusCode'=>'0'] , 401);
   } 
   /**
    * *
   @var User $user
   */
    $user = Auth::user();
    $token =  mt_rand(1000000000, 9999999999);

    return response([
      'id'=>$user->id,
      'name'=>$user->name,
      'email'=>$user->email,
      'created_at'=>$user->created_at,
      'updated_at'=>$user->updated_at,
      'token'=>$token,
    ],200);
  }
}
