$(function() {
    getnamencompany(); 
    $("select[name=options]").change(function() {
        $("#addinput").empty();
        updateTotal();
    });
    updateTotal();
    $("select[name=options]").change(function() {
        var value = $("#firstname1").val() + " " + $("#lastname1").val();

        $("#num1").val(value);
        var company = $("#company").val();
        $("#mem_company1").val(company);

    });
});

function updateTotal() {
    var newTotal4add_field = 0;
    var newTotal = 0;
   // var price = 20;
   // var price = 1;
      var price = $('#breakfast-price').val();
    $("select[name=options] option:selected").each(function() {
        newTotal4add_field = parseFloat($(this).data("value"));
        newTotal = parseFloat($(this).data("value")) * price;
    });
    $("#costs").val(newTotal);
    var startingNo = newTotal4add_field;
    var $node = "";
    for (varCount = 1; varCount <= startingNo; varCount++) {
        var displayCount = varCount;
        $node += '<p><label for="pers' + displayCount + '">' + displayCount + ' : Name : </label><input type="text" class="text required" name="member[' + displayCount + '][name]" id="num' + displayCount + '"><label for="pers_company' + displayCount + '">Company: </label><input type="text" class="text required" name="member[' + displayCount + '][company]" id="mem_company' + displayCount + '"></p>';

        //remove a textfield   
        $('#addinput').on('click', '.removeVar', function() {
            $(this).parent().remove();
        });
    }

    // add them to the DOM
    $('#addinput').append($node);
}

function getnamencompany() { 
    //get name
    $("input[name=firstname1]").keyup(function() {
        var value = $(this).val() + " " + $("#lastname1").val();
        $("#num1").val(value);
    })
  
    //get name
    $("input[name=lastname1]").keyup(function() {
        var value = $("#firstname1").val() + " " + $(this).val();
        $("#num1").val(value);
    })
            .keyup();
    //get company
    $("input[name=company]").keyup(function() {
        var value = $(this).val();
        $("#mem_company1").val(value);
    })
            .keyup();
}

$("input[name=info]").change(function() {
    if (this.checked) {
        $("input[name=x_first_name]").val($("input[name=firstname1]").val());
        $("input[name=x_last_name]").val($("input[name=lastname1]").val());
        $("input[name=x_address]").val($("input[name=address1]").val());
        $("input[name=x_city]").val($("input[name=city1]").val());
        $("input[name=x_state]").val($("input[name=state1]").val());
        $("input[name=x_zip]").val($("input[name=zip1]").val());
    } else {
        $("input[name=x_first_name]").val("");
        $("input[name=x_last_name]").val("");
        $("input[name=x_address]").val("");
        $("input[name=x_city]").val("");
        $("input[name=x_state]").val("");
        $("input[name=x_zip]").val("");
    }
});

$("#btnPrint").click(function() {
    var divContents = $("#dvContainer").html();
    var printWindow = window.open('', '', 'height=400,width=800');
    printWindow.document.write('<html>');
    printWindow.document.write('<head>');
    printWindow.document.write('<title>Order Detail</title>');
    printWindow.document.write('</head>');
    printWindow.document.write('<body >');
    printWindow.document.write(divContents);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
});
