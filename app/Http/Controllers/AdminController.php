<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Import du modèle User
use App\Models\Machine;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminController extends Controller
{
    public function profile()
    {
        $user = User::find(Auth::id());

        return view('admin.sections.profile', compact('user'));
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






    public function users()
    {
        $user = User::find(Auth::id());
        $admins = User::where('type', '1')->get(); // Récupérer les administrateurs
        $employees = User::where('type', '0')->get(); // Récupérer les employés
    
        return view('admin.sections.users', compact('user', 'admins', 'employees'));
    }


    // Ajout d'un administrateur
public function addAdmin(Request $request)
{
    // Validation des données
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'phone' => 'nullable|string|max:20',
        'password' => 'required|string|min:8',
    ]);

    // Création d'un nouvel utilisateur administrateur
    $admin = new User();
    $admin->name = $request->name;
    $admin->email = $request->email;
    $admin->phone = $request->phone;
    $admin->password = Hash::make($request->password);
    $admin->type = 1; // Type administrateur
    $admin->save();

    return redirect()->back()->with('success', 'Administrateur ajouté avec succès.');
}

// Ajout d'un employé
public function addEmployee(Request $request)
{
    // Validation des données
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'phone' => 'nullable|string|max:20',
        'password' => 'required|string|min:8',
    ]);

    // Création d'un nouvel utilisateur employé
    $employee = new User();
    $employee->name = $request->name;
    $employee->email = $request->email;
    $employee->phone = $request->phone;
    $employee->password = Hash::make($request->password);
    $employee->type = 0; // Type employé
    $employee->save();

    return redirect()->back()->with('success', 'Employé ajouté avec succès.');
}


public function editemployeeform($employeeid)
{
    // Récupérer l'employé à éditer en fonction de son ID
    $employee = User::findOrFail($employeeid);
    $user = User::find(Auth::id());

    // Charger la vue pour la modification de l'employé en passant les données nécessaires
    return view('admin.sections.editemployee', compact('user','employee'));
}



public function updateemployee(Request $request, $employeeid)
{
    // Validation des données
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
    ]);

    // Récupérer l'employé à mettre à jour
    $employee = User::findOrFail($employeeid);

    // Mise à jour des données de l'employé
    $employee->name = $request->name;
    $employee->email = $request->email;
    $employee->phone = $request->phone;

   

    // Enregistrer les modifications
    $employee->save();

    // Rediriger avec un message de succès
    return redirect()->back()->with('success', 'Informations de l\'employé mises à jour avec succès.');
}


public function deleteEmployee($employeeid)
{
    // Recherche de l'employé à supprimer
    $employee = User::findOrFail($employeeid);

    // Suppression de l'employé
    $employee->delete();

    // Redirection avec un message de succès
    return redirect()->back()->with('success', 'Employé supprimé avec succès.');
}


public function employeemachine(Request $request) {
    // Récupérer l'identifiant de l'utilisateur connecté
    $userId = Auth::id();

    // Récupérer l'employé sélectionné
    $employeeId = $request->employee;
    $employee = User::find($employeeId);

    // Vérifier si l'employé existe
    if (!$employee) {
        // Gérer le cas où l'employé n'existe pas, par exemple, redirection ou affichage d'une erreur
    }

    // Récupérer les machines associées à l'employé
    $machines = Machine::where('user_id', $employeeId)->get();

    // Récupérer les données de l'utilisateur connecté
    $user = User::find($userId);

    // Retourner la vue avec les données de l'employé et de l'utilisateur connecté
    return view('admin.sections.employeemachinnes', compact('employee', 'machines', 'user'));
}





public function allmachinnes(Request $request) {
    // Récupérer l'identifiant de l'utilisateur connecté
    $user = User::find(Auth::id());

    $machines = Machine::with('user')->get();

   
    // Retourner la vue avec les données de l'employé et de l'utilisateur connecté
    return view('admin.sections.allmachines', compact( 'user','machines'));
}

  

public function addMachine(Request $request) {
    // Valider les données du formulaire
    $request->validate([
        'employee' => 'required|exists:users,id', // Assurez-vous que l'employé sélectionné existe dans la base de données
        // Autres règles de validation si nécessaire
    ]);

    // Créer une nouvelle machine et remplir les champs
    $machine = new Machine();
    $machine->user_id = $request->employee; // Remplir user_id avec l'ID de l'employé sélectionné
    $machine->TIM = 0;
    $machine->TDG = 0;
    $machine->TP = 0;
    $machine->TI = 0;
    $machine->TO = 0;

    // Enregistrer la nouvelle machine
    $machine->save();

    // Rediriger avec un message de succès
    return redirect()->back()->with('success', 'Machine ajoutée avec succès.');
}


public function deleteMachine(Request $request) {
    try {
        // Trouver la machine par son ID ou générer une exception si non trouvée
        $machine = Machine::findOrFail($request->machine_id);

        // Supprimer la machine
        $machine->delete();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Machine supprimée avec succès.');
    } catch (ModelNotFoundException $e) {
        // Rediriger avec un message d'erreur si la machine n'est pas trouvée
        return redirect()->back()->with('error', 'Machine non trouvée.');
    }
}


public function updateMachine(Request $request, Machine $machine) {
    // Valider les données du formulaire
    $request->validate([
        'employee' => 'required|exists:users,id',
    ]);

    // Mettre à jour l'employé associé à la machine
    $machine->update([
        'user_id' => $request->employee,
    ]);

    // Rediriger avec un message de succès
    return redirect()->back()->with('success', 'Machine mise à jour avec succès.');
}


public function reinstall(Request $request, $machineId)
{
    try {
        $machine = Machine::findOrFail($machineId);
        $machine->update([
            'TDG' => 0,
            'TP' => 0,
            'TI' => 0,
            'TO' => 0,
        ]);
        return redirect()->back()->with('success', 'Machine reinstalled successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to reinstall machine');
    }
}


public function reinstallAll(Request $request)
{
    try {
        Machine::query()->update([
            'TDG' => 0,
            'TP' => 0,
            'TI' => 0,
            'TO' => 0,
        ]);
        return redirect()->back()->with('success', 'All machines reinstalled successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to reinstall all machines');
    }
}

public function deleteAll(Request $request)
{
    try {
        Machine::truncate();
        return redirect()->back()->with('success', 'All machines deleted successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete all machines');
    }
}


public function associateMachine(Request $request)
{
    // Récupérer l'ID de la machine et de l'employé à associer
    $machineId = $request->input('machine_id');
    $employeeId = $request->input('employee_id');

    // Trouver la machine et l'employé correspondants dans la base de données
    $machine = Machine::findOrFail($machineId);
    $employee = User::findOrFail($employeeId);

    // Mettre à jour l'ID de l'employé associé à la machine
    $machine->user_id = $employee->id;
    $machine->save();

    // Rediriger avec un message de succès ou toute autre logique nécessaire
    return redirect()->back()->with('success', 'Machine associée avec succès à l\'employé.');
}
}
