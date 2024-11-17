@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <section class="form login">
            <header>Komunikator szkolny - logowanie</header>

            <div class="error-text">
                @if (session('error'))
                    <ul>
                        <li class="text-danger">{{ session('error') }}</li>
                    </ul>
                @endif

                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <form action="{{ route('login') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="field input">
                    <label for="email">Adres email</label>
                    <input type="email" id="email" name="email" placeholder="Podaj adres email" required value="{{ old('email') }}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field input">
                    <label for="password">Hasło</label>
                    <input type="password" id="password" name="password" placeholder="Podaj hasło" required>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Zaloguj się">
                </div>
            </form>

            <div class="link">Nie masz konta? <a href="{{ route('register') }}">Zarejestruj się!</a></div>
        </section>
    </div>
@endsection
