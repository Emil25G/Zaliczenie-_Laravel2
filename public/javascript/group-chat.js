document.addEventListener('DOMContentLoaded', function () {
    const sendButton = document.getElementById('butsave');
    const messageInput = document.getElementById('msg');
    const record = document.getElementById('record');

    // Tylko ładowanie wiadomości niezależnie od formularza
    if (record) {
        loadMessages(); // Ładowanie wiadomości, jeśli kontener istnieje
    }

    // Sprawdzenie, czy elementy wysyłania wiadomości istnieją w DOM
    if (sendButton && messageInput) {
        sendButton.addEventListener('click', function (e) {
            e.preventDefault(); // Zapobiega przeładowaniu strony

            const message = messageInput.value.trim(); // Usunięcie białych znaków

            if (message) {
                fetch('/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ msg: message }) // Wysyłamy wiadomość jako JSON
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            messageInput.value = ''; // Wyczyść pole po wysłaniu wiadomości
                            loadMessages(); // Przeładuj wiadomości
                        } else {
                            console.error('Błąd podczas zapisywania wiadomości:', data.message);
                        }
                    })
                    .catch(error => console.error('Błąd:', error));
            }
        });
    }

    // Funkcja ładowania wiadomości
    function loadMessages() {
        fetch('/process')
            .then(response => response.json())
            .then(data => {
                record.innerHTML = ''; // Wyczyść stary rekord
                if (data.status === 'success') {
                    data.messages.forEach(msg => {
                        const newRow = document.createElement('tr');
                        newRow.innerHTML = `
                            <td>${msg.user}</td>
                            <td>${msg.message}</td>
                            <td>${new Date(msg.timestamp).toLocaleString()}</td>
                        `;
                        record.appendChild(newRow);
                    });
                }
            })
            .catch(error => console.error('Błąd:', error));
    }

    // Odświeżanie wiadomości co 2 sekundy
    setInterval(loadMessages, 2000);
});
