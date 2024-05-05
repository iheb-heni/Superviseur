@extends('admin.layouts.dashboard')

@section('content')

<!-- Bouton pour ajouter une nouvelle machine -->
<div class="mb-4">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMachineModal">Add Machine</button>
</div>
<div class="mb-4">
<form action="{{ route('admin.reinstallallmachines') }}" method="POST">
    @csrf
    @method('PUT')
    <button type="submit" class="btn btn-secondary">Reinstall All Machines</button>
</form>
</div>


<div class="mb-4">
    <form action="{{ route('admin.deleteallmachines') }}" method="POST" id="deleteAllForm">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete All Machines</button>
    </form>
    
</div>

<!-- Content Row -->
<div class="row">

    @if($machines->isNotEmpty())
        @foreach($machines as $machine)
            <!-- Card pour chaque machine -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <!-- En-tête de la carte avec le nom de l'employé -->
                    <div class="card-header">
                        <h5 class="card-title">Employee: {{ $machine->user->name }}</h5>
                        <h5 class="card-title">Id: {{ $machine->id }}</h5>
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
                    <!-- Pied de page de la carte avec les boutons d'action -->
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <!-- Bouton pour mettre à jour la machine -->
                        <!-- Bouton Update -->
                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#updateMachineModal{{$machine->id}}">Update</a>

                        <!-- Modal Update Machine -->
                        <div class="modal fade" id="updateMachineModal{{$machine->id}}" tabindex="-1" role="dialog" aria-labelledby="updateMachineModalLabel{{$machine->id}}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateMachineModalLabel{{$machine->id}}">Update Machine</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.updatemachine', $machine->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="employee">Select Employee:</label>
                                                <select class="form-control" id="employee" name="employee">
                                                    <option value="">{{ $machine->user->name }}</option> <!-- Option vide -->
                                                    @php
                                                        $employees = \App\Models\User::where('type', 0)->get();
                                                    @endphp
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton pour réinstaller la machine -->
                        <form action="{{ route('admin.reinstallmachine', $machine->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-secondary">Reinstall</button>
                        </form>
                        
                        <!-- Bouton pour supprimer la machine -->
                        <form action="{{ route('admin.deletemachine', ['machine_id' => $machine->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12">
            <div class="alert alert-warning" role="alert">
                No machines found.
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
            colors: [ 'green', 'blue','red'], // Couleurs pour TP, TI et TO
            series: [{
                name: 'temps par seconde',
                colorByPoint: true,
                data: [{
                    name: 'TP',
                    y: {{ $machine->TP }}
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

<!-- Modal d'ajout de machine -->
<div class="modal fade" id="addMachineModal" tabindex="-1" role="dialog" aria-labelledby="addMachineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMachineModalLabel">Add Machine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour sélectionner l'employé -->
                <form action="{{route('admin.addmachine')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <h3>hello mr {{$user->name}}</h3>
                        <label for="employee">Select Employee:</label>
                        <select class="form-control" id="employee" name="employee">
                            <option value="">Select Employee</option> <!-- Option vide -->
                            @php
                                $employees = \App\Models\User::where('type', 0)->get();
                            @endphp
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
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
