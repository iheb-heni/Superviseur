<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Supervisor</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f0f2f5;
        color: #1c1e21;
    }
    
    .container {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: .25rem;
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    
    .card {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .card-header {
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        border-radius: 5px 5px 0 0;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-control {
        display: block;
        width: 100%;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    
    .invalid-feedback {
        display: none;
        margin-top: .25rem;
        font-size: 80%;
        color: #dc3545;
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    
    .form-control:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .form-check-input {
        position: static;
        margin-top: .3rem;
        margin-left: -1.25rem;
    }
    
    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border: 1px solid transparent;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .25rem;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    
    .btn-primary {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .btn-primary:hover {
        color: #fff;
        background-color: #0069d9;
        border-color: #0062cc;
    }
    
    .btn-link {
        font-weight: 400;
        color: #007bff;
        text-decoration: none;
    }
    
    .btn-link:hover {
        color: #0056b3;
        text-decoration: underline;
    }
    
    .eye-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #777;
        z-index: 1; /* Assurez-vous que l'icône est au-dessus du champ de saisie */
    }
    
    /* Ajoutez un style spécifique pour le champ de saisie de mot de passe */
    #password-container {
        position: relative;
    }
    
    #password-container input[type="password"] {
        padding-right: 30px; /* Pour laisser de l'espace pour l'icône */
    }
    
       </style>
</head>
<body>
<div class="container">
    @if (Auth::check())
        <a href="{{ route('handleredirect') }}" class="btn btn-primary">Home</a>
    @else
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">{{ __('Supervisor') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group" id="password-container">
                        <label for="password">{{ __('Password') }}</label>
                        <div class="position-relative">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            <i class="fas fa-eye eye-icon" id="togglePassword"></i>
                            @error('password')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                    @endif
                </form>
            </div>
        </div>
    @endif
</div>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>
</body>
</html>
