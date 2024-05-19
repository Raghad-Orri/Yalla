<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\Students;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    
    public function attendance(Request $request)
    {
         // Retrieve the input values from the request
        $StudentID = $request ->input('StudentID');
        $TimeIn = $request ->input('TimeIn');
        $Day = $request ->input( 'Day');

       
 // Check if any of the required data is missing
        if(!$StudentID || !$TimeIn ||  !$Day) 
        {
            return response()->json(['error' =>'data required'],400);
        }
// Check if attendance record already exists for the given student and current date
        $attendance= attendance::whereDate('updated_at',Carbon::today())-> where('StudentID',$StudentID)->exists();

        if( $attendance)
        {
// Check if the student has already checked out
            $out = attendance::whereDate('updated_at', Carbon::today())->  where('StudentID', $StudentID ) -> whereNull('OUT')->orWhere('OUT', '')->count() > 0;
            if( $out)  { return response()->json('No pickup request',200);}
            else 
            // Update the student's checkout time
         $TO = attendance::whereDate('updated_at',Carbon::today())-> where('StudentID',$StudentID)->whereNull('TimeOut')->orWhere('TimeOut','')->count()>0;

           if ($TO) {$tTimeOut = attendance::where('StudentID',$StudentID)->whereDate('created_at',Carbon::today())->update(['TimeOut'=>$TimeIn]);
            return response()->json('Student out',200);

            }
        }

        else{
 // Create a new attendance record
        $Data=$request->all();

        

        attendance::create($Data);
        return response()->json(['ok' =>'Student In '],200);


        }
        
      

        

    }
    public function show(Request $request) {
 // Retrieve the StudentID from the request
        $StudentID = $request ->input('StudentID');
        echo $StudentID;
           // Retrieve student data based on the StudentID
        $Studentdata=Students::where('id',$StudentID)->get();
   // Retrieve attendance data for the student
        $attendancedata=attendance::where('StudentID',$StudentID)->get();

        echo $Studentdata;
        echo  $attendancedata;
    }
    public function attendanceview($StudentID)
    {
         // Retrieve attendance records for the given StudentID
        $studentattendances = attendance::where('StudentID',$StudentID)->get();
        
        return view('attendance',['studentattendances'=> $studentattendances]);
    }
   

     public function studentCall() {
          // Retrieve attendance records for today
       $attendance= attendance::whereDate('updated_at',Carbon::today())->where('OUT',1)->where('TimeOUT',null)->orderBy('updated_at','desc')->get();

      for($x=0; $x < count($attendance); $x++) // add names to record
        {
 // Add student names to the attendance records
            $studentid=$attendance[$x]->{'StudentID'};
            $name=Students::where('id',$studentid)->select('StudentName')->get();
            $attendance[$x]['NAME']=$name->first()->{'StudentName'};

        }
        return response()->json ($attendance);
 }
       
     

    public function studentCallpage()
    {
        return view('studencall');
    }

    public function studentCallApp() 
    {
        //get all attendance for today
        $attendance= attendance::whereDate('updated_at',Carbon::today())->where('OUT',1)->where('TimeOUT',null)->orderBy('updated_at','desc')->get();

        //check students if none empty array
        if(count($attendance)==0){  $attendance1=[];  return response()->json($attendance1);  }

        $attendance1= []; //defin array for on time students
        
        //retrive current time
        $currentDateTime = Carbon::now();
        
        //compare time 
        for($x=0; $x< count($attendance); $x++)
        {
            $timestamp = $attendance[$x] -> {'updated_at'};
            $timestampCarbon=Carbon::parse($timestamp);
            $timeDifference= $timestampCarbon->diff($currentDateTime);
            $minutes=$timeDifference->i;
            $hours= $timeDifference->h;

            if( $hours<1 && $minutes<5){array_push( $attendance1, $attendance[$x]);} //if time is ok add to array
            
        }

        for($y=0; $y<count($attendance1);$y++) // add names to record
        {

            $studentid=$attendance1[$y]->{'StudentID'};
            $name=Students::where('id',$studentid)->select('StudentName')->get();
            $attendance1[$y]['NAME']=$name->first()->{'StudentName'};



        }
        return response()->json($attendance1,200); //return result




        }

   public function studentCallApp1() {
       // Retrieve attendance records for students who checked in but haven't checked out today
        $attendance= attendance::whereDate('updated_at',Carbon::today())->where('OUT',1)->where('TimeOUT',null)->orderBy('updated_at','desc')->get();
// If no attendance records found, return an empty array
        if(count($attendance)==0){  $attendance2=[];  return response()->json($attendance2);  }

        $attendance2= []; //for late students

        $currentDateTime = Carbon::now();
 // Check for late students by comparing check-in time with current time
        for($x=0; $x< count($attendance); $x++)
        {
            $timestamp = $attendance[$x] -> {'updated_at'};
            $timestampCarbon=Carbon::parse($timestamp);
            $timeDifference= $timestampCarbon->diff($currentDateTime);
            $minutes=$timeDifference->i;
            $hours= $timeDifference->h;
// If the time difference is greater than or equal to 5 minutes, consider the student as late
            if( $minutes>=5){array_push( $attendance2, $attendance[$x]);}
            
        }
// Retrieve the names of late students from the "Students" table using their ID
        for($y=0; $y<count($attendance2);$y++)
        {

            $studentid=$attendance2[$y]->{'StudentID'};
            $name=Students::where('id',$studentid)->select('StudentName')->get();
            $attendance2[$y]['NAME']=$name->first()->{'StudentName'};



        }
        // Return the list of late students as a JSON response
        return response()->json($attendance2,200);




        }


         public function vibration(Request $request)

    {

       $id = $request->input('id');
// Check if there is any attendance record for the student with the given ID on the current day
        $attendance = attendance::whereDate('updated_at', Carbon::today()) ->where('StudentID', $id)->exists();

        if($attendance) {
// Check if there is any record where the check-out time is null or empty
        $attendance = attendance::whereDate('updated_at', Carbon::today()) ->where('StudentID', $id)->whereNull('OUT')->orWhere('OUT', '')->count() > 0;
// If there is a record with an empty check-out time, return 0
        if($attendance ) {return response()->json(0); }

        else {
// Check if there is any record where the TimeOUT is null or empty
        $attendance = attendance::whereDate('updated_at', Carbon::today()) ->where('StudentID', $id)->whereNull('TimeOUT')->orWhere('TimeOUT', '')->count() > 0;
  // If there is a record with an empty TimeOUT, return 1
        if($attendance) {return response()->json(1);}
        // If all records have non-empty check-out times, return 0
        else {return response()->json(0);}
        
         } }
 // If no attendance record found for the student on the current day, return 0
         else {return response()->json(0);}


       

    }
                                                
    
       
}
