add_filter('body_class', function($classes) {
    if (is_singular(['courses', 'lesson', 'tutor_quiz'])) {
        global $post;

        // Tutor LMS থেকে course ID বের করা
        $course_id = tutor_utils()->get_course_id_by_content($post->ID);

        // কোর্সের মেটা ভ্যালু (যদি তুমি ACF বা ম্যানুয়াল মেটা ব্যবহার করো)
        $voice_toggle = get_post_meta($course_id, 'voiceover', true);

        // ডিফল্ট ভ্যালু 'off'
        if (empty($voice_toggle)) {
            $voice_toggle = 'off';
        }

        // body class যোগ করা
        if ($voice_toggle === 'ON') {
            $classes[] = 'voiceover-active';
        } else {
            $classes[] = 'voiceover-deactive';
        }
    }
    return $classes;
});
