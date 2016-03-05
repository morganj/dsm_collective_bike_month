/**
 * Created by kim.spasaro on 3/4/16.
 */

jQuery(document).ready( function($){

    console.log(event_redeemer.user_logged_in);

  if(event_redeemer != null) {

    var eventCode = event_redeemer.event_code;
    var eventID = event_redeemer.event_id;
    var eventYear = event_redeemer.event_year;
    var eventComplete = event_redeemer.event_status;
    var userValid = event_redeemer.user_valid;
    var userLoggedIn = event_redeemer.user_logged_in;

    var age, zipcode, selectVal;

    function checkFields(){
        var valid = true;

        age = $('#user-age');
        if(!age.val() || age.val().match(/\b[0-9]{1,2}\b/) == null){
            age.addClass('error');
            valid = false;
        }
        else{
            age.removeClass('error');
        }


        zipcode = $('#user-zipcode');
        if(!zipcode.val() || zipcode.val().match(/\b[0-9]{5}\b/) == null){
            zipcode.addClass('error');
            valid = false;
        }
        else{
            zipcode.removeClass('error');
        }

        var select = $('#user-gender');
        selectVal = $('#user-gender option:selected').val();
        if(selectVal == "Select"){
            select.addClass('error');
            valid = false;
        }
        else{
            select.removeClass('error');
        }
        return valid;
    }

    $('#unlock-button').click(function(){

        if(userLoggedIn == 0){
            $('#user-register').fadeIn();

            $('#user-register .cancel-button').click(function(){
                $('#user-register').fadeOut();
            });

            return;
        }

        if(!userValid){
            $('#user-modal').fadeIn();

            $('#submit-button').click(function(){
                if(!checkFields())
                    return;

                $.ajax({
                    url: event_redeemer.ajax_url,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        action: 'bikes_submit_user_data',
                        user_age: age.val(),
                        user_gender: selectVal,
                        user_zipcode: zipcode.val(),
                        user: $('input[name="current-user"]').val()
                    },
                    success: function(html) {
                        userValid = true;
                        console.log(html);
                        $('#confirmation').fadeIn(function(){
                            $('#user-modal').fadeOut();
                        });
                    },
                    error: function(html){
                        console.log('error');
                    }

                });
            });

            $('#user-modal .cancel-button').click(function(){
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
            url: '/wp-admin/admin-ajax.php',
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
