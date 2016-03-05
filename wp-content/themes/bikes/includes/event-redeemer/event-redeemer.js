/**
 * Created by kim.spasaro on 3/4/16.
 */

jQuery(document).ready( function($){

  if(event_redeemer != null) {

    var eventCode = event_redeemer.event_code;
    var eventID = event_redeemer.event_id;
    var eventYear = event_redeemer.event_year;
    var eventComplete = event_redeemer.event_status;
    var userValid = event_redeemer.user_valid;

    $('#unlock-button').click(function(){

        if(!userValid){
            $('#user-modal').fadeIn();

            $('#submit-button').click(function(){
                var age = $('#user-age');
                if(!age.val()){
                    age.addClass('error');
                    return;
                }
                else
                    age.removeClass('error');

                var zipcode = $('#user-zipcode');
                if(!zipcode.val()){
                    zipcode.addClass('error');
                    return;
                }
                else
                    zipcode.removeClass('error');

                $.ajax({
                    url: 'http://localhost:8888/bikes/wp-admin/admin-ajax.php',
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        action: 'bikes_submit_user_data',
                        user_age: age.val(),
                        user_gender: $('#user-gender option:selected').val(),
                        user_zipcode: zipcode.val()
                    },
                    success: function(html) {
                        userValid = true;
                        $('#confirmation').fadeIn(function(){
                            $('#user-modal').fadeOut();
                        });
                    },
                    error: function(html){
                        console.log('error');
                    }

                });
            });

            $('#cancel-button').click(function(){
                $('#user-modal').fadeOut();
            });
            return;
        }


        if($('#event-code').val() != eventCode){
            $('#event-code').addClass('error');
            $('#code-error').fadeIn();
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
                $('#unlockable').fadeOut(function(){
                    $('#unlocked').fadeIn();
                });
            },
            error: function(html){
                $('.event-code-error').text('There was an error processing your request').fadeIn();
            }

        });

    });
  }
});
