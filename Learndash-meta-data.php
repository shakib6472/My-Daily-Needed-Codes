<?php 
    /**
     * Shortcode to display LearnDash meta data
     * @param mixed $attrs
     * Shortcode Style - [emedi_learndash_meta_data field="meta_key"]
     */
  function learndash_meta_data_shortcode($attrs)
    {
        $attrs = shortcode_atts([
            'field' => '',
        ], $attrs);

        $course_id = get_the_ID();
        $field = $attrs['field'];

        // Fetch the LearnDash meta data based on the field
        $all_meta_value = get_post_meta($course_id, '_sfwd-courses', true);
        $target_meta_value = $all_meta_value[$field] ?? '';

        return $target_meta_value;
    }

  add_shortcode('emedi_learndash_meta_data', 'learndash_meta_data_shortcode');



?>
