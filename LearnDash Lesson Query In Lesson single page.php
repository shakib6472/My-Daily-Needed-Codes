<?php
/**
 * Elementor custom query: attach lessons to current course even on single Lesson page
 */
function lesson_single_page_lesson_query($query) {
    // 1) Resolve $course_id first
    $course_id = 0; 
    if ( !empty($_SERVER['REQUEST_URI']) ) {
        $request_uri = wp_unslash( $_SERVER['REQUEST_URI'] ); // sanitize server var
        if ( preg_match( '#/courses/([^/]+)/#', $request_uri, $m ) ) {
            $course_slug = sanitize_title( $m[1] );
            // LearnDash course post type is usually 'sfwd-courses'
            $course_post = get_page_by_path( $course_slug, OBJECT, 'sfwd-courses' );
            if ( $course_post instanceof WP_Post ) {
                $course_id = (int) $course_post->ID;
            }
        }
    }

    // 3) If still not found (e.g., not on lesson or unexpected URL), bail gracefully
    if ( ! $course_id ) {
        return;
    }

   $meta_query = $query->get('meta_query');
        $course_id = get_the_ID();
        $course_meta_key = 'ld_course_' . $course_id;

        if (!$meta_query) {
            $meta_query = [];
        }

        // Append our meta query
        $meta_query[] = [
            'key' => $course_meta_key,
            'value' => $course_id,
            'compare' => '=' 
        ];
        $query->set('meta_query', $meta_query);

}
add_action('elementor/query/lessonforlessonpage', 'lesson_single_page_lesson_query');
