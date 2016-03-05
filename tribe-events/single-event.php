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

    <?php $complete = bikes_event_details()['event_status']; ?>
    <?php if(!$complete) $unlocked = 'unlock-copy sneaky'; else $unlocked = 'unlock-copy'; ?>
    <?php if($complete) $unlockable = 'unlockable sneaky'; else $unlockable = 'unlockable'; ?>

    <div class="unlock-section">
        <div class="badge-wrapper"><img class="event-badge off" src="http://dannymaller.com/wp-content/uploads/2016/03/Untitled-1.png"></div>
        <div id="unlockable" class="<?php echo $unlockable; ?>">
            <p class="unlock-copy">Each event has a badge. Unlock badges by getting the pass phrase from event staff and share them with your friends.</p>
            <input id="event-code" placeholder="Event Code" class="input-pill">
            <p id="code-error">Wrong code!</p>
            <div class="wrapper">
                <button id="unlock-button" class="green-pill pill">Get Badge</button>
            </div>
            <p id="confirmation">Thanks for the info. Don't forget to claim your badge!</p>
        </div>
        <p id="unlocked" class="<?php echo $unlocked; ?>">Congratulations! You earned the <b><i><?php the_title(); ?></i></b> badge!</p>
    </div>

    <div id="user-modal">
        <p>Please provide some information before redeeming your first badge!</p>
        <input type="text" id="user-age" class="input-pill" placeholder="age">
        <input type="text" id="user-zipcode" class="input-pill" placeholder="zipcode">
        <select id="user-gender" class="input-pill">
            <option value="omitted">Gender Omitted</option>
            <option value="female">Female</option>
            <option value="male">Male</option>
        </select>
        <div class="wrapper">
            <button id="submit-button" class="green-pill pill">Submit Info</button>
            <div class="wrapper"><button id="cancel-button" class="red-pill pill">Cancel</button></div>
        </div>
    </div>

    <div class="social-section">
        <p class="social-text">Interested in this event? Attend on Facebook or Tweet it to your friends.</p>
        <div class="facebook-share"></div>
        <div class="twitter-share"></div>
    </div>
</div>
