jQuery(document).ready(function() {

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // Comment or uncomment the result you want.
    // Currently, shake on error is enabled.
    // When a field is left blank, jQuery will shake the form

    /* Begin config */

    //	var shake = "Yes";
    var shake = "No";

    /* End config */


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////// Do not touch below /////////////////////////////////////////

    $('#message').hide();

    // Add validation parts
    $('#contact input[type=text], #contact input[type=number], #contact input[type=email], #contact input[type=url], #contact input[type=tel], #contact select, #contact textarea').each(function() {
        $(this).after('<mark class="validate"></mark>');
    });
    $('#contact input[type=card]').each(function() {
        $(this).after('<mark class="validate1"></mark>');
    });

    // Validate as you type
    $('#name, #comments, #subject,#security').focusout(function() {
        if (!$(this).val())
            $(this).addClass('error').parent().find('mark').removeClass('valid').addClass('error');
        else
            $(this).removeClass('error').parent().find('mark').removeClass('error').addClass('valid');
    });
    $('#email').focusout(function() {
        if (!$(this).val() || !isEmail($(this).val()))
            $(this).addClass('error').parent().find('mark').removeClass('valid').addClass('error');
        else
            $(this).removeClass('error').parent().find('mark').removeClass('error').addClass('valid');
    });

    $('#card').focusout(function() {
        var type = getCreditCardType($(this).val());

        switch (type)
        {
            case "mastercard":
                //show MasterCard icon
                if (!$(this).val())
                    $(this).addClass('error').parent().find('mark').removeClass('mc').addClass('error');
                else
                    $(this).removeClass('error').parent().find('mark').removeClass('error').removeClass('vs').removeClass('amex').removeClass('dis').addClass('mc');
                break;

            case "visa":
                //show Visa icon
                if (!$(this).val())
                    $(this).addClass('error').parent().find('mark').removeClass('vs').addClass('error');
                else
                    $(this).removeClass('error').parent().find('mark').removeClass('error').removeClass('mc').removeClass('amex').removeClass('dis').addClass('vs');
                break;

            case "amex":
                //show American Express icon
                if (!$(this).val())
                    $(this).addClass('error').parent().find('mark').removeClass('amex').addClass('error');
                else
                    $(this).removeClass('error').parent().find('mark').removeClass('error').removeClass('vs').removeClass('mc').removeClass('dis').addClass('amex');
                break;

            case "dis":
                //show American Express icon
                if (!$(this).val())
                    $(this).addClass('error').parent().find('mark').removeClass('dis').addClass('error');
                else
                    $(this).removeClass('error').parent().find('mark').removeClass('error').removeClass('vs').removeClass('mc').removeClass('amex').addClass('dis');
                break;
            default:
                $(this).addClass('error').parent().find('mark').removeClass('amex').removeClass('vs').removeClass('mc').removeClass('dis').addClass('error');
        }
    });

    $('#website').focusout(function() {
        var web = $(this).val();
        if (web && web.indexOf("://") == -1) {
            //$(this).addClass('error').parent().find('mark').removeClass('valid').addClass('error');
            $(this).val('http://' + web);
            $(this).removeClass('error').parent().find('mark').removeClass('error').addClass('valid');
        } else if (web)
            $(this).removeClass('error').parent().find('mark').removeClass('error').addClass('valid');
        else
            $(this).removeClass('error').parent().find('mark').removeClass('error').removeClass('valid');
    });
    $('#verify').focusout(function() {
        var verify = $(this).val();
        var verify_box = $(this);
        if (!verify)
            $(this).addClass('error').parent().find('mark').removeClass('valid').addClass('error');
        else {

            // Test verification code via ajax
            $.ajax({
                type: 'POST',
                url: 'verify/ajax_check.php',
                data: {verify: verify},
                async: false,
                success: function(data) {
                    if (data == 'success') {
                        $(verify_box).removeClass('error').parent().find('mark').removeClass('error').addClass('valid');
                    } else {
                        $(verify_box).addClass('error').parent().find('mark').removeClass('valid').addClass('error');
                    }
                }
            });

        }
    });

    $('#submit').click(function() {
        $("#message").slideUp(200, function() {
            $('#message').hide();

            // Kick in Validation
            $('#name, #subject, #phone, #comments, #website, #verify, #email').triggerHandler("focusout");

            if ($('#contact mark.error').size() > 0) {
                if (shake == "Yes") {
                    $('#contact').effect('shake', {times: 2}, 75, function() {
                        $('#contact input.error:first, #contact textarea.error:first').focus();
                    });
                } else
                    $('#contact input.error:first, #contact textarea.error:first').focus();

                return false;
            }

        });
    });
    
 $(document).ready(function(){
  $("#asb").click(function(){
    $("#street").hide(500);
    $("#csz").hide(500);
  });
  $("#dfb").click(function(){
    $("#street").show(500);
    $("#csz").show(500);
  });
});

    $('#contactform').submit(function() {

        if ($('#contact mark.error').size() > 0) {
            if (shake == "Yes") {
                $('#contact').effect('shake', {times: 2}, 75);
            }
            return false;
        }

        var action = $(this).attr('action');

        $('#submit')
                .after('<img src="assets/ajax-loader.gif" class="loader" />')
                .attr('disabled', 'disabled');

        $.post(action, {
            name: $('#name').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            website: $('#website').val(),
            subject: $('#subject').val(),
            comments: $('#comments').val(),
            verify: $('#verify').val()
        },
        function(data) {
            $('#message').html(data);
            $('#message').slideDown();
            $('#contactform img.loader').fadeOut('slow', function() {
                $(this).remove()
            });
            $('#contactform #submit').attr('disabled', '');
            if (data.match('success') != null)
                $('#contactform').slideUp('slow');

        }
        );

        return false;

    });

    function isEmail(emailAddress) {

        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

        return pattern.test(emailAddress);
    }

    function isNumeric(input) {
        return (input - 0) == input && input.length > 0;
    }

    function getCreditCardType(accountNumber)
    {

        //start without knowing the credit card type
        var result = "unknown";

        //first check for MasterCard
        if (/^5[1-5]/.test(accountNumber))
        {
            result = "mastercard";
        }

        //then check for Visa
        else if (/^4/.test(accountNumber))
        {
            result = "visa";
        }

        //then check for AmEx
        else if (/^3[47]/.test(accountNumber))
        {
            result = "amex";
        }
        
        else if (/^6/.test(accountNumber))
        {
            result = "dis";
        }

        return result;
    }

});