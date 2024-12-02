const messageForm = document.querySelector('.typing-area');
const messageInput = messageForm.querySelector('.input-field');
const incomingIdInput = messageForm.querySelector('.incoming_id');
const sendButton = messageForm.querySelector('button');

const loggedInUserId = document.querySelector('meta[name="logged-in-user-id"]').getAttribute('content');

function sendMessage() {
    const msg = messageInput.value;
    const incomingId = incomingIdInput.value;

    fetch('/savePrivate', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `msg=${encodeURIComponent(msg)}&incoming_msg_id=${encodeURIComponent(incomingId)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                messageInput.value = "";
            } else {
                alert(data.message);
            }
        });
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

    fetch(`/getPrivateMessages/${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const messagesContainer = document.querySelector('.chat-box');
                messagesContainer.innerHTML = "";

                data.messages.forEach(msg => {
                    const isOutgoing = (msg.outgoing_msg_id == loggedInUserId);
                    const messageClass = isOutgoing ? 'outgoing' : 'incoming';

                    messagesContainer.innerHTML += `
                        <div class="chat ${messageClass}">
                            <div class="details">
                                <p>${msg.msg}</p>
                                <small>${new Date(msg.created_at).toLocaleString()}</small>
                            </div>
                        </div>`;
                });

                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });
}

setInterval(fetchPrivateMessages, 1000);
fetchPrivateMessages();
