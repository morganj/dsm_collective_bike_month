/**
 * Created by kim.spasaro on 3/4/16.
 */

jQuery(document).ready( function($){

    var eventCode = event_redeemer.event_code;
    var eventID = event_redeemer.event_id;
    var eventYear = event_redeemer.event_year;

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
                $('.event-not-redeemed').fadeOut(function(){
                    $('.event-redeemed').fadeIn();
                });
            },
            error: function(html){
                $('.event-code-error').text('There was an error processing your request').fadeIn();
            }

        });

    });
});
