<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class ViewFinanceController extends Controller
{
    public function home(Request $request)
    {
        // dd($request->session()->get('login'));
        if ($request->session()->has('login')) {
            return view('home');
        } else {
            return redirect()->route('view.login');
        }       
    }

    public function pemasukan(Request $request)
    {
        if (!$request->session()->has('login')) {
            return redirect()->route('view.login');
        }

        $validationData = Validator::make($request->all(), [
            'sort_date_from' => 'required|date',
            'sort_date_to' => 'required|date',
        ]);

        $data = [];

        if (!$validationData->fails()) {
            $from = date($request->sort_date_from);
            $to = date($request->sort_date_to);

            $client = new Client(); //GuzzleHttp\Client
            $url = "https://finance-ecommerce.herokuapp.com/api/kas/masuk?sort_date_from=$from&sort_date_to=$to";
    
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
    
            $data = json_decode($response->getBody());
        }  
        
       
        // dd($data);
        return view('pemasukan',compact('data'));
    }

    public function pengeluaran(Request $request)
    {
        if (!$request->session()->has('login')) {
            return redirect()->route('view.login');
        }

        $validationData = Validator::make($request->all(), [
            'sort_date_from' => 'required|date',
            'sort_date_to' => 'required|date',
        ]);

        $data = [];

        if (!$validationData->fails()) {
            $from = date($request->sort_date_from);
            $to = date($request->sort_date_to);

            $client = new Client(); //GuzzleHttp\Client
            $url = "https://finance-ecommerce.herokuapp.com/api/kas/keluar?sort_date_from=$from&sort_date_to=$to";
    
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
    
            $data = json_decode($response->getBody());
        }  
        
       
        // dd($data);
        return view('pengeluaran',compact('data'));
    }

    public function aruskas(Request $request)
    {
        if (!$request->session()->has('login')) {
            return redirect()->route('view.login');
        }

        $validationData = Validator::make($request->all(), [
            'sort_date_from' => 'required|date',
            'sort_date_to' => 'required|date',
        ]);

        $data = [];

        if (!$validationData->fails()) {
            $from = date($request->sort_date_from);
            $to = date($request->sort_date_to);

            $client = new Client(); //GuzzleHttp\Client
            $url = "https://finance-ecommerce.herokuapp.com/api/kas/arus?sort_date_from=$from&sort_date_to=$to";
    
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
    
            $data = json_decode($response->getBody());
        }  
        
       
        // dd($data);
        return view('arus',compact('data'));
    }

    public function labarugi(Request $request)
    {
        if (!$request->session()->has('login')) {
            return redirect()->route('view.login');
        }

        $validationData = Validator::make($request->all(), [
            'sort_month' => 'required|integer|between:1,12',
            'sort_year' => 'required|integer|min:4',
        ]);

        $data = [];

        if (!$validationData->fails()) {
            $mount = $request->sort_month;
            $year = $request->sort_year;

            $client = new Client(); //GuzzleHttp\Client
            $url = "https://finance-ecommerce.herokuapp.com/api/kas/labarugi?sort_month=$mount&sort_year=$year";
    
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
    
            $data = json_decode($response->getBody());
        }  
        
       
        // dd($data);
        return view('bulanan',compact('data'));
    }

    public function status(Request $request)
    {
        if (!$request->session()->has('login')) {
            return redirect()->route('view.login');
        }

        $data = DB::table('arus_kas')
            ->select(DB::raw('sum(`total_biaya`) as data'))
            ->groupBy(DB::raw("DATE(created_at)"))
            ->orderBy(DB::raw("DATE(created_at)"), 'asc')
            ->where([['arus', '=', 'masuk']])
            ->get()->toArray();
        $arus_masuk_datas = array_column($data, 'data');

        $label= DB::table('arus_kas')
            ->select(DB::raw('DATE(created_at) as data'))
            ->groupBy(DB::raw("DATE(created_at)"))
            ->orderBy(DB::raw("DATE(created_at)"), 'asc')
            ->where([['arus', '=', 'masuk']])
            ->get()->toArray();
        $arus_masuk_labels = array_column($label, 'data');

        $data = DB::table('arus_kas')
            ->select(DB::raw('sum(`total_biaya`) as data'))
            ->groupBy(DB::raw("DATE(created_at)"))
            ->orderBy(DB::raw("DATE(created_at)"), 'asc')
            ->where([['arus', '=', 'keluar'],['status', '=', 'diterima']])
            ->get()->toArray();
        $arus_keluar_datas = array_column($data, 'data');

        $label= DB::table('arus_kas')
            ->select(DB::raw('DATE(created_at) as data'))
            ->groupBy(DB::raw("DATE(created_at)"))
            ->orderBy(DB::raw("DATE(created_at)"), 'asc')
            ->where([['arus', '=', 'keluar'],['status', '=', 'diterima']])
            ->get()->toArray();
        $arus_keluar_labels = array_column($label, 'data');
        
        // $arus_kas_masuk = DB::table('arus_kas')
        //             ->select(DB::raw('COUNT(total_biaya) as count'))
        //             ->where('arus', '=', 'masuk')
        //             ->get();  
        // $arus_kas_keluar = DB::table('arus_kas')
        //         ->select(DB::raw('COUNT(total_biaya) as count'))
        //         ->where('arus', '=', 'keluar')
        //         ->get(); 

        // dd($arus_kas_keluar);
        $client = new Client(); //GuzzleHttp\Client
        $url = "https://finance-ecommerce.herokuapp.com/api/kas/status";

        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        $data = json_decode($response->getBody());
        
        return view('status',compact('data'))
        ->with('arus_masuk_data',json_encode($arus_masuk_datas,JSON_NUMERIC_CHECK))
        ->with('arus_masuk_label',json_encode($arus_masuk_labels,JSON_NUMERIC_CHECK))
        ->with('arus_keluar_data',json_encode($arus_keluar_datas,JSON_NUMERIC_CHECK))
        ->with('arus_keluar_label',json_encode($arus_keluar_labels,JSON_NUMERIC_CHECK));
    }

    public function validasi(Request $request)
    {
        if (!$request->session()->has('login')) {
            return redirect()->route('view.login');
        }

        $client = new Client(); //GuzzleHttp\Client
        $url = "https://finance-ecommerce.herokuapp.com/api/kas";

        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        $data = json_decode($response->getBody());
        
        // dd($data);
        return view('validasi',compact('data'));
    }

    public function validation(Request $request, $id)
    {
        if (!$request->session()->has('login')) {
            return redirect()->route('view.login');
        }

        $client = new Client(); //GuzzleHttp\Client
        $url = "https://finance-ecommerce.herokuapp.com/api/kas/$id";

        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        $data = json_decode($response->getBody());

        $id_pegawai = $data->data->id_pegawai;
        $client = new Client(); //GuzzleHttp\Client
        $url = "http://divisi-sdm.herokuapp.com/api/user/$id_pegawai";

        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        $data_pegawai = json_decode($response->getBody());
        
        $id_transaksi = $data->data->transaksi_id;
        // switch ($data->data->jenis) {
        //     case 'penggajian':
        //         $client = new Client(); //GuzzleHttp\Client
        //         $url = "http://divisi-sdm.herokuapp.com/api/penggajian/$id_transaksi";

        //         $response = $client->request('GET', $url, [
        //             'verify'  => false,
        //         ]);

        //         $validasi = json_decode($response->getBody());

        //         //get pegawai
        //         $id_pegawai = $validasi->values[0]->id_pegawai;
        //         $client = new Client(); //GuzzleHttp\Client
        //         $url = "http://divisi-sdm.herokuapp.com/api/pegawai/$id_pegawai";

        //         $response = $client->request('GET', $url, [
        //             'verify'  => false,
        //         ]);

        //         $validasi_pegawai = json_decode($response->getBody());

        //         $data_validasi = [
        //             'datetime' => $validasi->values[0]->created_at,
        //             'jenis' => 'keluar',
        //             'name' => 'Gaji kepada ' .$validasi_pegawai->data->nama
        //                 . '('.$validasi_pegawai->data->jabatan.', '.$validasi_pegawai->data->divisi.')'
        //                 . ' selama '. $validasi->values[0]->jam_kerja . ' jam dan dibayar pada ' 
        //                 . date('d M Y', strtotime($validasi->values[0]->tanggal)),
        //             'desc' => $validasi->values[0]->keterangan,
        //             'divisi' => 'SDM',
        //             'total' => $validasi->values[0]->gaji,
        //             'status' => $validasi->values[0]->status,
        //         ];

        //         break;
            
        //     case 'pengiklanan':
        //         $client = new Client(); //GuzzleHttp\Client
        //         $url = "https://eai-sales.herokuapp.com/api/advertisement/$id_transaksi";

        //         $response = $client->request('GET', $url, [
        //             'verify'  => false,
        //         ]);

        //         $validasi = json_decode($response->getBody());

        //         $data_validasi = [
        //             'datetime' => $validasi->advertisement->created_at,
        //             'jenis' => 'keluar',
        //             'name' => $validasi->advertisement->title,
        //             'desc' => $validasi->advertisement->description,
        //             'divisi' => 'Sales',
        //             'total' => $validasi->advertisement->price,
        //             'status' => 'menunggu',
        //         ];

        //         break;
        //     case 'pembelian':
        //         # code...
        //         break;
        //     case 'pengadaan':
        //         # code...
        //         break;
        //     default:
        //         $data_validasi = [
        //             'datetime' => $data->created_at,
        //             'jenis' => $data->arus,
        //             'name' => $data->name,
        //             'desc' => $data->keterangan,
        //             'divisi' => $data->divisi,
        //             'total' => $data->total,
        //             'status' => $data->status,
        //         ];
        //         break;
        // }
        
        // dd($data_pegawai);
        $data_validasi = [
            'datetime' => $data->data->created_at,
            'jenis' => $data->data->arus,
            'name' => $data->data->nama,
            'desc' => $data->data->keterangan,
            'divisi' => $data->data->divisi,
            'total' => $data->data->total_biaya,
            'status' => $data->data->status,
        ];
        // dd($data_validasi);
        return view('validation',compact('data','data_pegawai', 'data_validasi'));
    }

    public function validationAction(Request $request, $id)
    {
        if (!$request->session()->has('login')) {
            return redirect()->route('view.login');
        }

        $status = $request->status;
        
        $body = [
            'id_arus_kas' => (int)$id,
            'status' => $status
        ];

        $client = new Client(); //GuzzleHttp\Client
        $url = "https://finance-ecommerce.herokuapp.com/api/kas/validasi";

        $response = $client->put($url, [
            'headers'         => ['Content-Type' => 'application/json'],
            'body'            => json_encode($body),
            'verify'  => false
        ]);

        // $data = json_decode($response->getBody());
        
        // dd($data);
        return redirect()->route('view.validasi');
    }

    public function kasIndex(Request $request)
    {
        if (!$request->session()->has('login')) {
            return redirect()->route('view.login');
        }

        $client = new Client(); //GuzzleHttp\Client
        $url = "https://finance-ecommerce.herokuapp.com/api/kas";

        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        $data = json_decode($response->getBody());
        
        // dd($data);

        return view('kas',compact('data'));
    }

    public function kasDelete(Request $request, $id)
    {
        if (!$request->session()->has('login')) {
            return redirect()->route('view.login');
        }

        try {
            $body = [
                'id_arus_kas' => $id
            ];

            $client = new Client(); //GuzzleHttp\Client
            $url = "https://finance-ecommerce.herokuapp.com/api/kas";

            $response = $client->delete($url, [
                'headers'         => ['Content-Type' => 'application/json'],
                'body'            => json_encode($body),
                'verify'  => false
            ]);

            $data = json_decode($response->getBody());

            // dd($value);
            return redirect()->route('view.kasIndex');
        } catch (\Throwable $th) {
            return redirect()->route('view.home');
        }
    }

    public function login()
    {
        return view('login');
    }

    public function loginAction(Request $request)
    {
        $validationData = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!$validationData->fails()) {
            try {
                $body = [
                    'email' => $request->email,
                    'password' => $request->password
                ];
    
                $client = new Client(); //GuzzleHttp\Client
                $url = "https://divisi-sdm.herokuapp.com/api/login";
    
                $response = $client->post($url, [
                    'headers'         => ['Content-Type' => 'application/json'],
                    'body'            => json_encode($body),
                    'verify'  => false
                ]);

                $data = json_decode($response->getBody());

                $request->session()->put('login', true);
                $request->session()->put('token', $data->success->token);

                $client = new Client();
                $url = "https://divisi-sdm.herokuapp.com/api/details";
    
                $response = $client->post($url, [
                    'headers'         => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer '. $request->session()->get('token'),
                    ],
                    'verify'  => false
                ]);

                $value = json_decode($response->getBody());

                $request->session()->put('id', $value->success->id);
                $request->session()->put('nama', $value->success->username);
                $request->session()->put('email', $value->success->email);
                $request->session()->put('role', $value->success->role);

                // dd($value);
                return redirect()->route('view.home');
            } catch (\Throwable $th) {
                return redirect()->route('view.login');
            }
        } else{
            return redirect()->route('view.login');
        }
    }

    public function logoutAction(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('view.login');
        
    }
}
