<?php

namespace App\Http\Controllers;

use App\Models\messages;
use App\Models\Students;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $message=$request->input('message');
        $sender=$request->input('sender');
        $receiver=$request->input('receiver');
        $direction=$request->input('direction');

        $model = new messages;

        $model-> message=$message;
        $model-> sender=$sender;
        $model->receiver=$receiver;
        $model->direction=$direction;

        $model->save();

        return response()->json(['success'=>true]);
    




    }
    public function page()
        {
            return view ('chat');

        }

        public function pagedata(Request $request)
        {
            $sender = $request->input('sender');
            $receiver = $request->input('receiver');
            $message1=messages::where('sender',$sender)->where('receiver',$receiver)->orderBy('updated_at','desc')->get();
            $message2=messages::where('sender',$receiver)->where('receiver',$sender)->orderBy('updated_at','desc')->get();
            $message= $message1->merge( $message2);
            $messages=$message->sortByDesc('updated_at');
            $messages = $messages->values();
             $null=[];
             

            if (count($messages)>0){return response()->json( $messages,200);}
            else {return response()->json( $null,200);}
        }

        public function pagedata1(Request $request)
        {
             $sender = $request->input('sender');
            $receiver = $request->input('receiver');
    $message1=messages::whereDate('updated_at',Carbon::today())->where('sender',$sender)->where('receiver',$receiver)->orderBy('updated_at','desc')->get();
$message2=messages::whereDate('updated_at',Carbon::today())->where('sender',$receiver)->where('receiver', $sender)->orderBy('updated_at','desc')->get();
            $message= $message1->merge( $message2);
             $messages=  $message->sortByDesc('updated_at');
               $messages = $messages->values();
             $null=[];

             if (count($messages)>0){return response()->json( $messages,200);}
            else {return response()->json( 'Error',400);}
             
        }
}

    

