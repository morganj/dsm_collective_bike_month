<div class="event-container">

    <div class="title-container">
        <p class="event-date">
            <?php echo tribe_get_start_date(); ?>
            <?php if(tribe_get_end_time())
                echo ' - '.tribe_get_end_time();
            ?>
        </p>
        <h1 class="event-title"><?php the_title(); ?></h1>
        <p class="event-location"><?php echo tribe_get_venue() ?></p>
    </div>

    <div class="intro-container">
        <p class="event-intro">
            <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
                <div class="tribe-events-single-event-description tribe-events-content">
            <?php the_content(); ?>
        </div>
        </p>
    </div>

    <div class="unlock-section">
        <img class="badge off" src="http://dannymaller.com/wp-content/uploads/2016/03/Untitled-1.png">
    </div>

    <div class="social-section">
        <p class="social-text">Interested in this event? Attend on Facebook or Tweet it to your friends.</p>
        <div class="facebook-share"></div>
        <div class="twitter-share"></div>
    </div>
</div>