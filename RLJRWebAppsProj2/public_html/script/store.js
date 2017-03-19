/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    $("#content, #left").sortable({
        connectWith: ".connectedSortable"
    }).disableSelection();
});

function addtocart() {
    $('#content > div').each(function (index, element) {
        if($("div > input").is(":checked")){
            $(this).appendTo("#left");
        }
    });
}


