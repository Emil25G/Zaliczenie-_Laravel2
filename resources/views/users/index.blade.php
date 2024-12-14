@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <section class="users">
            <header>
                <div class="content">
                    <img src="{{ asset('images/' . $user->image) }}" alt="{{ $user->fname . ' ' . $user->lname }}" style="width: 75px; height: 75px;">
                    <div class="details">
                        <span>{{ $user->fname . ' ' . $user->lname }}</span>
                        <p>
                            <span class="status-indicator {{ $user->status == 1 ? 'online' : 'offline' }}"></span>
                            {{ $user->status == 1 ? 'Online' : 'Offline' }}
                        </p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout btn btn-danger">Wyloguj się</button>
                    </form>
                </div>
            </header>

            <div class="search">
                <span class="text">Wyszukaj użytkownika...</span>
                <input type="text" id="searchUser" placeholder="Wpisz nazwę użytkownika...">
                <button id="searchButton"><i class="fas fa-search"></i></button>
            </div>

            <div class="users-list" id="usersList">
                @foreach ($users as $user)
                    <a href="{{ route('chat.show', $user->id) }}" class="user">
                        <div class="content">
                            <img src="{{ asset('images/' . $user->image) }}" alt="{{ $user->fname . ' ' . $user->lname }}" style="width: 60px; height: 60px;">
                            <div class="details">
                                <span>{{ $user->fname . ' ' . $user->lname }}</span>
                                <p>
                                    <span class="status-indicator {{ $user->status == 1 ? 'online' : 'offline' }}"></span>
                                    {{ $user->status == 1 ? 'Online' : 'Offline' }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <div class="right-panel">
            <div class="panel-header">
            </div>
            @if (auth()->user()->role == 'nauczyciel' || auth()->user()->role == 'admin')
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="announcements-tab" data-toggle="tab" href="#announcements" role="tab">Tablica ogłoszeń</a>
                    </li>
                    @if (auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link" id="other-tab" data-toggle="tab" href="#my-class" role="tab">Lista uczniów</a>
                    </li>
                    @elseif (auth()->user()->role == 'nauczyciel')
                        <li class="nav-item">
                            <a class="nav-link" id="other-tab" data-toggle="tab" href="#my-class" role="tab">Moja klasa</a>
                        </li>
                    @endif
                    @if (auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link" id="add-catalogs" data-toggle="tab" href="#add-new-users" role="tab">Katalog indeksów</a>
                    </li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="announcements" role="tabpanel" aria-labelledby="announcements-tab">
                        <h3>Dodaj ogłoszenie:</h3>
                        <div class="form-group">
                            <label for="comment">Wiadomość:</label>
                            <textarea class="form-control" rows="5" name="msg" id="msg"></textarea>
                        </div>
                        <input type="submit" name="save" class="btn send" value="Wyślij" id="butsave">
                        <h2>Tablica ogłoszeń:</h2>
                        <div id="MyTableContainer">
                            <table class="table" id="MyTable">
                                <tbody id="record"></tbody>
                            </table>
                        </div>
                        <link rel="stylesheet" href="{{ asset('css/group-msg-other.css') }}">
                    </div>
            @endif
                    @if (auth()->user()->role == 'uczeń')
                        <h2>Tablica ogłoszeń:</h2>
                        <table class="table" id="MyTable">
                            <tbody id="record"></tbody>
                        </table>
                        <link rel="stylesheet" href="{{ asset('css/group-msg-user.css') }}">
                    @endif
                    @if (auth()->user()->role == 'nauczyciel')
                        @include('users.classlist')
                    @elseif (auth()->user()->role == 'admin')
                        @include('users.userslist')
                        @include('users.add-users')
                    @endif
                </div>
            </div>
    </div>
@endsection

<script src="{{ asset('javascript/users.js') }}"></script>
<script src="{{ asset('javascript/group-chat.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

