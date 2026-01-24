<?php
/**
 * WooCommerce product search: title only (frontend + AJAX).
 * WP 6.2+ supports limiting search columns via 'post_search_columns'.
 */
add_filter( 'post_search_columns', 'shakib_wc_product_search_title_only', 10, 3 );

function shakib_wc_product_search_title_only( $search_columns, $search, $query ) {
	// Empty search? keep default.
	if ( empty( $search ) ) {
		return $search_columns;
	}

	$post_type  = $query->get( 'post_type' );
	$is_product = ( $post_type === 'product' ) || ( is_array( $post_type ) && in_array( 'product', $post_type, true ) );

	if ( ! $is_product ) {
		return $search_columns;
	}

	// Frontend OR AJAX (admin-ajax.php runs under is_admin()).
	if ( ! is_admin() || wp_doing_ajax() ) {
		return array( 'post_title' );
	}

	return $search_columns;
}
