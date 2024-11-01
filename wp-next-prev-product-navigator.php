<?php

/**
 * Plugin Name:       WP Next/Prev Product Navigator
 * Plugin URI:        http://wordpressmanaged.hosting/
 * Description:       This is a very light weight plugin which adds Next/Prev navigation to Woocoommerce products elegantly and responsively.
 * Version:           1.0.0
 * Author:            Miro N
 * Author URI:        http://minimalpink.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-next-prev-product-navigation
 */


/**
 * Register the plugin css 'wp_enqueue_scripts', which will be used for front end CSS.
 */
add_action( 'wp_enqueue_scripts', 'insert_nexprev_cat_names_css' );

/**
 * Enqueue plugin css-file
 */
function insert_nexprev_cat_names_css() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'insert_nexprev_cat_names', plugins_url('css/style.css', __FILE__) );
    wp_enqueue_style( 'insert_nexprev_cat_names' );
}

/**
 * The plugin functionality starts here.
 */

add_action('woocommerce_after_single_product', 'insert_nexprev_cat_names');

    function insert_nexprev_cat_names() {

    if ( ! is_product() ) {
        return;
    }
    // Do nothing if there's nowhere to navigate.
    $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( $same_cat, '', true );
    $next     = get_adjacent_post( $same_cat, '', false );

        // Do the magic if there is somewhere to navigate

    if ( ! $next && ! $previous ) {
        return;
    }

      echo '<nav class="product-navigator product-navigation ajaxify" role="navigation">';


            if ( is_attachment() ) :
            previous_post_link( '%link', __( '<span id="older-nav">Go back</span>' ) );
        else :
            $prev_img = get_the_post_thumbnail( $previous->ID, 'thumbnail' );
            $next_img = get_the_post_thumbnail( $next->ID, 'thumbnail' );
            $prev_img = $prev_img ? '<span class="nav-image">' . $prev_img . '</span>' : '';
            $next_img = $next_img ? '<span class="nav-image">' . $next_img . '</span>' : '';
            previous_post_link( '%link', '<span id="older-nav">' . $prev_img . '<span class="outter-title"><span class="entry-title">' . get_the_title( $previous->ID ) . '</span></span></span>', $same_cat );
            next_post_link( '%link', '<span id="newer-nav">' . $next_img . '<span class="outter-title"><span class="entry-title">' . get_the_title( $next->ID ) . '</span></span></span>', $same_cat );
        endif;
      echo '</nav>';
}