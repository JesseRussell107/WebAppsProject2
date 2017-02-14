/**
 * Validates form fields for onchoose and onsubmit events
 */

/**
 * Validates a telephone #
 * @returns {String}
 */
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
/**
 * Validates a cipher (i.e. alphabetic string)
 * @returns {String}
 */
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
/**
 * Validates the entire form and informs user on bad input
 * @returns {Boolean}
 */
function validateForm() {
    var tele = validateTele();
    var ciph = validateCipher();
    var text="";
    var teleV = true;
    var ciphV = true;
    if (tele!=="success"){
        text+=tele;
        teleV = false;
    }
    if (ciph!=="success"){
        text+=ciph;
        ciphV = false;
    }
    document.getElementById("response").innerHTML = text;
    return teleV&&ciphV;
}