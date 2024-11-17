var messageInput = document.querySelector('textarea[name="msg"]');
var regexPattern = /^.{1,500}$/;

var characterCount = document.createElement('div');
characterCount.textContent = '0/500';
characterCount.style.marginTop = '5px';
characterCount.style.color = 'gray';

messageInput.parentNode.insertBefore(characterCount, messageInput.nextSibling);

messageInput.addEventListener('input', function() {
    var message = messageInput.value;
    var messageLength = message.length;

    if (messageLength === 0) { // Dodatkowy warunek dla pustej wiadomości
        messageLength = 0;
    } else if (!regexPattern.test(message)) {
        messageInput.value = message.slice(0, 500);
        messageLength = 500;
        alert("Przekroczono limit znaków.");
    }

    characterCount.textContent = messageLength + '/500';
});

document.addEventListener('DOMContentLoaded', function() {
    var sendButton = document.querySelector('.Btn.send');
    if (sendButton) {
        sendButton.addEventListener('click', function() {
            var messageInput = document.querySelector('textarea[name="msg"]');
            if (messageInput) {
                messageInput.value = null;
                characterCount.textContent = '0/500';
            }
        });
    }
});