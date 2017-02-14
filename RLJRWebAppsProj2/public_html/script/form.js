function validateTele() {
    var text;
    var tele = document.phonecipher.tele.value;
    if(tele === ""){
        text = "Please enter a tele #<br/>";
        document.getElementById("tele").className = "badinput";
        return text;
    }
    var pos = tele.search(/^((((\d\-)?(\d{3}\-?))|(\((\d\-)?\d{3})\))?\d{3}\-?\d{4})$/);
    if (pos !== 0) {
        text = "Bad tele #: ex. 555-555-5555<br/>";
        document.getElementById("tele").className = "badinput";
        return text;
    }
    text = "success";
    document.getElementById("tele").className = "goodinput";
    return text;
}

function validateCipher() {
    var text;
    var ciph = document.phonecipher.cipher.value;
    if(ciph === ""){
        text = "Please enter some text<br/>";
        document.getElementById("cipher").className = "badinput";
        return text;
    }
    var pos = ciph.search(/^([a-zA-Z]*\D*)$/);
    if (pos !== 0) {
        text = "Bad cipher: only letters are allowed<br/>";
        document.getElementById("cipher").className = "badinput";
        return text;
    }
    text = "success";
    document.getElementById("cipher").className = "goodinput";
    return text;
}

function validateForm() {
    var tele = validateTele();
    var ciph = validateCipher();
    var text="";
    if (tele!=="success"){
        text+=tele+"<br/>";
    }
    if (ciph!=="success"){
        text+=ciph;
    }
    document.getElementById("response").innerHTML = text;
}