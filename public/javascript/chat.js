const messageForm = document.querySelector('.typing-area');
const messageInput = messageForm.querySelector('.input-field');
const incomingIdInput = messageForm.querySelector('.incoming_id');
const sendButton = messageForm.querySelector('button');

const loggedInUserId = document.querySelector('meta[name="logged-in-user-id"]').getAttribute('content');
function sendMessage() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/savePrivate", true);
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = () => {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                messageInput.value = "";
            } else {
                alert(response.message);
            }
        }
    };

    const msg = messageInput.value;
    const incomingId = incomingIdInput.value;
    xhr.send("msg=" + encodeURIComponent(msg) + "&incoming_msg_id=" + encodeURIComponent(incomingId));
}

messageForm.onsubmit = (e) => {
    e.preventDefault();
    sendMessage();
};


sendButton.addEventListener('click', (e) => {
    e.preventDefault();
    sendMessage();
});

function fetchPrivateMessages() {
    const userId = incomingIdInput.value;
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `/getPrivateMessages/${userId}`, true);

    xhr.onload = () => {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                const messagesContainer = document.querySelector('.chat-box');
                messagesContainer.innerHTML = "";

                response.messages.forEach(msg => {
                    const isOutgoing = (msg.outgoing_msg_id == loggedInUserId);
                    const messageClass = isOutgoing ? 'outgoing' : 'incoming';

                    messagesContainer.innerHTML += `
                        <div class="chat ${messageClass}">
                            <div class="details">
                                <p>${msg.msg}</p>
                                <small>${new Date(msg.created_at).toLocaleString()}</small> <!-- Wyświetl datę i godzinę -->
                            </div>
                        </div>`;
                });
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            } else {
                console.error(response.message);
            }
        } else {
            console.error('Error fetching messages');
        }
    };

    xhr.send();
}

setInterval(fetchPrivateMessages, 1000);
fetchPrivateMessages();
