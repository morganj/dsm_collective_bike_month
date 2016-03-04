/**
 * Created by kim.spasaro on 3/4/16.
 */

jQuery(document).ready( function($){

    $('#click-button').click(function(){
        $.ajax({
            url: 'http://localhost:8888/bikes/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            data:{
                action: 'bikes_check_event',
                year: '2001',
                event: 'b'
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
