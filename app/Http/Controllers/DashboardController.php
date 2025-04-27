<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $userName = Cookie::get('user_name');
        $sessionName = Session::get('session_name');
        $user = Auth::user();

        return view('dashboard', [
            'userName' => $userName,
            'sessionName' => $sessionName,
            'user' => $user
        ]);
    }

    public function saveName(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        Cookie::queue('user_name', $validated['nom'], 43200); // Cookie durée: 30 jours

        return redirect()->route('dashboard')->with('status', 'Nom enregistré dans un cookie avec succès!');
    }

    public function saveSessionName(Request $request)
    {
        $validated = $request->validate([
            'session_nom' => 'required|string|max:255',
        ]);

        Session::put('session_name', $validated['session_nom']);

        return redirect()->route('dashboard')->with('session_status', 'Nom enregistré en session avec succès!');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Récupérer l'utilisateur correctement
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('dashboard')->with('error', 'Utilisateur non trouvé.');
        }

        // Supprimer l'ancien avatar s'il existe
        if ($user->avatar && $user->avatar !== 'default.png') {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }

        // Générer un nom de fichier unique
        $avatarName = time() . '.' . $request->avatar->extension();

        // Enregistrer l'image dans le dossier storage/app/public/avatars
        $request->avatar->storeAs('avatars', $avatarName, 'public');

        // Mettre à jour l'utilisateur avec le nouveau nom d'avatar
        // Approche alternative pour mettre à jour l'utilisateur (sans utiliser save())
        \App\Models\User::where('id', $user->id)->update(['avatar' => $avatarName]);

        return redirect()->route('dashboard')->with('avatar_status', 'Avatar mis à jour avec succès!');
    }
}
