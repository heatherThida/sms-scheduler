/**
 *
 */
$(document).ready(function() {

    // jQuery UI Datepicker
    $(function() {
        $("#date").datepicker({
            //options go here
            showOtherMonths: true,
            selectOtherMonths: true,
            minDate: 0,
            maxDate: "+3M"
        });
        $("#anim").change(function() {
            $("#date").datepicker("option", "showAnim", $(this).val() )
        })
    });

    // process form data
    $('form').submit(function(event) {

        // get the form data
        var formData = {
            'to'            : $('input[name=to]').val(),
            'from'          : $('input[name=from]').val(),
            'message'       : $('input[name=message]').val(),
            'date'          : $('input[name=date]').val(),
            'hour'          : $('input[name=hour]').val(),
            'minute'          : $('input[name=minute]').val()
        };

        // process the form
        $.ajax({
            type        : 'POST',
            url         : 'sms.php',
            'data'      : formData,
            dataType    : 'json'
        })

        // Use the done promise callback
            .done(function(data) {
                // log data to console - just for test purposes
                console.log("Dumping data");
                console.log(data);

                // handle errors
            });

        // stop form from submitting the normal way and refresh page
        //event.preventDefault();
    });

});