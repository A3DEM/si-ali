async function login() {
    const USERNAME = document.querySelector("#username").value;
    const PASSWORD = document.querySelector("#password").value;
    const RESPONSE = await fetch(`php/login.php?username=${USERNAME}&password=${PASSWORD}`);

    if (!response?.json()) {
        throw 'Une erreur est survenue'
    }
    if ()
}