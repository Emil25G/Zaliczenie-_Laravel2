<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // Metoda do wyświetlania formularza logowania
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('users.index');
        }

        return view('auth.login');
    }

    // Metoda do logowania
    public function login(Request $request)
    {
        // Walidacja danych wejściowych
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            Log::info('Użytkownik zalogowany: ' . $request->email);
            return redirect()->route('users.index');
        }

        // Logowanie nie powiodło się
        Log::warning('Nieudana próba logowania dla: ' . $request->email);
        return back()->withErrors([
            'email' => 'Podany adres email lub hasło są nieprawidłowe.',
        ])->withInput();
    }

    // Metoda do wylogowywania
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
