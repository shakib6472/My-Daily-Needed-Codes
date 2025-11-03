<?php
/**
 * Filter Elementor query to return only LearnDash courses
 * the current user is enrolled in, based on usermeta keys:
 * "course_{course_id}_access_from"
 */
function my_course_query( $query ) {
    // 1) If user is not logged in, return no results
    $user_id = get_current_user_id();
    if ( ! $user_id ) {
        // Return nothing by forcing a non-matching post__in
        $query->set( 'post__in', array( 0 ) );
        return;
    }

    // 2) Pull all user meta and extract course IDs from keys like "course_{ID}_access_from"
    $all_meta = get_user_meta( $user_id ); // returns [meta_key => [values]]
    $course_ids = array();

    foreach ( $all_meta as $meta_key => $values ) {
        // Match keys like "course_123_access_from"
        if ( preg_match( '/^course_(\d+)_access_from$/', $meta_key, $m ) ) {
            $course_id = absint( $m[1] );

            // If meta has a non-empty value, consider enrolled
            // (LearnDash stores a timestamp; ensure it exists and is truthy)
            $has_value = ! empty( $values ) && ! empty( $values[0] );
            if ( $course_id && $has_value ) {
                $course_ids[] = $course_id;
            }
        }
    }

    // 3) If no enrolled courses, return empty result
    if ( empty( $course_ids ) ) {
        $query->set( 'post__in', array( 0 ) );
        return;
    }

    // 4) Ensure we're querying courses and limit to enrolled IDs
    // If your Elementor widget already sets post_type, you can omit the next line.
    $query->set( 'post_type', 'sfwd-courses' );

    // Constrain to enrolled course IDs
    $query->set( 'post__in', array_values( array_unique( $course_ids ) ) );

    // Optional: keep current ordering; but if you want "most recently accessed first",
    // uncomment the next two lines to sort by meta_value of access_from (not perfect since it's usermeta)
    // $query->set( 'orderby', 'post__in' ); // keep Elementor order same as our list
    // $query->set( 'order', 'DESC' );
}
add_action( 'elementor/query/mycourses', 'my_course_query' );
