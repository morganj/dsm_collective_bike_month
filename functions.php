<?php 


// Event content type will be created by plugin

// Create sponsored content
function create_bikes_sponsors() {
    $labels = array(
        'name' => __( 'Sponsors' ),
        'singular_name' => __( 'Sponsor' ),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'rewrite' => array('slug' => 'sponsor')
    );

    register_post_type( 'bikes_sponsor', $args);
}
add_action( 'init', 'create_bikes_sponsors' );


/**
 * Add the field current event field to REST API responses for posts read and write
 */
function bikes_register_event() {
    register_rest_field(
        'post',
        'event_'.get_the_ID(),
        array(
            'get_callback'    => 'bikes_get_event'.get_the_ID(),
            'update_callback' => 'bikes_update_event'.get_the_ID(),
            'schema'          => null,
        )
    );
}
add_action( 'rest_api_init', 'bikes_register_event'.get_the_ID());

/**
 * Handler for getting custom field data.
 *
 * @since 0.1.0
 *
 * @param array $object The object from the response
 * @param string $field_name Name of field
 * @param WP_REST_Request $request Current request
 *
 * @return mixed
 */
function bikes_get_event( $object, $field_name, $request ) {
    return get_the_author_meta('event_'.get_the_ID(), $object[ 'id' ], $field_name );
}

/**
 * Handler for updating custom field data.
 *
 * @since 0.1.0
 *
 * @param mixed $value The value of the field
 * @param object $object The object from the response
 * @param string $field_name Name of field
 *
 * @return bool|int
 */
function bikes_update_event( $value, $object, $field_name ) {
    if ( ! $value || ! is_string( $value ) ) {
        return;
    }

    //is update author meta the right function?
    return update_author_meta( $object->ID, $field_name, strip_tags( $value ) );
}