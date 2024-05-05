@extends('admin.layouts.dashboard')

@section('content')
<div class="container">
    <h3>Formulaire de modification de l'employé</h3>
    <form action="{{ route('admin.employee.update', ['employeeid' => $employee->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $employee->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $employee->email }}" required>
        </div>
        <div class="form-group">
            <label for="phone">Téléphone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $employee->phone }}" required>
        </div>
      
        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </form>
</div>
@endsection
