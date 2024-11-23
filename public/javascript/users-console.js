document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.querySelector("#index-catalog tbody");

    // Funkcja dodawania nowego wiersza
    document.querySelector("#addRow").addEventListener("click", (event) => {
        event.preventDefault();

        const row = document.createElement("tr");

        row.innerHTML = `
            <td><input type="text" class="form-control" name="index[]" placeholder="Indeks"></td>
            <td><input type="text" class="form-control" name="class[]" placeholder="Klasa (np. 1A)"></td>
            <td><input type="text" class="form-control" name="status[]" value="0" readonly></td>
            <td>
                <button class="btn btn-danger btn-sm removeRow">Usuń</button>
            </td>
        `;

        tableBody.appendChild(row);

        // Usuwanie wiersza
        row.querySelector(".removeRow").addEventListener("click", () => {
            row.remove();
        });
    });

    // Funkcja do importowania pliku CSV
    document.querySelector("#importCSV").addEventListener("click", (event) => {
        event.preventDefault();

        const fileInput = document.querySelector("#csvFileInput");
        fileInput.click();
    });

    document.querySelector("#csvFileInput").addEventListener("change", function() {
        const file = this.files[0];
        if (!file) {
            alert("Proszę wybrać plik CSV.");
            return;
        }

        const reader = new FileReader();
        reader.onload = function(event) {
            const csvData = event.target.result;
            const users = parseCSV(csvData);

            // Wstawianie danych do tabeli
            users.forEach(user => {
                const row = document.createElement("tr");

                row.innerHTML = `
                    <td><input type="text" class="form-control" name="index[]" value="${user.index}" readonly></td>
                    <td><input type="text" class="form-control" name="class[]" value="${user.class}" readonly></td>
                    <td><input type="text" class="form-control" name="status[]" value="${user.status}" readonly></td>
                    <td>
                        <button class="btn btn-danger btn-sm removeRow">Usuń</button>
                    </td>
                `;

                tableBody.appendChild(row);

                // Usuwanie wiersza
                row.querySelector(".removeRow").addEventListener("click", () => {
                    row.remove();
                });
            });
        };
        reader.readAsText(file);
    });

    // Funkcja do parsowania CSV na obiekty
    function parseCSV(csvData) {
        const rows = csvData.split("\n");
        const result = [];

        rows.slice(1).forEach(row => {
            const columns = row.split(/[,;]/);
            if (columns.length === 3) {
                result.push({
                    index: columns[0].trim(),
                    class: columns[1].trim(),
                    status: columns[2].trim() || "0",
                });
            }
        });
        return result;
    }

    // Funkcja do zapisywania użytkowników
    document.querySelector("#saveUsers").addEventListener("click", function(event) {
        event.preventDefault();

        const rows = Array.from(tableBody.querySelectorAll("tr"));
        const users = rows.map(row => ({
            index: row.querySelector("input[name='index[]']").value,
            class: row.querySelector("input[name='class[]']").value,
            status: row.querySelector("input[name='status[]']").value,
        }));

        // Dodanie danych do formularza przed wysłaniem
        const form = document.querySelector("#index-catalog");
        const usersInput = document.createElement("input");
        usersInput.type = "hidden";
        usersInput.name = "users";
        usersInput.value = JSON.stringify(users);
        form.appendChild(usersInput);

        // Wyślij formularz
        form.submit();
    });
});
