<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $user = Auth::user();
        $this->middleware('auth');
    }

    /**
     * Affiche le tableau de bord de l'employé.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function employee()
    {
        $user = Auth::user();
        return view('employee.layouts.dashboard',compact('user'));
    }

    /**
     * Affiche le tableau de bord de l'administrateur.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        $user = Auth::user();

        return view('admin.layouts.dashboard',compact('user'));
    }
    public function handleredirect()
    {
        if (Auth::check()) {
            $user = Auth::user();
    
            if ($user->type == 'admin') {
                return redirect()->route('admin.home', ['id' => $user->id]);
            } elseif ($user->type == 'user') {
                return redirect()->route('employee', ['id' => $user->id]);
            }
        }
    
        return redirect()->route('index');
    }
    

}
