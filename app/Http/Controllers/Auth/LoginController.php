<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Récupération de l'utilisateur authentifié
            if ($user->type == 'admin') {
                return redirect()->route('admin.home', ['id' => $user->id]);
            } elseif ($user->type == 'user') {
                return redirect()->route('employee', ['id' => $user->id]);
            } else {
                Auth::logout(); // Déconnexion de l'utilisateur
                return redirect()->back()->with('error', 'Type d\'utilisateur inconnu. Veuillez contacter l\'administrateur.');
            }
        } else {
            return redirect()->back()->with('error', 'Adresse e-mail ou mot de passe incorrect.')->withInput();
        }
    }
    

}
