<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Metoda wyświetlająca widok czatu po zalogowaniu
    public function index()
    {
        // Pobranie danych aktualnie zalogowanego użytkownika
        $user = Auth::user();

        //Przypisz rolę użytkownika
        $role = $user->role;

        //Jeżeli użytkownik jest administratorem (nie widzi uczniów - nie ma potrzeby bezpośredniej komunikacji)
        if ($role == 'admin')
        {
            $users = User::where('id', '!=', $user->id)
                ->where('role', '!=', 'uczeń')
                ->orderBy('role', 'ASC' )
                ->orderBy('fname', 'ASC')
                ->get();
        }
        //jeżeli użytkownik jest nauczycielem (widzi tylko swoją klasę, innych nauczycieli oraz adminów)
        elseif ($role == 'nauczyciel')
        {
            $users = User::where('id', '!=', $user->id)
                ->where('class_id', $user->class_id)
                ->orwhere('id', '!=', $user->id)
                ->where('role', '!=', 'uczeń')
                ->orderBy('role', 'ASC' )
                ->orderBy('fname', 'ASC')
                ->get();
        }
        //Jeżeli jest uczniem to widzi tylko uczniów ze swojej klasy i tylko swojego nauczyciela
        else
        {
            $users = User::where('id', '!=', $user->id)
                ->where('class_id', $user->class_id)
                ->orderBy('role', 'ASC' )
                ->orderBy('fname', 'ASC')
                ->get();
        }

        // Pobierz wszystkich użytkowników z tej samej klasy (oprócz zalogowanego)
//        $users = User::where('id', '!=', $user->id)
//            ->where('class_id', '=', $user->class_id)
//            ->orderBy('id', 'DESC')
//            ->get();

        // Pobieramy id klasy nauczyciela (zakładamy, że nauczyciel ma przypisaną klasę)

        $teacherId = Auth::id();
        $teacherClassId = User::find($teacherId)->class_id;
    //Pobranie listy klas
    if ($teacherClassId == $teacherId)
    {
        $students = User::where('class_id', $teacherClassId)
        ->where('role', 'uczeń')
        ->get();
    }
    //Pobranie listy wszystkich użytkowników po za adminem
    elseif ($role == 'admin')
    {
        $students = User::where('id', '!=', $user->id)
            ->get();
    }
    else {
        $students = null;
    }
        // Przekierowanie do widoku 'users.index', gdzie wyświetlamy informacje o użytkowniku
        return view('users.index', compact('user', 'users', 'students')); // Przekazanie zmiennych do widoku
    }

    public function getUsers()
    {
        $outgoing_id = Auth::id(); // ID aktualnie zalogowanego użytkownika
        $users = User::where('id', '!=', $outgoing_id)->orderBy('id', 'DESC')->get();

        // Generowanie HTML
        $output = '';
        foreach ($users as $user) {
            $output .= '
            <a href="' . route('chat.show', $user->id) . '" class="user">
                <div class="content">
                    <img src="' . asset('images/' . $user->img) . '" alt="' . $user->fname . ' ' . $user->lname . '" style="width: 50px; height: 50px;">
                    <div class="details">
                        <span>' . $user->fname . ' ' . $user->lname . '</span>
                        <p>' . $user->status . '</p>
                    </div>
                </div>
            </a>';
        }

        return response()->json(['html' => $output]); // Zwróć HTML jako JSON
    }

    // Wyszukiwanie użytkowników na podstawie imienia/nazwiska
    public function search(Request $request)
    {
        $outgoing_id = Auth::id(); // ID aktualnie zalogowanego użytkownika
        $searchTerm = $request->searchTerm;

        // Wyszukiwanie użytkowników, którzy nie są zalogowanym użytkownikiem
        $users = User::where('id', '!=', $outgoing_id)
            ->where(function($query) use ($searchTerm) {
                $query->where('fname', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('lname', 'LIKE', "%{$searchTerm}%");
            })
            ->get();

        return view('users.data', compact('users'))->render(); // Renderujemy wynik wyszukiwania
    }

    public function destroy(User $user)
    {
        // Usuwamy użytkownika
        $user->delete();

        // Przekierowanie po usunięciu, np. na stronę z listą użytkowników
        return redirect()->route('users.index')->with('success', 'Użytkownik został usunięty.');
    }
}
