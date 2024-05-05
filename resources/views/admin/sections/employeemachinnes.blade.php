@extends('admin.layouts.dashboard')

@section('content')

<!-- Nom de l'employé -->
<h1 class="h3 mb-4 text-gray-800">{{ $employee->name }}</h1>
<div class="col-12">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#associateMachineModal">
        Associer une nouvelle machine
    </button>
</div>
<!-- Légende des couleurs associées à TP, TI et TO -->
<div class="card-footer">
    <div class="d-flex align-items-center">
        <div class="color-box" style="background-color: green; width: 20px; height: 20px;"></div>
        <span class="ml-2">TP: temps de production</span>
    </div>
    <div class="d-flex align-items-center">
        <div class="color-box" style="background-color:blue ; width: 20px; height: 20px;"></div>
        <span class="ml-2">TI : temps d'intervention</span>
    </div>
    <div class="d-flex align-items-center">
        <div class="color-box" style="background-color: red; width: 20px; height: 20px;"></div>
        <span class="ml-2">TO : temps occupée</span>
    </div>
</div>

<!-- Content Row -->
<div class="row">

    @if($machines->count()>0)
        @foreach($machines as $key => $machine)
        <!-- Card pour chaque machine -->
        <div class="col-lg-6 mb-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow h-100">
                        <!-- En-tête de la carte avec l'ID de la machine -->
                        <div class="card-header">
                            <h5 class="card-title">ID: {{ $machine->id }}</h5>
                            <!-- Affichage de la phrase en fonction du statut de la machine -->
                @if($machine->statut == 0)
                <p>Machine en repos</p>
            @elseif($machine->statut == 1)
                <p>Machine en production</p>
            @elseif($machine->statut == 2)
                <p>Machine en état d'intervention</p>
            @elseif($machine->statut == 3)
                <p>Machine occupée</p>
            @endif
                        </div>
                        <div class="card-body">
                            <!-- Graphique Highcharts -->
                            <div id="machineChart{{ $machine->id }}"></div>
                        </div>
                        <!-- Pied de page de la carte -->
                        <div class="card-footer">
                            <!-- Rectangles colorés -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="col-12">
            <div class="text-center text-muted">
                Aucune machine associée à cet employé.
            </div>
        </div>
    @endif
    

</div>

<!-- Inclure Highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>

<!-- Scripts pour créer les graphiques -->
@foreach($machines as $machine)
<script>
    // Données pour le graphique Highcharts de la machine actuelle
    var machine{{ $machine->id }}Data = {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Machine {{ $machine->id }}'
        },
        colors: ['blue', 'green', 'red'], // Couleurs pour TP, TI et TO
        series: [{
            name: 'temps par seconde',
            colorByPoint: true,
            data: [{
                name: 'TP',
                y: {{ $machine->TP  }}
            }, {
                name: 'TI',
                y: {{ $machine->TI }}
            }, {
                name: 'TO',
                y: {{ $machine->TO }}
            }]
        }]
    };

    // Créer le graphique Highcharts
    Highcharts.chart('machineChart{{ $machine->id }}', machine{{ $machine->id }}Data);
</script>
@endforeach
<!-- Modal pour associer une nouvelle machine -->
<div class="modal fade" id="associateMachineModal" tabindex="-1" role="dialog" aria-labelledby="associateMachineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="associateMachineModalLabel">Associer une nouvelle machine à {{ $employee->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.associate.machine') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                    <div class="form-group">
                        <label for="machine_id">Sélectionner une machine :</label>
                        <select class="form-control" id="machine_id" name="machine_id">
                            <option value="">Sélectionner une machine</option> <!-- Option vide -->
                            @foreach(\App\Models\Machine::all() as $machine)
                                <option value="{{ $machine->id }}">{{ $machine->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Associer</button>
                </form>
                
                
            </div>
        </div>
    </div>
</div>
<script>
    // Fonction pour rafraîchir la page toutes les 10 secondes
    function refreshPage() {
        setTimeout(function () {
            location.reload();
        }, 20 * 60 * 1000); // 20 minutes en millisecondes
    }

    // Appeler la fonction pour la première fois
    refreshPage();
</script>

@endsection
