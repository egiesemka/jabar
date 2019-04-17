<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Cuti;

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
        return view('home');
    }

    public function getname()
    {
        // return Auth::user();
        // $test=json_encode(Auth::user());
        // return response()->json(['error' => true,'pesan' => $test]);
        return Auth::user();
    }

    public function countdashboard()
    {
        $idsaya=Auth::user()->id;
        $yearNow = Carbon::now()->year;    

        $datacutiall = Cuti::where('pengaju_cuti', '=', $idsaya)->whereYear('created_at', '=', $yearNow)->count();
        $kuotacuti=12-$datacutiall;

        $menunggupersetujuan = Cuti::where('pengaju_cuti', '=', $idsaya)->where('status','=','menunggu')->whereYear('created_at', '=', $yearNow)->count();
        $diterimacuti = Cuti::where('pengaju_cuti', '=', $idsaya)->where('status','=','diterima')->whereYear('created_at', '=', $yearNow)->count();


        // return response()->json($data);
        return response()->json(array('datacutiall'=>$datacutiall,
                                    'kuotacuti'=>$kuotacuti,
                                    'menunggupersetujuan'=>$menunggupersetujuan,
                                    'diterimacuti' => $diterimacuti
                                    ));
    }
}
