function lesson_query($query)
    {
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

 add_action('elementor/query/lessonforcourse', 'lesson_query');
