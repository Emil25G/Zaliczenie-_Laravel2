@extends('layouts.app') <!-- Assuming you have a layout file -->

@section('content')
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <?php
                $user_id = $user->id; // ID użytkownika, z którym rozmawiamy
                ?>
                <a href="{{ route('users.index') }}" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="{{ asset('images/' . $user->image) }}" alt="">
                <div class="details">
                    <span>{{ $user->fname . ' ' . $user->lname }}</span>
                    <p>{{ $user->status }}</p>
                </div>
            </header>
            <div class="chat-box">
                <!-- Wiadomości będą ładowane tutaj -->
            </div>
            <form action="#" class="typing-area">
                <input type="text" class="incoming_id" name="incoming_id" value="{{ $user_id }}" hidden>
                <input type="text" name="message" class="input-field" placeholder="Napisz wiadomość..." autocomplete="off">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>

    <script src="{{ asset('javascript/chat.js') }}"></script> <!-- Skrypt do obsługi czatu -->
@endsection
