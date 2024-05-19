<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\Students;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;


class StudentsController extends Controller
{
    public function index()
    {
        return view('StudentsRegister');
    }


    
    public function store(Request $request)
    {
          $email = $request ['FatherEmail'];
          $FatherR= Students::where('fatherEmail',$email)->exists();

          if($FatherR){

       // $password = Students::where('fatherEmail',$email)->select('FatherPassword')->get();
        //$password = $password->first()->{'FatherPassword'};

       //$request['FatherPassword']=$password;

        $validatedData=$request->validate([
        'StudentName'=>'required',
        'StudentAge' =>'required',
        'Balance'=>'required',
        'FatherName'=>'required',
        'FatherEmail'=>'required',
        'FatherPassword'=>'required',
        'PaymentNo'=>'required',
    ]);

     Students::create($validatedData);
     return redirect() -> route('home') ->with('success','Student added successfully.');
          }

          else{ 
              $validatedData=$request->validate([
        'StudentName'=>'required',
        'StudentAge' =>'required',
        'Balance'=>'required',
        'FatherName'=>'required',
        'FatherEmail'=>'required',
        'PaymentNo'=>'required',
       
    ]);
     Students::create($validatedData);
     return redirect() -> route('home') ->with('success','Student added successfully.');

          }
           
    }

    public function registration(Request $request)
    {
        $email = $request ->input('email');
      
        if(!$email) 
        {
            return response()->json(['error' =>'email is required'],400);
        }

        $FatherR =Students::where('fatherEmail',$email)->exists();

       // $password = Students::where('fatherEmail',$email)->select('FatherPassword')->get();
        //$password = $password->first()->{'FatherPassword'};
        $passwordData = Students::where('fatherEmail', $email)->select('FatherPassword')->first();
        $password = $passwordData ? $passwordData->FatherPassword : null;
        

        if($FatherR) {
      
         
            if($password == null) {


        $data= Students::where('FatherEmail',$email)->select('id','FatherName','StudentName')->get(); 
        $Name = $data -> first() ->{'FatherName'};  
        $FatherName=['FatherName'=>$Name];

            
        $res=[
            'name'=>$FatherName,
            'data'=>$data,
            
            ];
        
        
        return response()->json($res, 200);

        }
        else {return response()->json('email is already registered',400);}
    }
        if(!$FatherR) 
    {
        return response()->json(['ERROR' =>'email is not found'],400);
    }
     
    }

      public function applogin(Request $request)
      {
          $x=0;
          $email = $request ->input('email');
          $password = $request ->input('password');

          $registered=Students::where('FatherEmail',$email)->exists();
          $registeredpass=Students::where('FatherEmail',$email)->pluck('FatherPassword');
          $id=Students::where('FatherEmail',$email)->select('id')->first(); 


          if($registered)  {
              if( $registeredpass[0] == $password) {      return response()->json([$id],200);}
              else{return response()->json( ['Error' =>'wrong password'],500);} 
          }

         else{return response()->json(['Error' =>'wrong email'],500);}  
      }


      
     public function deletestudent($id)   
     {
        $record=Students::find($id);

        if(!$record) {
            abort(404); // or handle not found case accordingly
        }

        $record ->delete();

        return redirect()->route('home')->with('success','Student deleted successfully.');
     }


    
   

      public function change(Request $request)   
     {
         $id= $request ->input('id');
         $password = $request ->input('password');
         
         $email= Students::where('id',$id)->first()->{'FatherEmail'};
         
         Students::where('FatherEmail',$email) ->update(['FatherPassword'=>$password]);

          return response()->json( ['ok'=> 'Password created successfully'] ,200);
        }

          public function students(Request $request)   
     {
         $id = $request ->input('id');
        
         $email= Students::where('id',$id)->select('FatherEmail')->get();
         $email = $email->first()->{'FatherEmail'};
         
         $student = Students::where('FatherEmail',$email) ->select('id','StudentName','StudentAge','Balance')->get();

          return response()->json( $student ,200);
        }

