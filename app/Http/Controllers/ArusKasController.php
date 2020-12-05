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
                    ->where("date_trunc('month', birthdate)", '=', $request->sort_month)
                    ->where("date_trunc('year', birthdate)", '=', $request->sort_year)
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
}
