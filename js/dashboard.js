async function disconnect() {
    try {
        const response = await fetch(`../php/disconnect.php`, {
            credentials: 'include'
        });
        const data = await response.json()
        if (data.response === "error") {
            console.log(data.message);
        }
        if (data.response === "success") {
            document.location.href = "../index.html"
        }
    }
    catch (e) {
        console.log(e)
    }
}

getData();

async function getData() {
    try {
        const response = await fetch(`../php/dashboard.php`, {
            credentials: 'include'
        });
        const data = await response.json()
        if (data.response === "error") {
            console.log(data.message);
            if (data.message === "Aucun compte connecte") {
                document.location.href = "../index.html"
            }
        }
        if (data.response === "success") {
            if (data.data.role !== "ROLE_ADMIN") {
                document.querySelector("#administration").remove();
                if (data.data.role !== "ROLE_MEMBER") {
                    document.querySelector("#management").remove();
                }
            }
        }
    }
    catch (e) {
        console.log(e)
    }
}



function showMessage(message) {
    document.querySelector(".message").innerText = message;
    document.querySelector(".message").classList.add("show");
}