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
class UsersController extends Controller
{

 
    public function users()
    {
        $users = User::get();

        return $users;
    }
 
public function deleteUser(Request $request , $id)
{
 $user = User::where('id', $id)->delete();  
 $data['statusMsg']="user Deleted Successfully";   
 $data['statusCode'] ="1";
 return $data;
}
public function RegisterUser(Request $request){
    $compPic='';
    dd($request->profile_pic);
    if( $request->hasFile('profile_pic')){
        dd($request->profile_pic);
        $completefilename =$request->file('profile_pic')->getClientOriginalName();
        $Extension =$request->file('profile_pic')->getClientOriginalExtension();
        $filenameonly = pathinfo($completefilename , PATHINFO_FILENAME);    
        $fileExtension = pathinfo($completefilename , PATHINFO_EXTENSION); 
        $compPic = str_replace(' ', '_', $filenameonly)."-".rand() .'_'.time().'.'.$fileExtension;   
        $path =$request->file('profile_pic')->storeAs('public/post' ,  $compPic);
        // dd($compPic, $completefilename , $filenameonly, $fileExtension);

    }

     $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password) ,
    ]);
 
    $user['statusCode']='1';
    $user['statusMsg']='User Added Successfully';
    return $user;

 
}
 public function addUser(Request $request)
    {
// $validator = $request->validate([
//           'name' => 'required|string|max:255',
//           'email' => 'required|string|email|max:255|unique:users',
//           'password' => ['required', 'confirmed', Rules\Password::defaults()],
//         ]);
// echo"<pre>";
// print_r($validator);
// echo"<pre>";
// die("hvhdvs");
  
if ($request->password == $request->confirmpassword) {

    $user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password) ,
    ]);

    $user['statusCode']='1';
    $user['statusMsg']='User Added Successfully';
    // return $user;
    $user['icon'] = 'success';
    $user['title']='Successfully';
    } else{
    $user['icon'] = 'error';
    $user['title']='Failure';
    $user['statusCode']='0';
    $user['statusMsg']='Password and Confirm Password does not match';

}
    return $user;


 
}

public function getUser(Request $request , $id){
    $users =User::where('id', $id)->get() ;
 
        return $users;
}

public function updateUser(Request $request )
{

/* $request->validate([
  'name' => 'required|string|max:255',
  'email' => 'required|string|email|max:255|unique:users,email,'.$request->id,
  'password' => ['required', 'confirmed', Rules\Password::defaults()],
]);*/

 $data =['name' =>$request[0]['name'],'email' =>$request[0]['email']];
 $user = User::where('id', $request[0]['id'])->update($data);
 // print($user);     
 if ($user) {
$tests['statusCode'] ='1';
$tests['statusMsg'] = 'Updated Successfully'; 
 }else{
$tests['statusCode'] ='0';
$tests['statusMsg'] = 'Updated Failed'; 

 }
 return $tests;


}
}
