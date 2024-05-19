<?php

namespace App\Http\Controllers;
use App\Models\Students;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $students=Students::all();
        return view('home',['students'=>$students] );
    }

     public function search(Request $request)
    {
        $validatedData=$request->validate([
            'S'=> 'required',
        ]);

        $query = $request->S;

        $route= route('searchg',['query' => $query]);
        return redirect($route);
    }

    public function searchg($query)
    {

        $students=Students::where('StudentName','LIKE',"%$query%")->get(); // Adgust according to your database structure
        return view ('home',['students'=>$students]);
    }
}
