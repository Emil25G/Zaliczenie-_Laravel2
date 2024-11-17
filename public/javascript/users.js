// Obsługa wpisywania w pasku wyszukiwania
searchBar.onkeyup = () => {
    let searchTerm = searchBar.value;
    if (searchTerm != "") {
        searchBar.classList.add("active");
    } else {
        searchBar.classList.remove("active");
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/users/search", true);
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            const response = JSON.parse(xhr.response); // Parsuj odpowiedź JSON
            usersList.innerHTML = response.html; // Wstaw HTML
        }
    };
    xhr.send("searchTerm=" + searchTerm);
};

// Dynamiczne pobieranie listy użytkowników
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/users/getUsers", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            const response = JSON.parse(xhr.response); // Parsuj odpowiedź JSON
            if (!searchBar.classList.contains("active")) { // Tylko wtedy, gdy pasek wyszukiwania nie jest aktywny
                usersList.innerHTML = response.html; // Wstaw HTML
            }
        }
    };
    xhr.send();
}, 5000); // Odświeżanie listy użytkowników co 5 sekund
