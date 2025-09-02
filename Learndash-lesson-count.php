<?php 
/*
* Shortcode [emedi_course_lesson_count]
*/

function sh_get_course_lesson_count()
    {
        $course_id = get_the_ID();
        // 1) Fetch all lessons under this course
        $course_meta_key = 'ld_course_' . $course_id;
        $lesson_ids = get_posts([
            'post_type' => 'sfwd-lessons',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'fields' => 'ids',
            'meta_query' => [
                [
                    'key' => $course_meta_key,
                    'value' => $course_id,
                    'compare' => '='
                ]
            ],
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ]);

        $lesson_ids = array_map('intval', (array) $lesson_ids);
        $lesson_ids = array_values(array_unique($lesson_ids));

        if (!empty($lesson_ids)) {
            $total = count($lesson_ids);
            return $total;

        } else {
            return '0';
        }
    }


add_shortcode('emedi_course_lesson_count',  'sh_get_course_lesson_count');


?> 
