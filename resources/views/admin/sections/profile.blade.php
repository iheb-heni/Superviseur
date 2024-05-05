@extends('admin.layouts.dashboard')

@section('content')
<style>
    .card {
    margin-top: 20px;
}

.card-header {
    background-color: #007bff;
    color: #fff;
}

.card-body {
    padding: 20px;
}

img {
    max-width: 100%;
    height: auto;
}

</style>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset('/storage/' .$user->photo) }}" alt="User Photo" class="img-fluid">
                        </div>
                        
                        <div class="col-md-8">
                            <h3>{{ $user->name }}</h3>
                            <p>Email: {{ $user->email }}</p>
                            <p>Phone: {{ $user->phone }}</p>
                            <p>Role: {{ $user->type }}</p>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateProfileModal">
                                Modifier le profil
                            </button>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de mise à jour du profil -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" role="dialog" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProfileModalLabel">Modifier le profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire de mise à jour du profil -->
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control-file" id="photo" name="photo">
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
