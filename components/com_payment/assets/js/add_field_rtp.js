$(function() {
    $("#name").change(function() {
        upateCompanyName();
        calTotal();
    });
    $("#company").change(function() {
        upateCompanyName();
        calTotal();
    });
    $("select[name=options1]").change(function() {
        $("#addinput1").empty();
        updateTotal1();
        //sum total
        var cost1 = parseInt($('#costs1').val());
        var cost2 = parseInt($('#costs2').val());
        //   var result = cost1 + cost2;
        var result = cost2;
        $("#total").val(result);
    });
    updateTotal1();
    $("select[name=options2]").change(function() {
        $("#addinput2").empty();
        updateTotal2();
        //sum total
        calTotal();
    });
    updateTotal2();
    calTotal();
});
function calTotal() {
    var cost2 = parseInt($('#costs2').val());
    var result = cost2;
    $("#total").val(result);
}
function upateCompanyName() {
    $("#num1").val($("#name").val());
    $("#pers_company1").val($("#company").val());
}
//for member
function updateTotal1() {
    var newTotal4add_field = 0;
    var newTotal1 = 0;
    var price = 1;
    $("select[name=options1] option:selected").each(function() {
        newTotal4add_field = parseFloat($(this).data("value"));
        newTotal1 = parseFloat($(this).data("value")) * price;
    });
    $("#costs1").val(newTotal1);
    var startingNo = newTotal4add_field;
    var $node = "";
    for (varCount = 1; varCount <= startingNo; varCount++) {
        var displayCount = varCount;
        $node += '<p><label for="pers' + displayCount + '">' + displayCount + ' : Name : </label><input type="text" name="member[' + displayCount + '][name]" id="num' + displayCount + '"><label for="pers_company' + displayCount + '">Company: </label><input type="text" name="member[' + displayCount + '][company]" id="mem_company' + displayCount + '"></p>';
        //remove a textfield   
        $('#addinput1').on('click', '.removeVar', function() {
            $(this).parent().remove();
        });
    }
    // add them to the DOM
    $('#addinput1').append($node);
}
//for non-member
function updateTotal2() {
    var newTotal4add_field = 0;
    var newTotal2 = 0;
  //  var price = 125;
    var price = $('#non-member-price').val();
    $("select[name=options2] option:selected").each(function() {
        newTotal4add_field = parseFloat($(this).data("value"));
        newTotal2 = parseFloat($(this).data("value")) * price;
    });
    $("#costs2").val(newTotal2);
    var startingNo = newTotal4add_field;
    var $node = "";
    for (varCount = 1; varCount <= startingNo; varCount++) {
        var displayCount = varCount;
        $node += '<p><label for="pers' + displayCount + '">' + displayCount + ' : Name : </label><input type="text" class = "text required" name="non_mem[' + displayCount + '][name]" id="num' + displayCount + '"><label for="pers_company' + displayCount + '">Company: </label><input type="text" class = "text required" name="non_mem[' + displayCount + '][company]" id="pers_company' + displayCount + '"></p>';
        //remove a textfield   
        $('#addinput2').on('click', '.removeVar', function() {
            $(this).parent().remove();
        });
    }
    // add them to the DOM
    $('#addinput2').append($node);

    upateCompanyName();
}


$("input[name=info]").change(function() {
    if (this.checked) {
        $("input[name=x_first_name]").val($("input[name=firstname1]").val());
        $("input[name=x_last_name]").val($("input[name=lastname1]").val());
        $("input[name=x_address]").val($("input[name=address1]").val());
        $("input[name=x_city]").val($("input[name=city1]").val());
        $("input[name=x_state]").val($("input[name=state1]").val());
        $("input[name=x_zip]").val($("input[name=zip1]").val());
        $("#email").val($("#email1").val());
    } else {
        $("input[name=x_first_name]").val("");
        $("input[name=x_last_name]").val("");
        $("input[name=x_address]").val("");
        $("input[name=x_city]").val("");
        $("input[name=x_state]").val("");
        $("input[name=x_zip]").val("");
        $("#email").val("");
    }
});