<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function inserisciCorso(Request $request)
    {
        //$res = Http::acceptJson()->withoutVerifying()->withToken(session('access_token'))->get(route('api.mostra_corsi'))->json();
        $res_corso = Http::acceptJson()
            ->withoutVerifying()
            ->withToken(session('access_token'))
            ->post(route('api.crea_corso'), [
                'request' => $request
            ])->json();
        
        //dd($res);
    }

    public function modificaCorso(Request $request)
    {
        $res_corso = Http::acceptJson()
            ->withoutVerifying()
            ->withToken(session('access_token'))
            ->put(route('api.modifica_corso'), [
                'request' => $request
            ])->json();
    }

    public function cancellaCorso()
    {
        $res_corso = Http::acceptJson()
            ->withoutVerifying()
            ->withToken(session('access_token'))
            ->delete(route('api.cancella_corso'))
            ->json();
    }

    public function vediCorsi()
    {
        $res_corso = Http::acceptJson()
            ->withoutVerifying()
            ->withToken(session('access_token'))
            ->get(route('api.mostra_corsi'))
            ->json();
    }
}
