<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserIndex;
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
        // Walidacja danych formularza
        $this->validator($request->all())->validate();

        // Sprawdzanie, czy numer indeksu już istnieje w tabeli UserIndex
        $index = UserIndex::where('index', $request->input('index_number'))->first();

        // Jeśli indeks istnieje i ma status 1, oznacza to, że został już użyty
        if ($index && $index->status == 1) {
            return back()->withErrors(['index_number' => 'Numer indeksu został już użyty do rejestracji.']);
        }

        // Tworzymy użytkownika
        $user = $this->create($request->all(), $index);

        // Jeśli numer indeksu nie istniał, tworzymy nowy rekord w tabeli UserIndex
        if (!$index) {
            UserIndex::create([
                'index' => $request->input('index_number'),
                'status' => 1, // Ustawiamy status jako 1, co oznacza, że indeks został już przypisany
            ]);
        } else {
            // Jeśli numer indeksu istnieje, tylko aktualizujemy status
            $index->status = 1;
            $index->save();
        }

        // Przekierowanie na stronę logowania
        return redirect()->route('login')->with('success', 'Zarejestrowano pomyślnie!');
    }

    // Walidacja danych wejściowych
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'index_number' => ['required', 'string', 'max:8'],
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
        ]);
    }

    // Funkcja tworzenia użytkownika
    protected function create(array $data, $index)
    {
        // Generowanie unikalnej nazwy pliku dla obrazu
        $imageName = time().'.'.$data['image']->extension();
        $data['image']->move(public_path('images'), $imageName);

        // Określanie roli na podstawie numeru indeksu
        $role = (substr($data['index_number'], 0, 3) === 'UCZ') ? 'uczeń' : 'nauczyciel';

        // Tworzenie użytkownika i przypisanie danych
        return User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
            'image' => $imageName,
            'class_id' => $index ? $index->class_id : null,  // Przypisanie class_id, jeśli rekord UserIndex istnieje
        ]);
    }
}
