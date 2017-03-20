$(function () {
    $("#content, #left").sortable({
        connectWith: ".connectedSortable",
        items: "> div",
        scroll: false,
        update: function (event, ui) {
            var totcost = 0;
            var num = 0;
            $("#left > div").each(function (index, element) {
                var holder = $(this).find("#amount").text();
                totcost = totcost + parseFloat(holder.replace("$", ""));
                num = num + 1;
            });
            $("#count").text("# items: " + num);
            $("#cost").text("Total Price: $" + totcost);
        }
    }).disableSelection();
});

function addtocart() {
    $('#content > div').each(function (index, element) {
        if ($("div > input").is(":checked")) {
            $(this).appendTo("#left");
            $(this).children("input").attr("checked", false);
//            $(this).children("input").attr("disabled", true);
        }
    });
}

