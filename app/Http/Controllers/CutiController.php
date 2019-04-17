<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuti;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        // return Users::all(); 
        $id_user=Auth::user()->id;
        // $data = Users::all();
        $search =  $request->search;
        $data=Cuti::select('cutis.*', 'NamaPengaju.name as pengaju', 'NamaAtasan.name as atasan')
                        ->join('users as NamaPengaju', 'cutis.pengaju_cuti', '=', 'NamaPengaju.id')
                        ->join('users as NamaAtasan', 'cutis.dituju_cuti', '=', 'NamaAtasan.id')
                        ->where('pengaju_cuti', '=', $id_user)
                        ->where(function ($query)  use ($search)
                        {
                        $query->where('tgl_cuti_mulai', 'LIKE', "%$search%")
                                ->orWhere('tgl_cuti_selesai', 'LIKE', "%$search%")
                                ->orWhere('status', 'LIKE', "%$search%")
                                ->orWhere('keterangan_cuti', 'LIKE', "%$search%")
                                ->orWhere('keterangan_balasan_cuti', 'LIKE', "%$search%")
                                ->orWhere('NamaAtasan.name', 'LIKE', "%$search%")
                                ->orWhere('NamaPengaju.name', 'LIKE', "%$search%");
                        })
                        ->orderBy('created_at','DESC')
                        ->paginate(10);
                    
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addCuti(Request $request)
    {
        $this->validate($request, [
            'tgl_mulai_cuti' => 'required',
        ]);
        $id_user=Auth::user()->id;
        $yearNow = Carbon::now()->year;   

        //validasi kuota cuti
        $datacutiall = Cuti::where('pengaju_cuti', '=', $id_user)->whereYear('created_at', '=', $yearNow)->count();
        if($datacutiall>12)
        {
            return response()->json(['error' => true, 'pesan' => 'anda sudah melebihi kuota cuti anda tahun ini!']);
        }

        //validasi tgl cuti udh dipakai belum

        
        
        

        if($request['tgl_selesai_cuti'] =='' || $request['tgl_selesai_cuti'] == null)
        {
            $request['tgl_selesai_cuti'] = $request['tgl_mulai_cuti'];
        }

        $idAtasan = User::select('atasan_id')->where('id','=',$id_user)->get();
        $idAtasan = $idAtasan[0]['atasan_id'];
        
        $formatted_dt1=Carbon::parse($request['tgl_mulai_cuti']);
        $formatted_dt2=Carbon::parse($request['tgl_selesai_cuti']);

        $lama_cuti = $formatted_dt1->diffInDaysFiltered(function(Carbon $date) {
                    return !$date->isWeekend();
        }, $formatted_dt2);
        $lama_cuti=$lama_cuti+1;

        $user= new Cuti();
        $user->pengaju_cuti= $id_user;
        $user->lama_cuti= $lama_cuti;
        $user->dituju_cuti= $idAtasan;
        $user->tgl_cuti_mulai= $request['tgl_mulai_cuti'];
        $user->tgl_cuti_selesai= $request['tgl_selesai_cuti'];
        $user->status= 'menunggu';
        $user->keterangan_cuti= $request['keterangan'];
        $user->keterangan_balasan_cuti= '';
        // add other fields
        $user->save();


        //send mail to atasan
        $to_name = 'Pegawai';
        $to_email = 'jabarjuara2019@gmail.com';
        $nama_Atasan = User::select('name')->where('id','=',$idAtasan)->get();
        $nama_Atasan = $nama_Atasan[0]['name'];

        $data = array('name'=>$nama_Atasan, "body" => "Ada data cuti baru dari bawahanmu!");
            
        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                    ->subject('Ada Cuti Baru!');
            $message->from('jabarjuara2019@gmail.com','Jabar');
        });


        return $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dataPermintaanCuti(Request $request)
    {
       
        // return Users::all(); 
        $id_user=Auth::user()->id;
        // $data = Users::all();
        $search =  $request->search;
        $data=Cuti::select('cutis.*', 'NamaPengaju.name as pengaju', 'NamaAtasan.name as atasan')
                        ->join('users as NamaPengaju', 'cutis.pengaju_cuti', '=', 'NamaPengaju.id')
                        ->join('users as NamaAtasan', 'cutis.dituju_cuti', '=', 'NamaAtasan.id')
                        ->where('dituju_cuti', '=', $id_user)
                        ->where(function ($query)  use ($search)
                        {
                        $query->where('tgl_cuti_mulai', 'LIKE', "%$search%")
                                ->orWhere('tgl_cuti_selesai', 'LIKE', "%$search%")
                                ->orWhere('status', 'LIKE', "%$search%")
                                ->orWhere('keterangan_cuti', 'LIKE', "%$search%")
                                ->orWhere('keterangan_balasan_cuti', 'LIKE', "%$search%")
                                ->orWhere('NamaAtasan.name', 'LIKE', "%$search%")
                                ->orWhere('NamaPengaju.name', 'LIKE', "%$search%");
                        })
                        ->orderBy('created_at','DESC')
                        ->paginate(10);
                    
        return response()->json($data);
    }

    public function tolakPermintaanCuti(Request $request, $id)
    {
        $saya=Auth::user()->id;
        $Userss = Cuti::where('id', '=', $id )->where('dituju_cuti', '=', $saya )->firstOrFail();
        $Userss->status = 'ditolak';
        $Userss->save();

        //send mail to atasan
        $to_name = 'Pegawai';
        $to_email = 'jabarjuara2019@gmail.com';
        $namaPengaju = Cuti::select('name')->join('users','users.id','=','cutis.pengaju_cuti')->where('cutis.id','=',$id)->get();
        $namaPengaju = $namaPengaju[0]['name'];

        $data = array('name'=>$namaPengaju, "body" => "Pengajuan cuti anda ditolak!");
            
        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                    ->subject('Ada Cuti Baru!');
            $message->from('jabarjuara2019@gmail.com','Jabar');
        });
       

        return $Userss;
    }

    public function terimaPermintaanCuti(Request $request, $id)
    {
        $saya=Auth::user()->id;
        $Userss = Cuti::where('id', '=', $id )->where('dituju_cuti', '=', $saya )->firstOrFail();
        $Userss->status = 'diterima';
        $Userss->save();
        
        //send mail to atasan
        $to_name = 'Pegawai';
        $to_email = 'jabarjuara2019@gmail.com';
        $namaPengaju = Cuti::select('name')->join('users','users.id','=','cutis.pengaju_cuti')->where('cutis.id','=',$id)->get();
        $namaPengaju = $namaPengaju[0]['name'];

        $data = array('name'=>$namaPengaju, "body" => "Pengajuan cuti anda diterima!");
            
        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                    ->subject('Ada Cuti Baru!');
            $message->from('jabarjuara2019@gmail.com','Jabar');
        });

        return $Userss;
    }

    public function cutidetail($id)
    {
        $sayaPenerima=Auth::user()->id;
        // return Users::FindOrFail($id);
        return  Cuti::select('cutis.*', 'NamaPengaju.name as pengaju', 'NamaAtasan.name as atasan' , 'jabatans.nama_jabatan')
                    ->join('users as NamaPengaju', 'cutis.pengaju_cuti', '=', 'NamaPengaju.id')
                    ->join('users as NamaAtasan', 'cutis.dituju_cuti', '=', 'NamaAtasan.id')
                    ->join('jabatans', 'NamaPengaju.nama_jabatan','=','jabatans.id')
                    ->where('dituju_cuti', '=', $sayaPenerima)
                    ->where('cutis.id', '=', $id)
                    ->firstOrFail();
     
    } 

    public function cutisayadetail($id)
    {
        $sayaPengaju=Auth::user()->id;
        // return Users::FindOrFail($id);
        return  Cuti::select('cutis.*', 'NamaPengaju.name as pengaju', 'NamaAtasan.name as atasan' , 'jabatans.nama_jabatan', 'jb.nama_jabatan as jabatan_atasan')
                    ->join('users as NamaPengaju', 'cutis.pengaju_cuti', '=', 'NamaPengaju.id')
                    ->join('users as NamaAtasan', 'cutis.dituju_cuti', '=', 'NamaAtasan.id')
                    ->join('jabatans', 'NamaPengaju.nama_jabatan','=','jabatans.id')
                    ->join('jabatans as jb', 'NamaAtasan.nama_jabatan','=','jb.id')
                    ->where('pengaju_cuti', '=', $sayaPengaju)
                    ->where('cutis.id', '=', $id)
                    ->firstOrFail();
     
    } 

    public function cetak($id)
    {
        $sayaPengaju=Auth::user()->id;
        // return Users::FindOrFail($id);
        return  Cuti::select('cutis.*', 'NamaPengaju.name as pengaju', 'NamaAtasan.name as atasan' , 'jabatans.nama_jabatan')
                    ->join('users as NamaPengaju', 'cutis.pengaju_cuti', '=', 'NamaPengaju.id')
                    ->join('users as NamaAtasan', 'cutis.dituju_cuti', '=', 'NamaAtasan.id')
                    ->join('jabatans', 'NamaPengaju.nama_jabatan','=','jabatans.id')
                    ->where('pengaju_cuti', '=', $sayaPengaju)
                    ->where('cutis.id', '=', $id)
                    ->firstOrFail();
     
    } 

    public function cetakAdmin($id)
    {
        // $sayaPengaju=Auth::user()->id;
        // return Users::FindOrFail($id);
        return  Cuti::select('cutis.*', 'NamaPengaju.name as pengaju', 'NamaAtasan.name as atasan' , 'jabatans.nama_jabatan')
                    ->join('users as NamaPengaju', 'cutis.pengaju_cuti', '=', 'NamaPengaju.id')
                    ->join('users as NamaAtasan', 'cutis.dituju_cuti', '=', 'NamaAtasan.id')
                    ->join('jabatans', 'NamaPengaju.nama_jabatan','=','jabatans.id')
                    // ->where('pengaju_cuti', '=', $sayaPengaju)
                    ->where('cutis.id', '=', $id)
                    ->firstOrFail();
     
    }
    
    public function print($id)
    {
        $data = Cuti::select('cutis.*', 'NamaPengaju.name as pengaju', 'NamaAtasan.name as atasan' , 'jabatans.nama_jabatan', 'jb.nama_jabatan as jabatan_Atasan')
        ->join('users as NamaPengaju', 'cutis.pengaju_cuti', '=', 'NamaPengaju.id')
        ->join('users as NamaAtasan', 'cutis.dituju_cuti', '=', 'NamaAtasan.id')
        ->join('jabatans', 'NamaPengaju.nama_jabatan','=','jabatans.id')
        ->join('jabatans as jb' , 'NamaAtasan.nama_jabatan','=','jb.id')
        // ->where('pengaju_cuti', '=', $sayaPengaju)
        ->where('cutis.id', '=', $id)
        ->firstOrFail();
        return view('print', ['datas' => $data]);
    }

    public function printAdmin($id)
    {
        return view('printAdmin');
    }

    public function admincetak(Request $request)
    {
       
        // return Users::all(); 
        // $id_user=Auth::user()->id;
        // $data = Users::all();
        $search =  $request->search;
        $data=Cuti::select('cutis.*', 'NamaPengaju.name as pengaju', 'NamaAtasan.name as atasan')
                        ->join('users as NamaPengaju', 'cutis.pengaju_cuti', '=', 'NamaPengaju.id')
                        ->join('users as NamaAtasan', 'cutis.dituju_cuti', '=', 'NamaAtasan.id')
                        ->where('status', '=', 'diterima')
                        ->where(function ($query)  use ($search)
                        {
                        $query->where('tgl_cuti_mulai', 'LIKE', "%$search%")
                                ->orWhere('tgl_cuti_selesai', 'LIKE', "%$search%")
                                ->orWhere('status', 'LIKE', "%$search%")
                                ->orWhere('keterangan_cuti', 'LIKE', "%$search%")
                                ->orWhere('keterangan_balasan_cuti', 'LIKE', "%$search%")
                                ->orWhere('NamaAtasan.name', 'LIKE', "%$search%")
                                ->orWhere('NamaPengaju.name', 'LIKE', "%$search%");
                        })
                        ->orderBy('created_at','DESC')
                        ->paginate(10);
                    
        return response()->json($data);
    }

    public function adminall(Request $request)
    {
       
        // return Users::all(); 
        // $id_user=Auth::user()->id;
        // $data = Users::all();
        $search =  $request->search;
        $data=Cuti::select('cutis.*', 'NamaPengaju.name as pengaju', 'NamaAtasan.name as atasan')
                        ->join('users as NamaPengaju', 'cutis.pengaju_cuti', '=', 'NamaPengaju.id')
                        ->join('users as NamaAtasan', 'cutis.dituju_cuti', '=', 'NamaAtasan.id')
                        // ->where('status', '=', 'diterima')
                        ->where(function ($query)  use ($search)
                        {
                        $query->where('tgl_cuti_mulai', 'LIKE', "%$search%")
                                ->orWhere('tgl_cuti_selesai', 'LIKE', "%$search%")
                                ->orWhere('status', 'LIKE', "%$search%")
                                ->orWhere('keterangan_cuti', 'LIKE', "%$search%")
                                ->orWhere('keterangan_balasan_cuti', 'LIKE', "%$search%")
                                ->orWhere('NamaAtasan.name', 'LIKE', "%$search%")
                                ->orWhere('NamaPengaju.name', 'LIKE', "%$search%");
                        })
                        ->orderBy('created_at','DESC')
                        ->paginate(10);
                    
        return response()->json($data);
    }

}
