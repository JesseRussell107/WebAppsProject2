function addWritein() {
    var template ="<div class=\"writein\">" + document.getElementById("writeintemplate").innerHTML + "</div>";
    var select = $("#writeintemplate > select").attr("name");
    var incr = parseInt(select) + 1;
    
    var orig = "<select name=\"" + select.toString();
    var nue = "<select name=\"" + incr.toString();
    var holder = template.replace(orig, nue);
    
    var origin = "<input name=\"writein1";
    var nuue = "<input name=\"writein" + incr.toString();
    var output = holder.replace(origin, nuue);
    
    $("#writeins").append(output + "<br>");
    $("#writein"+incr.toString()).val("");
    
    $("#writeintemplate > select").attr("name", incr.toString());
}


