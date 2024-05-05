@extends('admin.layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h3>Administrateurs</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAdminModal">Ajouter un administrateur</button>

            <!-- Tableau pour afficher les administrateurs -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th> <!-- Ajout de la colonne pour l'ID -->
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Photo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td> <!-- Affichage de l'ID de l'administrateur -->
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->phone }}</td>
                            <td><img src="{{ ('/storage/' .$admin->photo) }}" alt="Photo" style="max-width: 100px;"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <h3>Employés</h3>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addEmployeeModal">Ajouter un employé</button>

            <!-- Tableau pour afficher les employés -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th> <!-- Ajout de la colonne pour l'ID -->
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Photo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td> <!-- Affichage de l'ID de l'employé -->
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td><img src="{{('/storage/' .$employee->photo) }}" alt="Photo" style="max-width: 100px;"></td>
                            <td>
                                <!-- Boutons d'actions pour modifier et supprimer -->
                                <a href="{{ route('admin.employee.edit', ['employeeid' => $employee->id]) }}" class="btn btn-primary">Modifier</a>
                                <form action="{{ route('admin.employee.delete', ['employeeid' => $employee->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                                                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter un administrateur -->
<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <!-- Contenu du modal pour ajouter un administrateur -->
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAdminModalLabel">Ajouter un administrateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour ajouter un administrateur -->
                <form action="{{ route('admin.admins.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="1">
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="text" class="form-control" id="phone" name="phone" >
                    </div>
                    <div class="form-group">
                        <label for="password">password</label>
                        <input type="password" class="form-control-file" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter un employé -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <!-- Contenu du modal pour ajouter un employé -->
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Ajouter un employé</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour ajouter un employé -->
                <form action="{{ route('admin.employees.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="0">
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="text" class="form-control" id="phone" name="phone" >
                    </div>
                    <div class="form-group">
                        <label for="password">password</label>
                        <input type="password" class="form-control-file" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
