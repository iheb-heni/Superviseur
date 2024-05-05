<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Machine;
class EmployeeController extends Controller
{
    public function profile()
    {
        $user = User::find(Auth::id());

        return view('employee.sections.profile', compact('user'));
    }


    
    // Méthode pour mettre à jour le profil de l'utilisateur
    public function updateProfile(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Récupération de l'utilisateur actuel
        $user = User::find(Auth::id());

        // Mise à jour des données du profil
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Vérification si une nouvelle photo a été téléchargée
        if ($request->hasFile('photo')) {
            // Sauvegarde de la nouvelle photo
            $photoPath = $request->file('photo')->store('public/profiles');
            $user->photo = $photoPath;
            $user->save();
        }

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }



    public function employeemachine(Request $request) {
        // Récupérer l'identifiant de l'utilisateur connecté
    
        $user = User::find(Auth::id());
    
        // Récupérer les machines associées à l'employé
        $machines = Machine::where('user_id', $user->id)->get();
    
    
        // Retourner la vue avec les données de l'employé et de l'utilisateur connecté
        return view('employee.sections.employeemachines', compact('machines', 'user'));
    }

   



}