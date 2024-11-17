@if(count($users) > 0)
    @foreach($users as $user)
        <div class="user">
            <img src="{{ asset('images/' . $user->image) }}" alt="{{ $user->fname . ' ' . $user->lname }}" style="width: 50px; height: 50px;">
            <div class="details">
                <span>{{ $user->fname . ' ' . $user->lname }}</span>
                <p>{{ $user->status }}</p>
            </div>
        </div>
    @endforeach
@else
    <p>Brak innych użytkowników do wyświetlenia.</p>
@endif
