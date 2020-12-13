<?php

namespace App\Http\Controllers;

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

        $client = new Client(); //GuzzleHttp\Client
        $url = "https://finance-ecommerce.herokuapp.com/api/kas/status";

        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        $data = json_decode($response->getBody());
        
        // dd($data);
        return view('status',compact('data'));
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
        
        // dd($data);
        return view('validation',compact('data'));
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

        return view('kas');
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
