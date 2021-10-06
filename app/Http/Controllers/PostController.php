<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Encryption\DecryptException;
class PostController extends Controller
{



  public function index(){
  // $users = User::where('id', 10)->first();
    return view('auth.new_register');

  }
  public function save(Request $request){
        
    if ($request['password'] == $request['name="password_confirmation"']) {



     DB::table('users')->insert([
      ['name' => $request['name'], 'email' => $request['email'] ,  'password' => $request['password'] ,  "remember_token" =>$request['_token']  ],

    ]);
   }else{
    echo "password does not match";

  }
  return view('auth.new_register');
}

public function create()
{
  return view('auth.login');
}

public function checklogin(Request $request_login)
{

  $this->validate($request_login, [
    'email'       => 'required|email',
    'password'    => 'required'
  ]);

  $user_data = array(
    'email'       => $request_login->get('email'),
    'password'    => $request_login->get('password')
  );


  // dd($user_data);
  if(Auth::attempt($user_data))
  {
    $authUser = Auth::user();
    if($authUser->user_type == 'superadmins') {
      return redirect()->to('/dashboard');
    } else {
      Auth::logout();
    }
  }
  return back()->with('error', 'Wrong Login Details');

}

public function show(Request $request,$id)
{
  $user = User::find($id); 
  $data['user'] = $user;

  return view('Testing_users',$data);
             // $user = User::where('id', 10)->update($data);
}

public function user()
{ 
  $data['users'] = User::all();
// $date = date('Y-m-d');
// print_r($date);
    Cache::put('name', 'Testing Cache', $seconds = 60);
  return view('ShowUsers',$data);


}


public function UpdateUser(Request $request )
{

 $request->validate([
  'name' => 'required|string|max:255',
  'email' => 'required|string|email|max:255|unique:users,email,'.$request->id,
  'password' => ['required', 'confirmed', Rules\Password::defaults()],
]);

 $data =['name' =>$request->name ,'email' =>$request->email, 'password' => Hash::make($request->password)];
 $user = User::where('id', $request->id)->update($data);     
 return redirect(RouteServiceProvider::HOME);
// ->with('success','Product deleted successfully')

}
public function Delete(Request $request , $id)
{
 $user = User::where('id', $id)->delete();     
 return redirect(RouteServiceProvider::HOME);
}

public function CreateUser(Request $request)
{


  return view('CreateUser');


}
public function CreateNewUser(Request $request)
{
 $request->validate([
  'name' => 'required|string|max:255',
  'email' => 'required|string|email|max:255|unique:users',
  'password' => ['required', 'confirmed', Rules\Password::defaults()],
]);

 $user = User::create([
  'name' => $request->name,
  'email' => $request->email,
  'password' => Hash::make($request->password) ,
]);
 event(new Registered($user));
 return redirect(RouteServiceProvider::HOME);


}

}
