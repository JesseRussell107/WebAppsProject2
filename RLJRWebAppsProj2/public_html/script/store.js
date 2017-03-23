$(function () {
    $("#content, #left").sortable({
        connectWith: ".connectedSortable",
        items: "> div",
        scroll: false,
        update: function (event, ui) {
            var totcost = 0;
            var num = 0;
            $("#left > div").each(function (index, element) {
                var holder = $(this).find(".amount").text();
                totcost = totcost + parseFloat(holder.replace("$", ""));
                num = num + 1;
                $(this).children("input").attr("disabled", true);
            });
            $("#content > div").each(function (index, element) {
                $(this).children("input").attr("disabled", false);
            });
            $("#count").text("# items: " + num);
            $("#cost").text("Total Price: $" + Math.round(totcost * 100) / 100);
        }
    }).disableSelection();
});

function addtocart() {
    $('#content > div').each(function (index, element) {
        var thing = $(this);
        if (thing.children("input[type=checkbox]").is(":checked")) {
            thing.appendTo("#left");
            thing.children("input[type=checkbox]").attr("checked", false);
            thing.children("input[type=checkbox]").attr("disabled", true);
        }
    });
    var totcost = 0;
    var num = 0;
    $("#left > div").each(function (index, element) {
        var holder = $(this).find(".amount").text();
        totcost = totcost + parseFloat(holder.replace("$", ""));
        num = num + 1;
        $(this).children("input[type=checkbox]").attr("disabled", true);
    });

    $("#count").text("# items: " + num);
    $("#cost").text("Total Price: $" + Math.round(totcost * 100) / 100);
}



