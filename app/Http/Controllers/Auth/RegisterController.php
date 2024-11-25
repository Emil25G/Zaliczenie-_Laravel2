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
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $input = $this->sanitizeInput($request->all());
        $this->validator($input)->validate();
        $index = UserIndex::where('index', $input['index_number'])->first();

        if (!$index) {
            return back()->withErrors(['index_number' => 'Numer indeksu jest nieprawidłowy.']);
        }

        if ($index->status == 1) {
            return back()->withErrors(['index_number' => 'Numer indeksu został już użyty do rejestracji.']);
        }

        $user = $this->create($input, $index);

        $index->status = 1;
        $index->save();

        return redirect()->route('login')->with('success', 'Zarejestrowano pomyślnie!');
    }


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

    protected function create(array $data, $index)
    {
        $imageName = time() . '.' . $data['image']->extension();
        $data['image']->move(public_path('images'), $imageName);
        $role = (substr($data['index_number'], 0, 3) === 'UCZ') ? 'uczeń' : 'nauczyciel';

        return User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
            'image' => $imageName,
            'class_id' => $index->class_id,
        ]);
    }
    protected function sanitizeInput(array $data)
    {
        $data['fname'] = trim(strip_tags($data['fname']));
        $data['lname'] = trim(strip_tags($data['lname']));
        $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $data['index_number'] = preg_replace('/[^a-zA-Z0-9]/', '', $data['index_number']);

        return $data;
    }
}
