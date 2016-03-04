<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */ ?>


<?php while(have_posts()): the_post();?>

    <?php print_r(bikes_event_details()); ?>

<div id="event-redeemer" class="<?php echo bikes_event_classes(); ?>">
    <div class="event-not-redeemed">
        <input id="event-code" type="text">
        <button id="event-code-submit">Click Me!</button>
        <div class="event-code-error"></div>
    </div>
    <div class="event-redeemed">Event redeemed</div>
</div>

<?php endwhile; ?>



