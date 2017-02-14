function validateForm() {
    var success = true;
    var teletext = "";
    var ciphtext = "";
    var tele = document.phonecipher.tele.value;
    var cipher = document.phonecipher.cipher.value;
    if(tele === ""){
        teletext = "Please enter a tele #<br/>";
        document.getElementById("tele").className += " badinput";
        success = false;
    }
    if(cipher === ""){
        ciphtext = "Please enter a cipher";
        document.getElementById("cipher").className += " badinput";
        success = false;
    }
    var pos = tele.search(/^((((\d\-)?(\d{3}\-?))|(\((\d\-)?\d{3})\))?\d{3}\-?\d{4})$/);
    if (pos !== 0) {
        teletext = "Bad tele #: ex. 555-555-5555<br/>";
        document.getElementById("tele").className += " badinput";
        success = false;
    }
    var pos = tele.search(/^(\d*[^a-zA-Z]*|[a-zA-Z]*\D*)$/);
    if (pos !== 0) {
        ciphtext = "Bad cipher: either all alpha or all num";
        document.getElementById("cipher").className += " badinput";
        success = false;
    }
    var text;
    if (success === true) {
        text = "Thank you!";
    }
    else {
        var text = teletext + ciphtext;
    }
    document.getElementById("response").innerHTML = text;
}