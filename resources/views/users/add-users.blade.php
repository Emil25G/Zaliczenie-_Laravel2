<div class="tab-pane fade" id="add-new-users" role="tabpanel" aria-labelledby="add-catalogs">
    <table id="index-catalog" class="table table-bordered">
        <thead>
        <tr>
            <th>Indeks</th>
            <th>Klasa</th>
            <th>Status</th>
            <th>Akcje</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <button id="addRow" class="btn btn-success mb-3">Dodaj katalog</button>
    <button id="importCSV" class="btn btn-primary mb-3">Importuj katalog</button>
    <form id="userForm" action="{{ route('users.save') }}" method="POST">
        @csrf
        <button id="saveUsers" class="btn btn-primary mb-3">Zapisz rekordy</button>
        <input type="file" id="csvFileInput" style="display:none;" accept=".csv">
        <input type="hidden" id="usersData" name="users">
    </form>
    <link rel="stylesheet" href="{{ asset('css/index-catalog-style.css') }}">
    <script src="{{ asset('javascript/users-console.js') }}"></script>
</div>

