<?php

/*
 * Plugin Name: The Events Calendar PRO Simple List Events
 * Description: Display Events from Events Calendar Pro in list via a shortcode
 * Version: 1.0
 * Author: 11 Online
 * Author URI: https://11online.us
 * Plugin URI: https://github.com/11online/events-calendar-pro-simple-list-events
 */

// Add Shortcode
function ec_simple_events_list_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'cat' => '',
        'start_date' => '',
        'end_date' => '',
        'limit' => 20,
        'show_date_in_title' => false,
    ), $atts ) );

    // Category
    if ( !empty($atts['cat']) ) {
        if ( strpos( $atts['cat'], "," ) !== false ) {
            $atts['cats'] = explode( ",", $atts['cat'] );
            $atts['cats'] = array_map( 'trim', $atts['cats'] );
        } else {
            $atts['cats'] = array( trim( $atts['cat'] ) );
        }

        $atts['event_tax'] = array(
            'relation' => 'OR',
        );

        foreach ( $atts['cats'] as $cat ) {
            $atts['event_tax'][] = array(
                'taxonomy' => 'tribe_events_cat',
                'field' => 'name',
                'terms' => $cat,
            );
            $atts['event_tax'][] = array(
                'taxonomy' => 'tribe_events_cat',
                'field' => 'slug',
                'terms' => $cat,
            );
        }
    }

    $posts = tribe_get_events( array(
        'post_status' => 'publish',
        'posts_per_page' => $atts['limit'],
        'tax_query' => $atts['event_tax'],
        'start_date' => $atts['start_date'],
        'end_date'   => $atts['end_date']
    ));

    if($posts) {
        $output = '';
        $output .= '<ul>';

        foreach($posts as $post) {
            setup_postdata( $post );
            $event_output = '';
            $event_output .= '<li>';
            $event_output .= '<h4 class="entry-title summary">';
            if($show_date_in_title) {
            $event_output .= '<a href="' . tribe_get_event_link($post) . '">' .  get_the_title($post) . ' - ' . tribe_get_start_date($post, true, 'D M j g:i a', null) . '</a>';
            } else {
            $event_output .= '<a href="' . tribe_get_event_link($post) . '">' .  get_the_title($post) . '</a>';
            }
            $event_output .= '</h4>';
            $event_output .= '</li>';
            $output .= $event_output;
        }
        $output .='</ul>';

        wp_reset_query();

        return $output;
    }
}

add_shortcode( 'ec_simple_events_list', 'ec_simple_events_list_shortcode' );
