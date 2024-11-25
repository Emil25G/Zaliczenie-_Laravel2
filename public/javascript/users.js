document.addEventListener("DOMContentLoaded", () => {
    const searchBar = document.querySelector("#searchUser");
    const usersList = document.querySelector("#usersList");

    if (!searchBar || !usersList) {
        console.error("Element #searchUser lub #usersList nie został znaleziony.");
        return;
    }

    // Obsługa wyszukiwania w pasku
    searchBar.onkeyup = () => {
        let searchTerm = searchBar.value.trim();
        if (searchTerm !== "") {
            searchBar.classList.add("active");
        } else {
            searchBar.classList.remove("active");
        }

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/users/search", true);
        xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute("content"));
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    usersList.innerHTML = response.html;
                } catch (error) {
                    console.error("Błąd podczas parsowania odpowiedzi:", error);
                }
            }
        };

        xhr.onerror = () => console.error("Błąd podczas wysyłania żądania AJAX.");
        xhr.send("searchTerm=" + encodeURIComponent(searchTerm));
    };

    // Dynamiczne odświeżanie listy użytkowników co 5 sekund
    setInterval(() => {
        if (searchBar.classList.contains("active")) return; // Nie odświeżaj, jeśli pasek wyszukiwania jest aktywny

        let xhr = new XMLHttpRequest();
        xhr.open("GET", "/users/getUsers", true);

        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    usersList.innerHTML = response.html;
                } catch (error) {
                    console.error("Błąd podczas parsowania odpowiedzi:", error);
                }
            }
        };

        xhr.onerror = () => console.error("Błąd podczas pobierania listy użytkowników.");
        xhr.send();
    }, 5000); // Co 5 sekund
});
