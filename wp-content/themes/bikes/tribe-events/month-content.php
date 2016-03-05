<?php
/**
 * Month View Content Template
 * The content template for the month view of events. This template is also used for
 * the response that is returned on month view ajax requests.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/month/content.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<div id="tribe-events-content" class="tribe-events-month">

	<!-- Month Title -->
    <header>
        <div class="login">
            <?php if ( is_active_sidebar( 'calendar_widget' ) ) : ?>
                <?php dynamic_sidebar( 'calendar_widget' ); ?>
            <?php endif; ?>
        </div>
        <div>
            <?php do_action( 'tribe_events_before_the_title' ) ?>
            <h2 class="tribe-events-page-title"><?php tribe_events_title() ?></h2>
            <?php do_action( 'tribe_events_after_the_title' ) ?>
        </div>
    </header>

	<!-- Notices -->
	<?php tribe_the_notices() ?>

	<!-- Month Header -->
	<?php do_action( 'tribe_events_before_header' ) ?>
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>

		<!-- Header Navigation -->
		<?php tribe_get_template_part( 'month-nav' ); ?>

	</div>
	<!-- #tribe-events-header -->
	<?php do_action( 'tribe_events_after_header' ) ?>

	<!-- Month Grid -->
	<?php tribe_get_template_part( 'month/loop', 'grid' ) ?>

    <a href="http://challenge.bikemonthiowa.com/" rel="attachment wp-att-2643">
        <img src="http://dsmbikecollective.org/wp-content/uploads/2016/03/BIKE-COMMUTER-green-222x300.png" alt="BIKE-COMMUTER-green" width="222" height="300" class="aligncenter size-medium wp-image-2643" />
    </a>

    <a href=“dsmbikecollective.org/virtual-passport-sponsors/" rel="attachment wp-att-2643”>Thanks to all of our sponsors!</a>

	<!-- Month Footer -->
	<?php do_action( 'tribe_events_before_footer' ) ?>
	<div id="tribe-events-footer">

		<!-- Footer Navigation -->
		<?php do_action( 'tribe_events_before_footer_nav' ); ?>
		<?php tribe_get_template_part( 'month/nav' ); ?>
		<?php do_action( 'tribe_events_after_footer_nav' ); ?>

	</div>
	<!-- #tribe-events-footer -->
	<?php do_action( 'tribe_events_after_footer' ) ?>

	<?php tribe_get_template_part( 'month/mobile' ); ?>
	<?php tribe_get_template_part( 'month/tooltip' ); ?>

</div><!-- #tribe-events-content -->
