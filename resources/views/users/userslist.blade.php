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
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $student->id }}">Edytuj</button>
                        <form action="{{ route('users.destroy', $student->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?')">Usuń</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="editModal{{ $student->id }}" data-backdrop="false" aria-labelledby="editModalLabel{{ $student->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $student->id }}">Edytuj użytkownika</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Zamknij">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('users.update', $student->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="fname">Imię</label>
                                        <input type="text" class="form-control" id="fname" name="fname" value="{{ $student->fname }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="lname">Nazwisko</label>
                                        <input type="text" class="form-control" id="lname" name="lname" value="{{ $student->lname }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $student->email }}" required>
                                    </div>

                                    <button type="submit" class="btn btn-success">Zapisz zmiany</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
