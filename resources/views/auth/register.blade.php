@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <section class="form signup">
            <link rel="stylesheet" href="{{ asset('public/style.css') }}">
            <header>Komunikator szkolny - rejestracja</header>
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="error-text">
                    @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="name-details">
                    <div class="field input">
                        <label>Imię</label>
                        <input type="text" name="fname" placeholder="Podaj imię" required value="{{ old('fname') }}">
                        @error('fname')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field input">
                        <label>Nazwisko</label>
                        <input type="text" name="lname" placeholder="Podaj nazwisko" required value="{{ old('lname') }}">
                        @error('lname')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Numer indeksu zamiast roli -->
                <div class="field input">
                    <label>Numer indeksu</label>
                    <input type="text" name="index_number" placeholder="Podaj numer indeksu" required value="{{ old('index_number') }}">
                    @error('index_number')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field input">
                    <label>Adres email</label>
                    <input type="email" name="email" placeholder="Podaj adres email" required value="{{ old('email') }}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field input">
                    <label>Hasło</label>
                    <input type="password" name="password" placeholder="Podaj hasło" required>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field input">
                    <label>Potwierdź hasło</label>
                    <input type="password" name="password_confirmation" placeholder="Potwierdź hasło" required>
                </div>
                <div class="image">
                    <label>Wybierz zdjęcie</label>
                    <input type="file" name="image" accept="image/png,image/gif,image/jpeg,image/jpg" required>
                    @error('image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field button">
                    <input type="submit" value="Zarejestruj się">
                </div>
            </form>
            <div class="link">Masz już konto? <a href="{{ route('login') }}">Zaloguj się!</a></div>
        </section>
    </div>
@endsection
