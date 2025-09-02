<?php 
/*
* Shortcode [emedi_course_quizz_count]
*/
 function sh_get_course_quizz_count()
    {
         $course_id = get_the_ID();
        // 1) Fetch all lessons under this course
        $course_meta_key = 'ld_course_' . $course_id;
        $quizz_ids = get_posts([
            'post_type' => 'sfwd-quiz',
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

        $quizz_ids = array_map('intval', (array) $quizz_ids);
        $quizz_ids = array_values(array_unique($quizz_ids));

        if (!empty($quizz_ids)) {
            $total = count($quizz_ids);
            return $total;

        } else {
            return '0';
        }
    }

 add_shortcode('emedi_course_quizz_count',  'sh_get_course_quizz_count');


?>
