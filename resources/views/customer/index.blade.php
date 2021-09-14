@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />

<style>
    button#iscrizione-corsi-s {
        position: absolute;
        margin-top: 24px;
        /*margin-left: 150px; */
        /*margin-right: 80px;*/
    }

    button#disiscrizione-corsi-s {
        position: absolute;
        margin-top: 24px;
        margin-left: 145px;
    }

    div#spinner-border {
        display: none;
        position: absolute;
        margin-top: 105px;
        margin-left: 45px;
    }

    button#visualizza-corsi {
        position: absolute;
        margin-top: 13%;
        width: 105px;
        margin-right: 50%;
        /* margin-bottom: 25px; */
    }

    table#corsi-table {
        position: relative;
        top: 150px;
        width: 65%;
    }

    button#visualizza-corsi {
        /* position: fixed; */
        transform: translate(10px, 10px);
    }

    button#delete-p{
        float: right;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard riservata ai clienti impianto scii') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <!-- pulsante per iscrizione corsi scii -->
                    <button id="iscrizione-corsi-s" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#iscrizione-corsi-u">
                        Iscrizione Corso
                    </button>

                    <div class="modal fade" id="iscrizione-corsi-u" tabindex="-1" aria-labelledby="exampleModalLabelCreate" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabelCreate">Seleziona Corso da iscriversi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    Scegli Corso: <select name="tipo" id="selezionaCorsoIscrizione">
                                        {{ $corsi_scii = DB::table('corsoscii')->select('idCorso','nome', 'membriMax')->get() }}

                                        <option value="" selected="selected"> Seleziona Corso
                                        </option>
                                        @foreach($corsi_scii as $corso_scii)
                                    
                                        @if($corso_scii->membriMax != 0)
                                        <option value=""> 
                                            {{ $corso_scii->idCorso." - ".$corso_scii->nome }} 
                                        </option>
                                        
                                        @endif
                    
                                        @endforeach
                                    </select>
                                    <br><br>
                                    <div class="modal-footer">
                                        <button type="button" id="clear-corso-data-iscrizione-u" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                        <button type="submit" id="send-corso-data-iscrizione-u" class="btn btn-primary" data-target="#corso-modifica">
                                            Iscriviti
                                        </button>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- pulsante per cancellazione-utente corsi scii -->
                    <button id="disiscrizione-corsi-s" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#disiscrizione-corsi-u">
                        Disiscrizione Corso
                    </button>

                    <div class="modal fade" id="disiscrizione-corsi-u" tabindex="-1" aria-labelledby="exampleModalLabelCreate" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabelCreate">Seleziona Corso da disciscriverti</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    Scegli Corso: <select name="tipo" id="selezionaCorsoIscrizione">
                                        {{$idUtente_curr = Auth::id()}}
                                        {{ $corsi_scii = DB::table('corsoscii')
                                            ->select('corsoscii.idCorso','nome')
                                            ->join('iscrizione', 'corsoscii.idCorso', '=', 'iscrizione.idCorso')
                                            ->where('iscrizione.idUtente', '=', $idUtente_curr)
                                            ->get() 
                                        }}
                                        <option value="" selected="selected"> Seleziona Corso
                                        </option>
                                        @foreach($corsi_scii as $corso_scii)
                                        <option value=""> {{ $corso_scii->idCorso." - ".$corso_scii->nome }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <br><br>
                                    <div class="modal-footer">
                                        <button type="button" id="clear-corso-data-disiiscrizione-u" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                        <button type="submit" id="send-corso-data-disiscrizione-u" class="btn btn-primary" data-target="#corso-modifica">
                                            Disiscriviti
                                        </button>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{ __('Benvenuto! Sei loggato come cliente') }}
                    <br>
                    <form method="POST" action="{{ route('cancellautente', Auth::id()) }}">
                        @csrf
                        <button id="delete-p" type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" title='Delete'>
                            Elimina Profilo
                            <i class="fa fa-trash"> </i>

                        </button>
                    </form>

                </div>
            </div>
        </div>

        <button id="visualizza-corsi" type="button" class="btn btn-primary">
            Visualizza Corsi
        </button><br><br>

        <div id="spinner-border" class="spinner-border text-primary" role="status">
            <span class="sr-only">Caricamento Dati...</span>
        </div><br><br>

        <table class='table' id="corsi-table">

        </table>


        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script type="text/javascript">
            $('.show_confirm').click(function(e) {
                if (!confirm('Sei Sicuro di voler cancellare il tuo profilo utente ?')) {
                    e.preventDefault();
                }
            });

            $(document).ready(function() {

                $('button#send-corso-data-iscrizione-u').click(function() {

                    var idCorso_str = $('select#selezionaCorsoIscrizione').find(':selected')
                        .text()
                        .match(/\d+/);

                    var idCorso_int = (parseInt(idCorso_str[0]));

                    $.ajax({
                        type: "POST",
                        url: "/api/iscrizione/" + idCorso_int,
                        contentType: 'application/json; charset=utf-8',
                        dataType: 'json',
                        data: JSON.stringify(idCorso_int),
                        headers: {
                            "Authorization": "Bearer {{session('access_token')}}"
                        },
                        success: function(result) {
                            console.log(result);
                            alert("Iscrizione effettuata con successo");
                            $('#corso').modal('hide');
                            location.reload();
                        },
                        error: function(err) {
                            console.log(err);
                            alert("Iscrizione non effettuata...\nQualcosa è andato storto\nCapienza corsi esaurita");
                        }

                    })
                });

                $('button#send-corso-data-disiscrizione-u').click(function() {

                    var idCorso_str = $('select#selezionaCorsoIscrizione').find(':selected')
                        .text()
                        .match(/\d+/);

                    var idCorso_int = (parseInt(idCorso_str[0]));
                    var Utente = "{{Auth::id()}}";

                    $.ajax({
                        type: "DELETE",
                        url: "/api/deleteiscrizione/" + idCorso_int + "/" + Utente,
                        contentType: 'application/json; charset=utf-8',
                        dataType: 'json',
                        data: JSON.stringify(idCorso_int),
                        headers: {
                            "Authorization": "Bearer {{session('access_token')}}"
                        },
                        success: function(result) {
                            console.log(result);
                            alert("Disiscrizione corso effettuata con successo");
                            $('#corso').modal('hide');
                            location.reload();
                        },
                        error: function(err) {
                            console.log(err);
                            alert("Disiscrizione non effettuata...\nQualcosa è andato storto");
                        }

                    })
                });

                $('button#visualizza-corsi').click(function() {
                    $("div#spinner-border").slideToggle();
                    $.ajax({
                        type: "GET",
                        url: "{{route('api.mostra_corsi')}}",
                        contentType: "text/html; charset=utf-8",
                        dataType: "html",
                        data: "",
                        headers: {
                            "Authorization": "Bearer {{session('access_token')}}"
                        },
                        success: function(result) {

                            $("div#spinner-border").slideToggle();

                            var corsiArrayAll = JSON.parse(result);
                            //console.log(corsiArrayAll);

                            $('table#corsi-table').append(
                                "<thead><tr>" +
                                "<th scope='col'>Nome</th>" +
                                "<th scope='col'>Nome Corso</th>" +
                                "<th scope='col>Numero Persone</th>" +
                                "<th scope='col'>Data inizio corso</th>" +
                                "<th scope='col'>Data fine corso</th>" +
                                "<th scope='col'>Orario inizio corso</th>" +
                                "<th scope='col'>Orario fine corso</th></tr></thead>"
                            );


                            for (let corso of corsiArrayAll["corsi"]) {
                                //console.log(corso);
                                $('table#corsi-table').append(
                                    "<tbody></tr>" +
                                    "<td>" + corsiArrayAll["utente"].name + "</td>" +
                                    "<td>" + corso.nome + "</td>" +
                                    "<td>" + corso.inizio + "</td>" +
                                    "<td>" + corso.fine + "</td>" +
                                    "<td>" + corso.orario_inizio + "</td>" +
                                    "<td>" + corso.orario_fine + "</td>" +
                                    "</tr></tbody>"
                                );
                            }

                        },

                        error: function(err) {
                            alert("Impossibile mostrare i corsi");
                        }

                    })
                });


            });
        </script>

    </div>
</div>
@endsection