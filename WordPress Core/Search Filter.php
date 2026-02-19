add_action( 'pre_get_posts', 'restrict_search_to_courses_only' );

function restrict_search_to_courses_only( $query ) {

    // Modify only frontend main search query
    if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {

        $query->set( 'post_type', array( 'course' ) );

    }
}