         public function payment(Request $request)   
     {
          // Get the 'paymentNo' and 'total' values from the request
         $paymentNo= $request ->input('paymentNo');
         $total = $request ->input('total');
         // Check if a student with the given 'paymentNo' exists in the database
        $balance = Students::where('PaymentNo',$paymentNo)->exists();
         
      if($balance){
          // Retrieve the current balance of the student
          $balance = Students::where('PaymentNo',$paymentNo)->select('Balance')->get();
          $balance = $balance-> first()-> {'Balance'};

          if($total <= $balance)
          {
              // Calculate the new balance after deducting the 'total' amount
              $balance = $balance - $total;
              // Update the student's balance in the database
                 Students::where('PaymentNo',$paymentNo) ->update(['Balance'=>$balance]);
                 // Return the remaining balance as a JSON response
                  return response()->json( ['Remaing balance'=> $balance] ,200);}

                  else  
                   // Return an error response if the student's balance is insufficient
                  {return response()->json(['Refused'=>'unsufficent balance '],200);}

          }
          // Return an error response if the payment number is unknown
          else  {return response()->json(['Error'=>'unknown payment number '],200);}

      }

       public function pickUp(Request $request)   
     {
         // Retrieve input values from the request
         $id= $request ->input('id');
         $name = $request ->input('name');
         $coordinates = $request->input('coordinates');
// Fetch the email of the student's father using the provided ID
         $email= Students::where('id',$id)->select('FatherEmail')->get();
         $email = $email->first()->{'FatherEmail'};
        
// Fetch the student's ID using the extracted email and provided name
         $studentId= Students::where('FatherEmail',$email)->where('StudentName',$name)->select('id')->get();
         $studentId = $studentId-> first()->{'id'};
// Check if there is an attendance record for today and the specified student ID
         $S=attendance::whereDate('created_at',Carbon::today())->where('StudentID',$studentId)->exists();
         

         if($S){
             $lat=substr($coordinates,12,22);
             $lng=substr($coordinates,29,39);

             $lat=floatval($lat);
             $lng=floatval($lng);

             $lat=deg2rad($lat);
             $lng=deg2rad($lng);


             $radiusOfEarth = 3959; //miles
             // Address for the School
             $latitudeOne = deg2rad(21.4889799);
             $longitudeOne = deg2rad(39.2465658);
            
           $distanceLongitude =  $lng - $longitudeOne;
           $distanceLatitude = $lat - $latitudeOne;

           // This is the haversine Formula expressed in PHP
        $a = sin($distanceLatitude/2) * sin($distanceLatitude/2) + cos($latitudeOne) * cos($lat) * sin($distanceLongitude/2) * sin($distanceLongitude/2);
         $c = 2 * asin(sqrt($a));
         $distance = $radiusOfEarth * $c;
          // convert to kilo
         //$distance =$distance *1.609; 
// Check if the distance is less than 1 mile
        if($distance < 1) {  
            // Update the attendance record for the student, setting "OUT" field to 1
            $todaysttendance = attendance::where('StudentID', $studentId)->whereDate('created_at',Carbon::today())->update(['OUT'=>1]);
         
         return response()->json('Pickup request sent.');}
         else {return response()->json('you are far away from school');}
     
      }
      else {return response()->json("Student not in the school");}

        }

        public function stuid(Request $request){
             $id= $request ->input('id');
             $name = $request ->input('name');
             $email= Students::where('id',$id)->select('FatherEmail')->get();
             $email = $email->first()->{'FatherEmail'};
        

             $studentId= Students::where('FatherEmail',$email)->where('StudentName',$name)->select('id')->get();
             $studentId = $studentId-> first()->{'id'};

             return response()->json( $studentId);

        } 

         public function Charge(Request $request){

            // Get the 'id' and 'amount' values from the request
             $id= $request ->input('id');
             $amount = $request ->input('amount');

             // Retrieve the current balance of the student with the given ID
             $balance = Students::where('id', $id)->get();
             $balance = $balance-> first()->{'Balance'};

             // Calculate the new balance by adding the 'amount' to the current balance
             $newbalance =  $balance +  $amount;
             // Update the student's balance in the database
             Students::where('id', $id)->update(['Balance' => $newbalance]);
             
           // Return the new balance as a JSON response
             return response()->json($newbalance);
}

}

 
