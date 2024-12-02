<div class="tab-pane fade" id="my-class" role="tabpanel" aria-labelledby="other-tab">
    <h3>Lista uczniów w mojej klasie:</h3>
    <div class="users-list">
        @foreach ($students as $student)
            <a href="{{ route('chat.show', $student->id) }}" class="user">
                <div class="content">
                    <img src="{{ asset('images/' . $student->image) }}" alt="{{ $student->fname . ' ' . $student->lname }}" style="width: 25px; height: 25px;">
                    <div class="details">
                        <span>{{ $student->fname . ' ' . $student->lname }}</span>
                        <p>
                            <span class="status-indicator {{ $user->status == 1 ? 'online' : 'offline' }}"></span>
                            {{ $user->status == 1 ? 'Online' : 'Offline' }}
                        </p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
