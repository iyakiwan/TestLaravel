<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Arus_Kas;
use DB;

class ArusKasController extends Controller
{
    protected function arusKasValidation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaksi_id' => 'required|integer',
            'pegawai_id' => 'required|integer',
            'nama' => 'required|string',
            'jenis' => 'required|string',
            'keterangan' => 'required|string',
            'divisi' => 'required|string',
            'biaya' => 'required|nullable|regex:/^\d*(\.\d{2})?$/',
        ]);
        return $validator;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $arus_kas = Arus_Kas::all();
            return response([
                'status' => true,
                'message' => 'Data telah di dapat',
                'data' => $arus_kas
            ], 200);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Failed get data'
            ], 500);
        }
    }

    public function detail($id)
    {
        $arus_kas_id = Arus_Kas::find($id);
        if ($arus_kas_id == null) {
            return response([
                'status' => false,
                'message' => 'Data tidak dapat ditemukan'
            ], 404);
        } else {
            return response([
                'status' => true,
                'message' => 'Data telah di dapat',
                'data' => $arus_kas_id
            ], 200);
        }
    }

    public function createMasuk(Request $request)
    {
        $validationData = $this->arusKasValidation($request);

        if ($validationData->fails()) {
            return response([
                'status' => false,
                'message' => 'Input kas masuk tidak sesuai ketentuan'
            ], 400);
        }
        
        try {
            $arus_kas = new Arus_Kas;
            $arus_kas->transaksi_id = $request->input('transaksi_id');
            $arus_kas->arus = "masuk";
            $arus_kas->jenis = $request->input('jenis');
            $arus_kas->nama = $request->input('nama');
            $arus_kas->keterangan = $request->input('keterangan');
            $arus_kas->divisi = $request->input('divisi');
            $arus_kas->total_biaya = $request->input('biaya');
            $arus_kas->status = "menunggu";
            $arus_kas->id_pegawai = $request->input('pegawai_id');
            $arus_kas->save();

            return response([
                'status' => true,
                'message' => 'Kas masuk telah di inputkan'
            ], 200);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Kas masuk tidak dapat di inputkan'
            ], 500);
        }
        
    }

    public function createKeluar(Request $request)
    {
        $validationData = $this->arusKasValidation($request);

        if ($validationData->fails()) {
            return response([
                'status' => false,
                'message' => 'Input kas keluar tidak sesuai ketentuan'
            ], 400);
        }

        try {
            $arus_kas = new Arus_Kas;
            $arus_kas->transaksi_id = $request->input('transaksi_id');
            $arus_kas->arus = "keluar";
            $arus_kas->jenis = $request->input('jenis');
            $arus_kas->nama = $request->input('nama');
            $arus_kas->keterangan = $request->input('keterangan');
            $arus_kas->divisi = $request->input('divisi');
            $arus_kas->total_biaya = $request->input('biaya');
            $arus_kas->status = "menunggu";
            $arus_kas->id_pegawai = $request->input('pegawai_id');
            $arus_kas->save();
    
            return response([
                'status' => true,
                'message' => 'Kas keluar telah di inputkan'
            ], 200);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Kas keluar tidak dapat di inputkan'
            ], 500);
        }
       
    }

    public function labaRugi(Request $request)
    {
        $validationData = Validator::make($request->all(), [
            'sort_month' => 'required|integer|between:1,12',
            'sort_year' => 'required|integer|min:4',
        ]);

        if ($validationData->fails()) {
            return response([
                'status' => false,
                'message' => 'input sort salah'
            ], 404);
        }        
        
        try {
            $arus_kas_detail = Arus_Kas::select('created_at as tanggal', 'arus', 'nama', 
                    'keterangan', 'total_biaya as biaya', 'status')
                    ->where('status', '=', 'diterima')
                    ->whereMonth('created_at', '=', $request->sort_month)
                    ->whereYear('created_at', '=', $request->sort_year)
                    ->get();
            $arus_kas_masuk = DB::table('arus_kas')
                    ->select(DB::raw('SUM(total_biaya) as ttl_masuk'))
                    ->where([['status', '=', 'diterima'],['arus', '=', 'masuk']])
                    ->whereMonth('created_at', '=', $request->sort_month)
                    ->whereYear('created_at', '=', $request->sort_year)
                    ->get();     
            $arus_kas_keluar = DB::table('arus_kas')
                    ->select(DB::raw('SUM(total_biaya) as ttl_keluar'))
                    ->where([['status', '=', 'diterima'],['arus', '=', 'keluar']])
                    ->whereMonth('created_at', '=', $request->sort_month)
                    ->whereYear('created_at', '=', $request->sort_year)
                    ->get();     

            $laba = true;
            $isi = 0;
            $kas_masuk = $arus_kas_masuk[0]->ttl_masuk;
            $kas_keluar = $arus_kas_keluar[0]->ttl_keluar;

            if (($kas_masuk - $kas_keluar) >= 0) {
                $laba = true;
                $isi = $kas_masuk - $kas_keluar;
            } else {
                $laba = false;
                $isi = $kas_keluar - $kas_masuk;
            }

            if ($arus_kas_detail->count() == 0) {
                return response([
                    'status' => false,
                    'message' => 'Data tidak dapat ditemukan'

                ], 200);
            } else {
                return response([
                    'status' => true,
                    'message' => 'Data telah di dapat',
                    'laba' => $laba,
                    'hasil' => $isi,
                    'bulan' => $request->sort_month,
                    'tahun' => $request->sort_year,
                    'data' => $arus_kas_detail
                ], 200);
            }            
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => $th
            ], 500);
        }
    }

    public function dataKasMasuk(Request $request)
    {
        $validationData = Validator::make($request->all(), [
            'sort_date_from' => 'required|date',
            'sort_date_to' => 'required|date',
        ]);

        if ($validationData->fails()) {
            return response([
                'status' => false,
                'message' => 'input sort salah'
            ], 404);
        }        
        
        try {
            $from = date($request->sort_date_from);
            $to = date($request->sort_date_to);
            $arus_kas_detail = Arus_Kas::select('created_at as tanggal', 'jenis as kategori', 'nama', 
                    'keterangan', 'divisi', 'total_biaya as biaya', 'status')
                    ->where([['arus', '=', 'masuk']])
                    ->whereBetween('created_at', [$from, $to])
                    ->get();

            $arus_kas_masuk = DB::table('arus_kas')
                    ->select(DB::raw('SUM(total_biaya) as ttl_masuk'))
                    ->where([['status', '=', 'diterima'],['arus', '=', 'masuk']])
                    ->whereBetween('created_at', [$from, $to])
                    ->get();     
            
            if ($arus_kas_detail->count() == 0) {
                return response([
                    'status' => false,
                    'message' => 'Data tidak dapat ditemukan'

                ], 200);
            } else {
                return response([
                    'status' => true,
                    'message' => 'Data telah di dapat',
                    'jumlah' => ($arus_kas_masuk[0]->ttl_masuk == null) ? 0 : $arus_kas_masuk[0]->ttl_masuk,
                    'date_from' => $request->sort_date_from,
                    'date_to' => $request->sort_date_to,
                    'data' => $arus_kas_detail
                ], 200);
            }            
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => $th
            ], 500);
        }
        
    }

    public function dataKasKeluar(Request $request)
    {
        $validationData = Validator::make($request->all(), [
            'sort_date_from' => 'required|date',
            'sort_date_to' => 'required|date',
        ]);

        if ($validationData->fails()) {
            return response([
                'status' => false,
                'message' => 'input sort salah'
            ], 404);
        }        
        
        try {
            $from = date($request->sort_date_from);
            $to = date($request->sort_date_to);
            $arus_kas_detail = Arus_Kas::select('created_at as tanggal', 'jenis as kategori', 'nama', 
                    'keterangan', 'divisi', 'total_biaya as biaya', 'status')
                    ->where([['arus', '=', 'keluar']])
                    ->whereBetween('created_at', [$from, $to])
                    ->get();

            $arus_kas_keluar = DB::table('arus_kas')
                    ->select(DB::raw('SUM(total_biaya) as ttl_keluar'))
                    ->where([['status', '=', 'diterima'],['arus', '=', 'keluar']])
                    ->whereBetween('created_at', [$from, $to])
                    ->get();     
            
            if ($arus_kas_detail->count() == 0) {
                return response([
                    'status' => false,
                    'message' => 'Data tidak dapat ditemukan'

                ], 200);
            } else {
                return response([
                    'status' => true,
                    'message' => 'Data telah di dapat',
                    'jumlah' => ($arus_kas_keluar[0]->ttl_keluar == null) ? 0 : $arus_kas_keluar[0]->ttl_keluar,
                    'date_from' => $request->sort_date_from,
                    'date_to' => $request->sort_date_to,
                    'data' => $arus_kas_detail
                ], 200);
            }            
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => $th
            ], 500);
        }
        
    }

    public function dataKasArus(Request $request)
    {
        $validationData = Validator::make($request->all(), [
            'sort_date_from' => 'required|date',
            'sort_date_to' => 'required|date',
        ]);

        if ($validationData->fails()) {
            return response([
                'status' => false,
                'message' => 'input sort salah'
            ], 404);
        }        
        
        try {
            $from = date($request->sort_date_from);
            $to = date($request->sort_date_to);
            $arus_kas_detail = Arus_Kas::select('created_at as tanggal', 'jenis as kategori', 'arus', 'nama', 
                    'keterangan', 'total_biaya as biaya', 'divisi', 'status')
                    ->where('status', '=', 'diterima')
                    ->whereBetween('created_at', [$from, $to])
                    ->get();    

            if ($arus_kas_detail->count() == 0) {
                return response([
                    'status' => false,
                    'message' => 'Data tidak dapat ditemukan'

                ], 200);
            } else {
                return response([
                    'status' => true,
                    'message' => 'Data telah di dapat',
                    'date_from' => $request->sort_date_from,
                    'date_to' => $request->sort_date_to,
                    'data' => $arus_kas_detail
                ], 200);
            }            
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => $th
            ], 500);
        }
    }

    public function status()
    {    
        try {
            $arus_kas_diterima = DB::table('arus_kas')
                    ->select(DB::raw('COUNT(total_biaya) as count'))
                    ->where([['status', '=', 'diterima']])
                    ->get();   
            $arus_kas_menunggu = DB::table('arus_kas')
                    ->select(DB::raw('COUNT(total_biaya) as count'))
                    ->where([['status', '=', 'menunggu']])
                    ->get();  
            $arus_kas_ditolak = DB::table('arus_kas')
                    ->select(DB::raw('COUNT(total_biaya) as count'))
                    ->where([['status', '=', 'ditolak']])
                    ->get();    
            
            return response([
                'status' => true,
                'message' => 'Data telah di dapat',
                'menunggu' => $arus_kas_menunggu[0]->count,
                'tolak' => $arus_kas_ditolak[0]->count,
                'terima' => $arus_kas_diterima[0]->count,
            ], 200);
                  
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => $th
            ], 500);
        }
    }

    public function validasi(Request $request)
    {
        $validationData = Validator::make($request->all(), [
            'id_arus_kas' => 'required|integer',
            'status' => 'required|string',
        ]);

        if ($validationData->fails()) {
            return response([
                'status' => false,
                'message' => 'input data salah'
            ], 404);
        }

        try {
            $arus_kas = Arus_Kas::find($request->input('id_arus_kas'));
            if ($arus_kas == null) {
                return response([
                    'status' => false,
                    'message' => 'Data tidak kas tidak ditemukan'
                ], 404);
            } 
            
            $arus_kas->status = $request->input('status');
            $arus_kas->save();
    
            return response([
                'status' => true,
                'message' => 'Status kas telah diubah'
            ], 200);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Status kas gagal diubah'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validationData = Validator::make($request->all(), [
            'id_arus_kas' => 'required|integer',
        ]);

        if ($validationData->fails()) {
            return response([
                'status' => false,
                'message' => 'id tidak ditemukan'
            ], 404);
        }

        $arus_kas_id = Arus_Kas::find($request->id_arus_kas);
        if ($arus_kas_id == null) {
            return response([
                'status' => false,
                'message' => 'Data tidak dapat dihapus'
            ], 400);
        } else {
            $arus_kas_id->delete();
            return response([
                'status' => true,
                'message' => 'Data telah di hapus'
            ], 200);
        }
    }
}
