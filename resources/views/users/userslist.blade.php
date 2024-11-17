<div class="tab-pane-user-list fade" id="my-class" role="tabpanel" aria-labelledby="other-tab">
    <h3>Lista użytkowników:</h3>
    <div class="table-responsive">
        <table class="user-list-table table-sm">
            <thead>
            <tr>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Email</th>
                <th>Akcje</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->fname }}</td>
                    <td>{{ $student->lname }}</td>
                    <td>{{ $student->email }}</td>
                    <td>
                        <!-- Link do edycji użytkownika -->
                        <a href="" class="btn btn-primary btn-sm">Edytuj</a>

                        <!-- Link do usuwania użytkownika z potwierdzeniem -->
                        <form action="{{ route('users.destroy', $student->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?')">Usuń</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
