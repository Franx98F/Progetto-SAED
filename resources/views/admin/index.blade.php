@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />

<style>
    input#fine {
        /* right: 3px; */
        position: relative;
        left: 28px;
    }

    input#inizio {
        position: relative;
        left: 20px;
    }

    input#exampleFormControlInput1 {
        position: relative;
        width: 50%;
    }

    input#membri-max {
        position: relative;
        width: 15%;
    }

    input#orario_fine {
        position: relative;
        left: 9px;
    }

    a {
        text-decoration: none;
        color: white;
    }

    a:hover {
        text-decoration: none;
        color: white;
    }

    button#modifica-corsi-s {
        position: absolute;
        top: 10px;
        right: 0;
        margin-top: 71px;
        margin-right: 34%;
    }

    input#nome-corso-modifica {
        width: 40%;
    }

    input#membri-max_modifica {
        width: 20%;
    }

    button#cancella-corsi-s {
        position: absolute;
        top: 10px;
        right: 0;
        margin-top: 72px;
        margin-right: 125px;
    }

    button#visualizza-corsi {
        position: absolute;
        margin-top: 50px;
        margin-left: 17px;

    }

    div#spinner-border {
        display: none;
        position: absolute;
        margin-top: 105px;
        margin-left: 45px;
    }

    table#corsi-table {
        position: absolute;
        margin-top: 120px;
    }

    button#visualizza-corso-s {
        position: absolute;
        margin-top: 2px;
        margin-left: 25%;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard riservata ai maestri impianto scii') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('Benvenuto! Sei loggato come admin') }}<br>
                    <!-- Modal Form per aggiungere tipologia corsi scii -->
                    <!-- Bottone attivazione  modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Inserisci Tipologia Corso
                    </button>

                    <!-- Inizio Modal + Form per tipologie dei vari corsi scii-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Inserisci Nuova tipologia di corso</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Inserisci difficoltà corso scii</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" name="difficolta" rows="2"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Inserisci descrizione corso scii</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea2" name="descrizione" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="clear-data-tipo" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                    <button type="submit" id="send-data-tipo" class="btn btn-primary" data-target="#tipo">Salva Dati</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fine Modal + Form per tipologie dei vari corsi scii-->

                    <button id="" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCreate">
                        Inserisci Corso
                    </button>

                    <!-- Inizio Modal + Form per creare i vari corsi scii-->
                    <div class="modal fade" id="exampleModalCreate" tabindex="-1" aria-labelledby="exampleModalLabelCreate" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabelCreate">Inserisci Nuovo corso</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    Scegli Corso: <select name="tipo" id="selezionaCorso">
                                        {{ $corsi_scii = DB::table('tipo')->select('idCorso','difficolta')->get() }}
                                        <option value="" selected="selected"> Seleziona Corso
                                        </option>
                                        @foreach($corsi_scii as $corso_scii)
                                        <option value=""> {{ $corso_scii->idCorso." - ".$corso_scii->difficolta }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <br><br>

                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Inserisci Nome del corso scii</label>
                                        <input type="text" name="nome" class="form-control" id="exampleFormControlInput1" placeholder="inserisci nome corso">
                                    </div>

                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Inserisci Membri Max</label><br>
                                        <input value="1" id="membri-max" type="number" name="membriMax" class="form-control" id="exampleFormControlInput1">
                                    </div>
                                    <br>

                                    <label for="orario_inizio">Orario Inizio:</label>
                                    <input type="time" id="orario_inizio" name="orario_inizio"><br>

                                    <label for="orario_fine">Orario Fine:</label>
                                    <input type="time" id="orario_fine" name="orario_fine"><br>

                                    <label for="inizio">Inizio:</label>
                                    <input type="date" id="inizio_data" name="inizio"><br>

                                    <label for="fine">Fine:</label>
                                    <input type="date" id="fine_data" name="fine"><br>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="clear-corso-data" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                    <button type="submit" id="send-corso-data" class="btn btn-primary" data-target="#corso">
                                        Salva Dati
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fine Modal + Form per creare i vari corsi scii-->

                <button id="modifica-corsi-s" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modifica-corsi">
                    Modifica Corso
                </button>

                <!-- Inizio Modal + Form per modificare i vari corsi scii-->
                <div class="modal fade" id="modifica-corsi" tabindex="-1" aria-labelledby="exampleModalLabelCreate" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabelCreate">Inserisci Corso da modificare</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                Scegli Corso: <select name="corso" id="selezionaCorso">
                                    {{ $corsi_scii = DB::table('corsoscii')->select('idCorso','nome')->get() }}
                                    <option value="" selected="selected"> Seleziona Corso
                                    </option>
                                    @foreach($corsi_scii as $corso_scii)
                                    <option value=""> {{ $corso_scii->idCorso." - ".$corso_scii->nome }}
                                    </option>
                                    @endforeach
                                </select>
                                <br><br>

                                <div class="mb-3">
                                    <label for="nome-corso-modifica" class="form-label">Inserisci Nome del corso scii da modificare</label>
                                    <input type="text" name="nome" class="form-control" id="nome-corso-modifica" placeholder="inserisci nome corso">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Inserisci Membri Max da modificare</label><br>
                                    <input value="1" id="membri-max_modifica" type="number" name="membriMax" class="form-control" id="exampleFormControlInput1">
                                </div>
                                <br>

                                <label for="orario_inizio">Orario Inizio da modificare:</label>
                                <input type="time" id="orario_inizio_modifica" name="orario_inizio"><br>

                                <label for="orario_fine">Orario Fine da modificare:</label>
                                <input type="time" id="orario_fine_modifica" name="orario_fine"><br>

                                <label for="inizio">Inizio da modificare:</label>
                                <input type="date" id="inizio_data_modifica" name="inizio"><br>

                                <label for="fine">Fine da modificare:</label>
                                <input type="date" id="fine_data_modifica" name="fine"><br>

                            </div>
                            <div class="modal-footer">
                                <button type="button" id="clear-corso-data-modifica" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                <button type="submit" id="send-corso-data-modifica" class="btn btn-primary" data-target="#corso-modifica">
                                    Salva Dati
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fine Modal + Form per modificare i vari corsi scii-->

            <button id="cancella-corsi-s" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cancella-corsi">
                Cancella Corso
            </button>

            <!-- Inizio Modal + Form per cancellare i vari corsi scii-->

            <div class="modal fade" id="cancella-corsi" tabindex="-1" aria-labelledby="exampleModalLabelCreate" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabelCreate">Seleziona Corso da cancellare</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            Scegli Corso: <select name="tipo" id="selezionaCorsoCancella">
                                {{ $corsi_scii = DB::table('corsoscii')->select('idCorso','nome')->get() }}
                                <option value="" selected="selected"> Seleziona Corso
                                </option>
                                @foreach($corsi_scii as $corso_scii)
                                <option value=""> {{ $corso_scii->idCorso." - ".$corso_scii->nome }}
                                </option>
                                @endforeach
                            </select>
                            <br><br>
                            <div class="modal-footer">
                                <button type="button" id="clear-corso-data-cancella" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                <button type="submit" id="send-corso-data-cancella" class="btn btn-primary" data-target="#corso-modifica">
                                    Cancella Corso
                                </button>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Fine Modal + Form per cancellare i vari corsi scii-->

            <button id="visualizza-corsi" type="button" class="btn btn-primary">
                Visualizza Corsi
            </button><br><br>

            <div id="spinner-border" class="spinner-border text-primary" role="status">
                <span class="sr-only">Caricamento Dati...</span>
            </div><br>

            <table class='table' id="corsi-table">

            </table>

            <!-- Inizio Modal per visualizzazione dettagli singolo corso -->
            

            <!-- Fine Modal per visualizzazione dettagli singolo corso -->

            <!--<table class="table" id="corsi-table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Nome Corso</th>
                    <th scope="col">Numero Persone</th>
                    <th scope="col">Data di inizio corso</th>
                    <th scope="col">Data di fine corso</th>
                    <th scope="col">Orario di inizio corso</th>
                    <th scope="col">Orario di fine corso</th>
                </tr>
                </thead>
            </table> -->

        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


        <script type="text/javascript">
            $(document).ready(function() {

                if ($('button#clear-data-tipo').click(function() {
                        //console.log('Ok close funziona');
                        $('textarea#exampleFormControlTextarea1').val("");
                        $('textarea#exampleFormControlTextarea2').val("");
                    }));

                $('button#send-data-tipo').click(function() {

                    var difficolta = $('textarea#exampleFormControlTextarea1').val();
                    var descrizione = $('textarea#exampleFormControlTextarea2').val();

                    var jsonTipo = {
                        difficolta: difficolta,
                        descrizione: descrizione
                    };

                    $.ajax({
                        type: "POST",
                        url: "{{route('api.tipo')}}",
                        contentType: 'application/json; charset=utf-8',
                        dataType: 'json',
                        data: JSON.stringify(jsonTipo),
                        headers: {
                            "Authorization": "Bearer {{session('access_token')}}"
                        },
                        success: function(result) {
                            console.log(result);
                            alert("Dati Salvati con successo");
                            $('#tipo').modal('hide');
                            location.reload();
                        },
                        error: function(err) {
                            console.log(err);
                            alert("Dati non salvati.. qualcosa è andato storto\n controlla se hai inserito tutti i dati!");
                        }
                    });


                });

                $('button#send-corso-data').click(function() {

                    var tipo_str = $('select#selezionaCorso').find(':selected')
                        .text()
                        .match(/\d+/);

                    var tipo_int = (parseInt(tipo_str[0]));

                    var nome = $('input#exampleFormControlInput1').val();
                    var membriMax = parseInt($('input#membri-max').val());

                    var orario_inizio = $('input#orario_inizio').val();
                    var orario_fine = $('input#orario_fine').val();

                    var inizio = $('input#inizio_data').val();
                    var fine = $('input#fine_data').val();

                    var jsonCorso = {
                        tipo: tipo_int,
                        nome: nome,
                        membriMax: membriMax,
                        orario_inizio: orario_inizio,
                        orario_fine: orario_fine,
                        inizio: inizio,
                        fine: fine
                    };

                    const nowDate = new Date();
                    checkDate(inizio, fine, nowDate);

                    $.ajax({
                        type: "POST",
                        url: "{{route('api.crea_corso')}}",
                        contentType: 'application/json; charset=utf-8',
                        dataType: 'json',
                        data: JSON.stringify(jsonCorso),
                        headers: {
                            "Authorization": "Bearer {{session('access_token')}}"
                        },
                        success: function(result) {
                            console.log(result);
                            alert("Dati Salvati con successo");
                            $('#corso').modal('hide');
                            location.reload();
                        },
                        error: function(err) {
                            console.log(err);
                            alert("Dati non salvati.. qualcosa è andato storto\n controlla se hai inserito tutti i dati!");
                        }

                    })

                });


                $('button#send-corso-data-modifica').click(function() {

                    var tipo_str = $('select#selezionaCorso').find(':selected')
                        .text()
                        .match(/\d+/);

                    var tipo_int = (parseInt(tipo_str[0]));

                    var nome_mod = $('input#nome-corso-modifica').val();
                    var membriMax_mod = parseInt($('input#membri-max_modifica').val());

                    var orario_inizio_mod = $('input#orario_inizio_modifica').val();
                    var orario_fine_mod = $('input#orario_fine_modifica').val();

                    var inizio_mod = $('input#inizio_data_modifica').val();
                    var fine_mod = $('input#fine_data_modifica').val();

                    var jsonCorso_mod = {
                        tipo: tipo_int,
                        nome: nome_mod,
                        membriMax: membriMax_mod,
                        orario_inizio: orario_inizio_mod,
                        orario_fine: orario_fine_mod,
                        inizio: inizio_mod,
                        fine: fine_mod
                    };

                    const nowDate = new Date();
                    checkDate(inizio, fine, nowDate);

                    $.ajax({
                        type: "PUT",
                        url: "/api/updatecorso/" + tipo_int,
                        contentType: 'application/json; charset=utf-8',
                        dataType: 'json',
                        data: JSON.stringify(jsonCorso_mod),
                        headers: {
                            "Authorization": "Bearer {{session('access_token')}}"
                        },
                        success: function(result) {
                            console.log(result);
                            alert("Dati Salvati con successo");
                            $('#corso').modal('hide');
                            location.reload();
                        },
                        error: function(err) {
                            console.log(err);
                            alert("Dati non salvati.. qualcosa è andato storto\n controlla se hai inserito tutti i dati!");
                        }

                    })

                });

                $('button#send-corso-data-cancella').click(function() {

                    var idCorso_str = $('select#selezionaCorsoCancella').find(':selected')
                        .text()
                        .match(/\d+/);

                    var idCorso_int = (parseInt(idCorso_str[0]));

                    /*var jsonCorso_canc= {
                        idCorso: idCorso_int
                    };*/

                    $.ajax({
                        type: "DELETE",
                        url: "/api/deletecorso/" + idCorso_int,
                        contentType: 'application/json; charset=utf-8',
                        dataType: 'json',
                        data: JSON.stringify(idCorso_int),
                        headers: {
                            "Authorization": "Bearer {{session('access_token')}}"
                        },
                        success: function(result) {
                            console.log(result);
                            alert("Corso Cancellato con successo");
                            $('#corso').modal('hide');
                            location.reload();
                        },
                        error: function(err) {
                            console.log(err);
                            alert("Corso non cancellato.. qualcosa è andato storto");
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

            function checkDate(d1, d2, dnow) {

                const date_i = new Date(d1);
                const date_f = new Date(d2);

                if (date_i < dnow || date_f < dnow) {
                    alert("Impossibile inserire il corso\nControllare le date");
                    throw new Error();
                }
            }

        </script>

    </div>
    @endsection