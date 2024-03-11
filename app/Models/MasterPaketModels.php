<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SoalModels;
use DB;
use Str;

class MasterPaketModels extends Model
{
    use HasFactory;
    protected $table ="m_paket";
    protected $guarded = ['id'];
    protected $appends = ['url_gambar'];

    public function addPaket($request)
    {
        DB::beginTransaction();
        try {

            
            if(!empty($request->id_paket)){
                $oldData = MasterPaketModels::where('id_paket', $request->id_paket)->first();
                if(!empty($request->gambar)){
                    $file = $request->file('gambar');
                    $filename = Str::slug($request->nama_paket) . '.' . $file->getClientOriginalExtension();
                    $file->move('public/paket', $filename);    
                }else{
                    $filename = $oldData->gambar;
                }
                $data = MasterPaketModels::where('id_paket', $request->id_paket)->update([
                    'nama_paket' => $request->nama_paket,
                    'deskripsi'=> $request->deskripsi,
                    'harga'=> str_replace(",","", $request->harga),
                    'gambar'=> $filename,
                ]);
                
            }else{
                $file = $request->file('gambar');
                $filename = Str::slug($request->nama_paket) . '.' . $file->getClientOriginalExtension();
                $file->move('public/paket', $filename);

                $data = MasterPaketModels::create([
                    'nama_paket' => $request->nama_paket,
                    'deskripsi'=> $request->deskripsi,
                    'harga'=> str_replace(",","", $request->harga),
                    'gambar'=> $filename,
                ]);

            }


            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback(); 
            return redirect()->back();
        }
    }

    public function getUrlGambarAttribute()
    {
        return asset('public/paket/'. $this->gambar);

    }

    public function soals()
    {
        return $this->hasMany(SoalModels::class,'id_paket','id_paket');
    }
}
