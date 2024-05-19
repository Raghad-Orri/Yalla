<?php

namespace App\Http\Controllers;

use App\Models\Authorized;
use App\Models\Students;
use Illuminate\Http\Request;

class AuthorizedController extends Controller
{
   
    public function store(Request $request)
    {
        // Validates the incoming request data
    $validatedData=$request->validate([
        'Name'=>'required',
        'Email' =>'required',
        'StudentName'=>'required',
    ]);
    $email =  $validatedData['Email'];
    $studentName=$validatedData['StudentName'];
    // Retrieves the student's ID based on the student name
    $studentId=Students::where('StudentName',$studentName)->select('id')->get();
    $studentId = $studentId->first()->{'id'};
   
    $validatedData['StudentId']= $studentId; 
    // Checks if the authorization already exists for the given email and student name
    $val=Authorized::where('Email',$email)->where('StudentName', $studentName)->exists();
     // Returns an error response if the authorization already exists
    if( $val){ return response()-> json(['error'=>'already authorized'],400);}
    // Creates a new entry in the Authorized model and returns a success response
    else{ Authorized::create($validatedData);return response()-> json(['success'=>'done authorization'],200);}

   // Authorized::create($validatedData);
    

   
}
 // Handles user signup
    public function signup(Request $request)
    {
         
        $email = $request ->input('email');
      
        if(!$email) 
        {
             // Returns an error response if the email is not provided
            return response()->json(['error' =>'email is required'],400);
        }
      // Checks if the email exists in the Authorized model
        $Authorized = Authorized::where('Email',$email)->exists();

       // $password = Teachers::where('Email',$email)->select('Password')->get();
       // $password = $password->first()->{'Password'};
       // $passwordData = Teachers::where('Email', $email)->select('Password')->first();
        //$password = $passwordData ? $passwordData->Password : null;
        

        if($Authorized) {
        $passwordData = Authorized::where('Email', $email)->select('Password')->first();
        $password = $passwordData ? $passwordData->Password : null;
        
       // Retrieves the user's name and additional data if the password is not set
            if($password == null) {


        $data= Authorized::where('Email',$email)->select('id','Name')->get(); 
        $Name = $data -> first() ->{'Name'};  
       $Name =['Name'=>$Name];

            
        $res=[
            'name'=>$Name,
            'data'=>$data,
            
            ];
        
        
        return response()->json($res, 200);

        }
         // Returns an error response if the email is already registered with a password
        else {return response()->json('email is already registered',400);}
    }
        if(!$Authorized) 
    {
         // Returns an error response if the email is not found in the Authorized model
        return response()->json(['ERROR' =>'email is not found'],400);
    }
    
    }
 // Handles password change for authorized users
     public function change(Request $request)   
     {
         $id= $request ->input('id');
         $password = $request ->input('password');

         // Finds the associated email based on the user's ID
         $email= Authorized::where('id',$id)->first()->{'Email'};
         
          // Updates the password in the Authorized model
         Authorized::where('Email',$email) ->update(['Password'=>$password]);

      // Retrieves the associated student's ID and returns a JSON response
        $students=Authorized::where('Email',$email)->select('id','StudentId')->first(); 

          return response()->json([$students],200);
        }

// Retrieves the list of students associated with a particular authorized user
         public function students(Request $request)   
     {
         // Retrieves the email based on the user's ID
         $id = $request ->input('id');
        
         $email=  Authorized::where('id',$id)->select('Email')->get();
         $email = $email->first()->{'Email'};
         
         // Retrieves the student IDs and names associated with the email from the Authorized model
         $student =  Authorized::where('Email',$email) ->select('id','StudentName')->get();

          return response()->json( $student ,200);
        }

        // Handles user login for an application
         public function applogin(Request $request)
      {
          $x=0;
          $email = $request ->input('email');
          $password = $request ->input('password');
        // Checks if the email exists in the Authorized model
          $registered=Authorized::where('Email',$email)->exists();
          // Retrieves the registered password for the email
          $registeredpass=Authorized::where('Email',$email)->pluck('Password');

           // Retrieves the associated student's ID and returns a JSON response if the email and password match
          $students=Authorized::where('Email',$email)->select('id','StudentId')->first(); 


          if($registered)  {
              if( $registeredpass[0] == $password) {      return response()->json([$students],200);}
              // Returns an error response if the password is incorrect
              else{return response()->json( ['Error' =>'wrong password'],500);} 
          }
           // Returns an error response if the email is not found
         else{return response()->json(['Error' =>'wrong email'],500);}  
      }


     
    
      
}
     
    


 
    


