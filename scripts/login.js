function openLogin() {
    document.getElementById("login-popup").style.display = "block";
    let main = document.getElementById("main");
    main.style.pointerEvents = "none";
    main.style.filter = "blur(3px)";
    let header = document.getElementById("masthead");
    header.style.pointerEvents = "none";
    header.style.filter = "blur(3px)";
}

function closeLogin() {
    document.getElementById("login-popup").style.display = "none";
    let main = document.getElementById("main");
    main.style.pointerEvents = "auto";
    main.style.filter = "blur(0)";
    let header = document.getElementById("masthead");
    header.style.pointerEvents = "auto";
    header.style.filter = "blur(0)";
}

function openForgotPsw() {
    closeLogin();
    document.getElementById("forgotpw-popup").style.display = "block";
    let main = document.getElementById("main");
    main.style.pointerEvents = "none";
    main.style.filter = "blur(3px)";
    let header = document.getElementById("masthead");
    header.style.pointerEvents = "none";
    header.style.filter = "blur(3px)";
}

function closeForgotPsw() {
    document.getElementById("forgotpw-popup").style.display = "none";
    let main = document.getElementById("main");
    main.style.pointerEvents = "auto";
    main.style.filter = "blur(0)";
    let header = document.getElementById("masthead");
    header.style.pointerEvents = "auto";
    header.style.filter = "blur(0)";
}

function ValidateEmail(inputText) {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (inputText.match(mailformat)) {
        return true;
    }
    else {
        return false;
    }
}