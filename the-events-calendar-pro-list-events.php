<?php

/*
 * Plugin Name: Events Calendar PRO List Events
 * Description: Display Events from Events Calendar Pro in list via a shortcode
 * Version: 1.0
 * Author: 11 Online
 * Author URI: https://11online.us
 */

// Add Shortcode
function si66_events_list_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'cat' => '',
        'start_date' => '',
        'end_date' => '',
        'limit' => 20,
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
    //var_dump($posts);

    if($posts) {
        $output = '';
        $output .= '<ul>';

        foreach($posts as $post) {
            setup_postdata( $post );
            //var_dump($post);
            $event_output = '';
            $event_output .= '<li>';
            $event_output .= '<h4 class="entry-title summary">';
            $event_output .= '<a href="' . tribe_get_event_link($post) . '">' .  get_the_title($post) . '</a>';
            $event_output .= '</h4>';
            $event_output .= '</li>';
            $output .= $event_output;
        }
        $output .='</ul>';

        wp_reset_query();

        return $output;
    }
}

add_shortcode( 'si66_events_list', 'si66_events_list_shortcode' );
