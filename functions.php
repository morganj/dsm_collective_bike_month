<?php

include 'includes/event-redeemer/event-redeemer.php';

function dsmbc_event_args ($args){
  $args['rest_base'] = 'tribe_events';
  $args['rest_controller_class'] = 'WP_REST_Posts_Controller';
  $args['show_in_rest'] = true;
  return $args; 
}

add_filter('tribe_events_register_event_type_args', 'dsmbc_event_args');
