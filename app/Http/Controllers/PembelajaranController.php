<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPaketModels;
use App\Models\KategoriSoalModels;
use App\Models\Pembelajaran;
use App\Models\JenisTesModels;
use App\Models\MentorModels;
use App\Models\BookingUserModels;
use App\Models\DetailPaketBimbel;
use App\Models\User;
use DB;
use Str;
use Auth;
use Yajra\DataTables\Facades\DataTables;

class PembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->Pembelajaran = new Pembelajaran();
    }

    public function index(Request $request)
    {
        // printJSON($data);
        if($request->ajax() ){
            $data = Pembelajaran::with(['jenis_tes','kategoriSoal','bab_tes','materi_tes','kategori_pembelajaran']);
            if(Auth::user()->role == 3){
                $booking = BookingUserModels::with('paket_booking')->where('id_siswa', Auth::user()->id_siswa)->first();
                $detailPaket = DetailPaketBimbel::where('id_paket_bimbel', $booking->paket_booking->id_paket_bimbel)->pluck('id_jenis_tes')->toArray();
                $data->whereIn('id_jenis_tes', $detailPaket);

            }
            if(!empty($request->id_jenis_tes)){
                $data->where('id_jenis_tes', $request->id_jenis_tes);
            }
            if(!empty($request->kategori_pembelajaran)){
                $data->where('id_kategori_pembelajaran', $request->kategori_pembelajaran);
            }
            $data->get();
            $data = $data->get();
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('action', function($row){
                        $btn = '';
                         if(Auth::user()->role != 3){
                           $btn = '  <a href="'. url('pembelajaran/edit/'. $row->id_materi) .'" class="edit btn btn-info btn-sm btn-edit">Edit</a>';
                           $btn .= ' <a type="button"  class="delete btn btn-danger btn-sm btn-hapus">Delete</a>';
                           $btn .= ' <a target="_blank" href="'. url('soal?id_materi='.$row->id_materi) .'" class=" btn btn-success btn-sm ">Manajemen Soal</a>';
                         }else {
                            if ($row->id_kategori_pembelajaran == 3) {
                                $btn .= ' <a target="_blank" href="'. url('detailMateri/'.$row->slug) .'" class=" btn btn-success btn-sm ">Detail Materi</a>';
                            }else {
                                $btn .= ' <a target="_blank" href="'. url('soal?id_materi='.$row->id_materi) .'" class=" btn btn-success btn-sm ">Manajemen Soal</a>';
                            }
                        }
   
                        return $btn;
                     })
                     ->addColumn('totalSoal', function($row){
                        $total = count($row->paketSoal);
   
                        return $total;
                     })
                     ->rawColumns(['action','totalSoal'])
                     ->make(true);
                    }

                    $kategoriPembelajaran = DB::table('m_kategori_pembelajaran')->get(); 
                    return view('admin.pembelajaran.view', compact('kategoriPembelajaran'));
    }

   


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paket = KategoriSoalModels::all();
        $mentor = MentorModels::all();
        $kategoriPembelajaran = DB::table('m_kategori_pembelajaran')->get();
        

        return view('admin.pembelajaran.create', compact('paket','kategoriPembelajaran', 'mentor'));
    }
    public function edit($id)
    {
        $data =  Pembelajaran::with(['jenis_tes','kategoriSoal','bab_tes','materi_tes','kategori_pembelajaran'])->where('id_materi', $id)->first();
        $paket = KategoriSoalModels::all();
        $kategoriPembelajaran = DB::table('m_kategori_pembelajaran')->get();
        
        $mentor = MentorModels::all();
        return view('admin.pembelajaran.create', compact('paket','data','mentor','kategoriPembelajaran'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->Pembelajaran->addPembelajaran($request);

        if ($result)  return redirect('pembelajaran');
        
        return redirect('pembelajaran');
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

    public function detailMateri($id)
    {
        $data =  Pembelajaran::with(['jenis_tes','kategoriSoal','bab_tes','materi_tes','kategori_pembelajaran', 'mentor'])->where('slug', $id)->first();
        
        return view('admin.pembelajaran.detailMateri', compact('data'));
    }

    
}
