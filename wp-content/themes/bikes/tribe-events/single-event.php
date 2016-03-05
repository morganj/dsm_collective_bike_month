<?php while(have_posts()): the_post(); ?>
<div class="event-container">
    <div class="title-container">
        <p class="event-date">
            <?php echo tribe_get_start_date(); ?>
            <?php if(tribe_get_end_time())
                echo ' - '.tribe_get_end_time();
            ?>
        </p>
        <h1 class="event-title"><?php the_title(); ?></h1>
        <?php if(tribe_get_venue() != 'Unnamed Venue'): ?>
            <p class="event-location"><?php echo tribe_get_venue(); ?></p>
        <?php endif; ?>
    </div>

    <div class="bm-wrapper">
        <div class="bm-header">
            <h3>Event Details</h3>
        </div>
        <div class="event-section bm-section">
            <div class="bm-image-wrapper">
                <?php $image = get_field('bike_month_event_logo'); ?>
                <?php if( !empty($image) ): ?>
                    <img class="bm-image" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                <?php endif; ?>
            </div>
            <div class="bm-text-wrapper">
                <div class="bm-text">
                    <?php echo get_the_content(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="bm-wrapper">
        <div class="bm-header">
            <h3>Featured Sponsor</h3>
        </div>
        <div class="sponsor-section bm-section">
            <div class="bm-image-wrapper">
                <?php $sponsor_image = get_field('bike_month_sponsor_logo'); ?>
                <?php if( !empty($sponsor_image) ): ?>
                    <img class="bm-image" src="<?php echo $sponsor_image['url']; ?>" alt="<?php echo $sponsor_image['alt']; ?>" />
                <?php endif; ?>
            </div>
            <div class="bm-text-wrapper">
                <div class="bm-text">
                    <?php the_field('bike_month_sponsor_blurb'); ?>
                </div>
            </div>
        </div>
    </div>

    <?php $complete = bikes_event_details()['event_status']; ?>
    <?php if(!$complete) $unlocked = 'unlock-copy bm-text sneaky'; else $unlocked = 'unlock-copy bm-text'; ?>
    <?php if($complete) $unlockable = 'unlockable sneaky'; else $unlockable = 'unlockable'; ?>

    <div class="unlock-section bm-section">
        <div class="bm-image-wrapper">
            <img class="bm-image" src="<?php echo get_stylesheet_directory_uri().'/assets/images/badge-locked.png' ?>">
        </div>
        <div class="bm-text-wrapper">
            <div id="unlockable" class="<?php echo $unlockable; ?>">
                <div class="unlock-copy bm-text">
                    Each event has a badge. Unlock badges by getting the pass phrase from event staff and share them with your friends.
                </div>
                <input id="event-code" placeholder="Event Code" class="input-pill">
                <p id="code-error">Wrong code!</p>
                <div class="wrapper">
                    <button id="unlock-button" class="green-pill pill">Get Badge</button>
                </div>
                <p id="confirmation">Thanks for the info. Don't forget to claim your badge!</p>
            </div>
        </div>
        <p id="unlocked" class="<?php echo $unlocked; ?>">Congratulations! You earned the <b><i><?php the_title(); ?></i></b> badge!</p>
    </div>

    <div id="user-register">
        <p>It looks like you're not logged!</p>
        <a href="/member-login"><button id="submit-button" class="green-pill pill">Log in or sign up here.</button></a>
        <button class="red-pill pill cancel-button">Cancel</button>
    </div>

    <div id="user-modal">
        <p>Please provide some information before redeeming your first badge!</p>
        <input type="hidden" name="current-user" value="<?php echo get_current_user_id(); ?>">
        <input type="text" id="user-age" class="input-pill" placeholder="age">
        <input type="text" id="user-zipcode" class="input-pill" placeholder="zipcode">
        <select id="user-gender" class="input-pill">
            <option>Select</option>
            <option value="female">Female</option>
            <option value="male">Male</option>
        </select>
        <div class="wrapper">
            <button id="submit-button" class="green-pill pill">Submit Info</button>
            <div class="wrapper"><button class="red-pill pill cancel-button">Cancel</button></div>
        </div>
    </div>

    <div class="social-section hidden">
        <p class="social-text">Interested in this event? Attend on Facebook or Tweet it to your friends.</p>
        <div class="facebook-share"></div>
        <div class="twitter-share"></div>
    </div>
</div>
<?php endwhile; ?>
