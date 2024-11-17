<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Wskazanie na widok rejestracji
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // Utwórz użytkownika
        $user = $this->create($request->all());

        return redirect()->route('login')->with('success', 'Zarejestrowano pomyślnie!');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'], // Walidacja dla pliku obrazu
        ]);
    }

    protected function create(array $data)
    {
        // Generowanie unikalnej nazwy pliku
        $imageName = time().'.'.$data['image']->extension(); // Używamy extension() na obiekcie pliku

        // Zapisz plik w folderze public/images
        $data['image']->move(public_path('images'), $imageName); // Zapisz obrazek w folderze public/images

        // Tworzenie użytkownika w bazie danych
        return User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'image' => $imageName, // Zapisz nazwę pliku w bazie danych
        ]);
    }
}
