$(document).ready(function() {
    isLoggedIn = sessionStorage.getItem("isLoggedIn");
    
    if (isLoggedIn === "true") {
        document.getElementById("sign-in-btn").style.display = "none";
        document.getElementById("sign-up-btn").style.display = "none";
        document.getElementById("book-an-appointment-btn").style.display = "inline-block";
        document.getElementById("logout-btn").style.display = "inline-block";
        document.getElementById("hello-message").innerText = "Hello " + sessionStorage.getItem("first_name");
    } else {
        document.getElementById("sign-in-btn").style.display = "inline-block";
        document.getElementById("sign-up-btn").style.display = "inline-block";
        document.getElementById("book-an-appointment-btn").style.display = "none";
        document.getElementById("logout-btn").style.display = "none";
    }
});
