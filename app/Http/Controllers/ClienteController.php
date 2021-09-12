<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }

    public function index()
    {
        return view('customer.index');
    }

    public function delete($id){

        $user = User::findOrFail($id);
        $user->delete();

        Session::flush();
        Auth::logout();

        return view('welcome')->with(
            'success', 'Hai cancellato il tuo profilo utente :('
        );
    }

    public function inserisciCorsoUtente(Request $request)
    {
        //$res = Http::acceptJson()->withoutVerifying()->withToken(session('access_token'))->get(route('api.mostra_corsi'))->json();
        $res_corso = Http::acceptJson()
            ->withoutVerifying()
            ->withToken(session('access_token'))
            ->post(route('api.iscrizione_allievo'), [
                'request' => $request
            ])->json();
        
        //dd($res);
    }

    public function disiscrivitiCorso()
    {
        $res_corso = Http::acceptJson()
            ->withoutVerifying()
            ->withToken(session('access_token'))
            ->delete(route('api.disiscrizione_allievo'))
            ->json();
    }
}
