<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CorsoScii;
use App\Models\Tipo;
use App\Models\Iscrizione;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class ApiController extends Controller
{

    /**api call for admin operations */
    //crea tipo per i corsi scii
    public function createtipo(Request $request)
    {

        $tipo = new Tipo();

        $tipo->difficolta = $request->input('difficolta');
        $tipo->descrizione = $request->input('descrizione');

        $tipo->save();
        return response()->json($tipo);
    }

    public function createcorso(Request $request)
    {

        $corsoscii = new CorsoScii();

        $corsoscii->tipo = $request->input('tipo');
        $corsoscii->nome = $request->input('nome');
        $corsoscii->membriMax = $request->input('membriMax');
        $corsoscii->orario_inizio = $request->input('orario_inizio');
        $corsoscii->orario_fine = $request->input('orario_fine');
        $corsoscii->inizio = $request->input('inizio');
        $corsoscii->fine = $request->input('fine');

        $corsoscii->save();

        $idUtente = $request->user()->id;
        $idCorso = $corsoscii->idCorso;
        DB::table('iscrizione')->insert(
            array('idUtente' => $idUtente, 'idCorso' => $idCorso)
        );
        return response()->json($corsoscii);
    }

    public function updatecorso(Request $request, $idCorso)
    {

        $corsoscii = CorsoScii::where('idCorso', $idCorso)->first();

        $corsoscii->tipo = $request->input('tipo');
        $corsoscii->nome = $request->input('nome');
        $corsoscii->membriMax = $request->input('membriMax');
        $corsoscii->orario_inizio = $request->input('orario_inizio');
        $corsoscii->orario_fine = $request->input('orario_fine');
        $corsoscii->inizio = $request->input('inizio');
        $corsoscii->fine = $request->input('fine');

        $corsoscii->save();
        return response()->json($corsoscii);
    }

    public function deletecorso($idCorso)
    {

        $corsoscii = CorsoScii::where('idCorso', $idCorso)->first();
        $corsoscii->delete();

        return response()->json($corsoscii);

        /*if(response()->status() == 200){
            return response()->json($corsoscii);
        }
        else{
            return redirect('/admin')->with('error', 'Errore nel database, il corso sciistico da cancellare non è presente nel database.');
        }*/
    }

    public function mostracorsi(Request $request)
    {   
        $idUtente = $request->user()->id;
        //$corsoscii = DB::table('corsoscii')->get();

        $corsoscii = DB::table('corsoscii')
            ->join('iscrizione','corsoscii.idCorso','=','iscrizione.idCorso')
            ->join('users','users.id','=', 'iscrizione.idUtente')
            ->select('corsoscii.*')
            ->where('id','=', $idUtente)
            ->get();

        return response()->json(
            ['utente' => $request->user(), 'corsi' => $corsoscii]
        );
    }

    public function iscrizione(Request $request, $iscrizioneCorso)
    {

        //$iscrizione = new Iscrizione();

        DB::table('corsoscii')
            ->select('corsoscii.membriMax')
            ->value('membriMax');

        //$iscrizione->idUtente = $request->input('idUtente');
        $idUtente = $request->user()->id;
        //dd($iscrizioneCorso);

        DB::table('corsoscii')->where('idCorso', $iscrizioneCorso)
            ->decrement('membriMax', 1);

        DB::table('iscrizione')->insert(
            array(
                'idCorso' => $iscrizioneCorso,
                'idUtente' => $idUtente
            )
        );

        return response()->json(["success" => "Iscrizione effettuata con successo"]);
    }

    public function deleteiscrizione($idCorso, $idUtente)
    {

        //$iscrizione_scii = Iscrizione::where('idUtente', $idUtente)->first();

        /*$select_current_id = DB::table('iscrizione')
            ->select('iscrizione.*')
            ->where('iscrizione.idUtente', $idUtente)
            ->where('iscrizione.idCorso', $idCorso)
            ->value('idCorso');*/

        DB::table('corsoscii')->where('idCorso', $idCorso)
            ->increment('membriMax', 1);

        DB::table('iscrizione')
            ->where('iscrizione.idCorso', $idCorso)
            ->where('iscrizione.idUtente', $idUtente)
            ->delete();

        return response()->json(
            ["success" => "disiscrizione effettuata con successo"]
        );
    }
}
