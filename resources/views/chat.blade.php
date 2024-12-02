@extends('layouts.app')

@section('content')
    <meta name="logged-in-user-id" content="{{ Auth::user()->id }}">
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <a href="{{ route('users.index') }}" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="{{ asset('images/' . $user->image) }}" alt="{{ $user->fname . ' ' . $user->lname }}">
                <div class="details">
                    <span>{{ $user->fname . ' ' . $user->lname }}</span>
                    <p>
                        <span class="status-indicator {{ $user->status == 1 ? 'online' : 'offline' }}"></span>
                        {{ $user->status == 1 ? 'Online' : 'Offline' }}
                    </p>
                </div>
            </header>
            <div class="chat-box">
            </div>
            <form action="#" class="typing-area">
                <input type="text" class="incoming_id" name="incoming_id" value="{{ $user->id }}" hidden>
                <input type="text" name="message" class="input-field" placeholder="Napisz wiadomość..." autocomplete="off">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>
    <link rel="stylesheet" href="{{ asset('css/chat-style.css') }}">
    <script src="{{ asset('javascript/chat.js') }}"></script>
@endsection
