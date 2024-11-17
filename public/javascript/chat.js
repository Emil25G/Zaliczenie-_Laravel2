const messageForm = document.querySelector('.typing-area');
const messageInput = messageForm.querySelector('.input-field');
const incomingIdInput = messageForm.querySelector('.incoming_id');
const sendButton = messageForm.querySelector('button');

// Zmienna, która będzie zawierała ID aktualnie zalogowanego użytkownika
const loggedInUserId = document.querySelector('meta[name="logged-in-user-id"]').getAttribute('content');

// Funkcja wysyłania wiadomości
function sendMessage() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/savePrivate", true);
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = () => {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                messageInput.value = ""; // Wyczyść pole tekstowe
            } else {
                alert(response.message);
            }
        }
    };

    const msg = messageInput.value;
    const incomingId = incomingIdInput.value;
    xhr.send("msg=" + encodeURIComponent(msg) + "&incoming_msg_id=" + encodeURIComponent(incomingId));
}

// Obsługa wysyłania wiadomości przy Enter oraz przy kliknięciu przycisku
messageForm.onsubmit = (e) => {
    e.preventDefault(); // Zatrzymaj standardowe przesyłanie formularza
    sendMessage(); // Wywołanie funkcji wysyłania wiadomości
};

// Obsługa kliknięcia przycisku wysyłania
sendButton.addEventListener('click', (e) => {
    e.preventDefault(); // Zatrzymanie domyślnej akcji przycisku
    sendMessage(); // Wywołanie funkcji wysyłania wiadomości
});

// Funkcja do pobierania wiadomości prywatnych
function fetchPrivateMessages() {
    const userId = incomingIdInput.value; // Użyj ID użytkownika, z którym rozmawiasz
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `/getPrivateMessages/${userId}`, true);

    xhr.onload = () => {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                const messagesContainer = document.querySelector('.chat-box');
                messagesContainer.innerHTML = ""; // Wyczyść poprzednie wiadomości

                // Iteracja po wiadomościach
                response.messages.forEach(msg => {
                    // Sprawdź, czy wiadomość jest wysłana przez aktualnie zalogowanego użytkownika
                    const isOutgoing = (msg.outgoing_msg_id == loggedInUserId);
                    const messageClass = isOutgoing ? 'outgoing' : 'incoming'; // Wybór klasy CSS

                    // Generowanie HTML z odpowiednimi klasami CSS
                    messagesContainer.innerHTML += `
                        <div class="chat ${messageClass}">
                            <div class="details">
                                <p>${msg.msg}</p>
                                <small>${new Date(msg.created_at).toLocaleString()}</small> <!-- Wyświetl datę i godzinę -->
                            </div>
                        </div>`;
                });

                // Przewiń do dołu, aby zobaczyć najnowsze wiadomości
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            } else {
                console.error(response.message); // Zaloguj ewentualne błędy
            }
        } else {
            console.error('Error fetching messages'); // Obsługa błędów odpowiedzi
        }
    };

    xhr.send();
}

// Uruchamianie pobierania wiadomości co 1 sekundę
setInterval(fetchPrivateMessages, 1000);
fetchPrivateMessages();
