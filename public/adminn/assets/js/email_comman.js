//Common Event Trigger for emails app
$(document).ready(function() {
    var selectedItems = 0;
    //Table Row Click Event
    $('.clickable').click(function() {
        $('#inbox-wrapper').addClass('animated fadeOut');
        $('#inbox-wrapper').hide();
        $('#preview-email-wrapper').addClass('animated fadeIn ');
        $('#preview-email-wrapper').show();
        $('.page-title').show();
        //Load email details
        $('#inbox-wrapper').removeClass('animated fadeOut');
        $('#inbox-wrapper').removeClass('animated fadeIn');
    });

    // //Back Button Event
    // $('#btn-back').click(function() {
    //     $('#inbox-wrapper').addClass('animated fadeIn');
    //     $('#inbox-wrapper').show();
    //     $('#preview-email-wrapper').addClass('animated fadeOut');
    //     $('#preview-email-wrapper').hide();
    //     $('.page-title').hide();
    //     $('#preview-email-wrapper').removeClass('animated fadeIn ');
    //     $('#preview-email-wrapper').removeClass('animated fadeOut ');
    // });

    //Check box select Event
    //Trigger Quick bar
    $('#email-list .checkbox input').click(function() {
        if ($(this).is(':checked')) {
            selectedItems++;
            $(this).parent().parent().parent().toggleClass('row_selected');
        } else {
            selectedItems--;
            console.log(selectedItems);
            $(this).parent().parent().parent().toggleClass('row_selected');
        }
        console.log(selectedItems);
        if (selectedItems == 0) {
            $("#quick-access").css("bottom", "-115px");
        } else {
            $("#quick-access").css("bottom", "0px");
        }
    });

    //Adjust Page layout to condensed
    $('.page-content').css('margin-left', '50');

    //Quick action dismiss Event
    $('#quick-access .btn-cancel').click(function() {
        $("#quick-access").css("bottom", "-115px");
        $('#email-list .checkbox').children('input').attr('checked', false);
        $("#emails tbody tr").removeClass('row_selected');
        selectedItems = 0;
    });

});
