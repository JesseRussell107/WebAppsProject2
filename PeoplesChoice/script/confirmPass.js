function confirmPass() {
    var pass1 = document.getElementById("pass1").value;
    var pass2 = document.getElementById("pass2").value;
    if (pass1 !== pass2) {
        $(".error").remove();
        $("#resetTitle").append("<p class='error'>Passwords don't match</p>");
        $("#pass1").css("border-bottom", "1px solid red");
        $("#pass2").css("border-bottom", "1px solid red");
        return false;
    }
    else {
        return true;
    }
}