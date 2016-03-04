/**
 * Created by kim.spasaro on 3/4/16.
 */

jQuery(document).ready( function($){

    var eventCode = event_redeemer.eventCode;
    var eventID = event_redeemer.eventID;
    var eventYear = event_redeemer.eventYear;

    $('#event-code-submit').click(function(){

        if($('#event-code').val() != eventCode){
            $('.event-code-error').text('Wrong code!').fadeIn(600);
            return;
        }

        $.ajax({
            url: 'http://localhost:8888/bikes/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            data:{
                action: 'bikes_check_event',
                eventYear: eventYear,
                eventID: eventID
            },
            success: function(html) {

                console.log('success');
            },
            error: function(html){
                console.log('error');
            }

        });

    });
});
