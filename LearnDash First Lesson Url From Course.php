
/**
 * Helper: Get first lesson ID of a LearnDash course
 */
function mcd_get_first_lesson_id_simple( $course_id ) {
    if ( ! $course_id ) {
        return 0;
    }

    // Try LearnDash steps API (LD3 compatible)
    if ( function_exists( 'learndash_course_get_children_of_step' ) ) {
        $lessons = learndash_course_get_children_of_step( $course_id, $course_id, 'sfwd-lessons' );
        if ( ! empty( $lessons ) ) {
            $lesson_ids = array_values( $lessons );
            return absint( $lesson_ids[0] );
        }
    }

    // Fallback: query lessons by course_id
    $q = new WP_Query( array(
        'post_type'      => 'sfwd-lessons',
        'posts_per_page' => 1,
        'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
        'meta_query'     => array(
            array(
                'key'     => 'course_id',
                'value'   => $course_id,
                'compare' => '=',
                'type'    => 'NUMERIC',
            ),
        ),
        'post_status'    => 'publish',
        'no_found_rows'  => true,
        'fields'         => 'ids',
    ) );

    if ( ! empty( $q->posts ) ) {
        return absint( $q->posts[0] );
    }

    return 0;
}

/**
 * Shortcode: [course_first_lesson_url]
 * Always uses get_the_ID() as the course ID.
 */
function mcd_course_first_lesson_url_shortcode_simple() {
    $course_id = get_the_ID();
    $lesson_id = mcd_get_first_lesson_id_simple( $course_id );

    if ( ! $lesson_id ) {
        return '';
    }

    return esc_url( get_permalink( $lesson_id ) );
}
add_shortcode( 'course_first_lesson_url', 'mcd_course_first_lesson_url_shortcode_simple' );
