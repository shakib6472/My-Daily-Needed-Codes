<?php
/**
 * Elementor custom query: attach lessons to current course even on single Lesson page
 */
function lesson_single_page_lesson_query($query) {
    // 1) Resolve $course_id first
    $course_id = 0; 
    if ( function_exists('learndash_get_course_id') ) {
        // get_queried_object_id() is safer than get_the_ID() inside this hook
        $current_id = get_queried_object_id();
        if ( $current_id ) {
            $course_id = (int) learndash_get_course_id( $current_id );
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
