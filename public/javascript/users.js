document.addEventListener("DOMContentLoaded", () => {
    const searchBar = document.querySelector("#searchUser");
    const usersList = document.querySelector("#usersList");
    let users = usersList.querySelectorAll(".user");

    if (!searchBar || !usersList) {
        return;
    }

    searchBar.addEventListener("keyup", () => {
        const searchTerm = searchBar.value.toLowerCase().trim();

        users.forEach(user => {
            const userName = user.querySelector(".details span").textContent.toLowerCase();
            if (userName.includes(searchTerm)) {
                user.style.display = "";
            } else {
                user.style.display = "none";
            }
        });

        if (searchTerm !== "") {
            searchBar.classList.add("active");
        } else {
            searchBar.classList.remove("active");
        }
    });

    const refreshInterval = setInterval(() => {
        if (searchBar.value.trim() !== "") return;

        let xhr = new XMLHttpRequest();
        xhr.open("GET", "/users/getUsers", true);

        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    usersList.innerHTML = response.html;

                    users = usersList.querySelectorAll(".user");
                } catch (error) {
                }
            }
        };

        xhr.onerror = () => {};
        xhr.send();
    }, 100000);
});
