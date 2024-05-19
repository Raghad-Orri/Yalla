<?php

namespace App\Http\Controllers;

use App\Models\Teachers;
use Illuminate\Http\Request;

class TeachersController extends Controller
{

    
    public function index()
    {
        return view('TeacherRgister');
    }

     public function store(Request $request)
    {
        $validatedData=$request->validate([

            'Name'=> 'required',
            'Role'=> 'required',
            'Email'=> 'required',
            'Mobile'=> 'required',
            ]);
    
    
            Teachers::create($validatedData);
    
            return redirect() -> route('home')->with('success', 'Teacher added successfully.'); ;
    
    }
    

    public function signup(Request $request)
    {
        $email = $request ->input('email');
      
        if(!$email) 
        {
            return response()->json(['error' =>'email is required'],400);
        }

        $Teacher = Teachers::where('Email',$email)->exists();

       // $password = Teachers::where('Email',$email)->select('Password')->get();
       // $password = $password->first()->{'Password'};
       // $passwordData = Teachers::where('Email', $email)->select('Password')->first();
        //$password = $passwordData ? $passwordData->Password : null;
        

        if($Teacher) {
        $passwordData = Teachers::where('Email', $email)->select('Password')->first();
        $password = $passwordData ? $passwordData->Password : null;
        
      
            if($password == null) {


        $data= Teachers::where('Email',$email)->select('id','Name','role')->get(); 
        $Name = $data -> first() ->{'Name'};  
       $Name =['Name'=>$Name];

            
        $res=[
            'name'=>$Name,
            'data'=>$data,
            
            ];
        
        
        return response()->json($res, 200);

        }
        else {return response()->json('email is already registered',400);}
    }
        if(!$Teacher) 
    {
        return response()->json(['ERROR' =>'email is not found'],400);
    }
     
    }

      public function change(Request $request)   
     {
         $id= $request ->input('id');
         $password = $request ->input('password');
         
         $email= Teachers::where('id',$id)->first()->{'Email'};
         
         Teachers::where('Email',$email) ->update(['Password'=>$password]);

          return response()->json( ['ok'=> 'Done'] ,200);
        }


public function applogin(Request $request)
      {
          $x=0;
          $email = $request ->input('email');
          $password = $request ->input('password');

          $registered= Teachers::where('Email',$email)->exists();
        


          if($registered)  {
          $registeredpass= Teachers::where('Email',$email)->pluck('Password');
          $id= Teachers::where('Email',$email)->select('id')->first(); 

              if( $registeredpass[0] == $password) {      return response()->json([$id],200);}
              else{return response()->json( ['Error' =>'wrong password'],500);} 
          }

         else{return response()->json(['Error' =>'wrong email'],500);}  
      }





















}

   
