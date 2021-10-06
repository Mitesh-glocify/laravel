<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
class EmployeeController extends Controller
{
    public function AddEmployee(Request $request){

       $compPic='';
       if( $request->hasFile('other')){
        $completefilename =$request->file('other')->getClientOriginalName();
        $Extension =$request->file('other')->getClientOriginalExtension();
        $filenameonly = pathinfo($completefilename , PATHINFO_FILENAME);    
        $fileExtension = pathinfo($completefilename , PATHINFO_EXTENSION); 
        $compPic = str_replace(' ', '_', $filenameonly)."-".rand() .'_'.time().'.'.$fileExtension;   
        $path =$request->file('other')->storeAs('public/post' ,  $compPic);
        // dd($path);
        //     dd($compPic ,$completefilename ,$filenameonly, $fileExtension);
        }

       $employee = Employee::create([
          'name'    => $request->name,
          'email'   => $request->email,
          'mobile'  => $request->mobile,
          'address' => $request->address,
          'other'   => $compPic,
      ]);
       if ($employee) {
       $employee['statusCode']='1';
       $employee['statusMsg']='Employee Added Successfully';
       }else{
       $employee['statusCode']='0';
       $employee['statusMsg']='Something went wrong';
       }

       return $employee;
    }
    public function getEmployees()
    {
        $employees = Employee::get();
        return $employees;
    }
    public function deleteEmployee(Request $request , $id)
    {
        $employee = Employee::find($id)->delete();
        $data['statusMsg']="Employee deleted successfully";   
        $data['statusCode'] ="1";
        return $data;
    }
    public function editEmployee(Request $request , $id)
    {
        $employee = Employee::find($id);
        return $employee;
    }
    public function updateEmployee(Request $request)
    {
        $data =['name' =>$request->name ,'email' =>$request->email, 'mobile' => $request->mobile, 'address'=> $request->address];
        $employee = Employee::where('id', $request->id)->update($data);
        $result['statusCode']= "1";
        $result['statusMsg'] ="Employee detail updated successfully";
        return $result; 
    }
}
