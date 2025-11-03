
<?php 

function auto_enroll_member_in_course() {
    // Check if user is logged in
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        
        // Check if user has membership ID 2
        if (pmpro_hasMembershipLevel(1, $user_id) || pmpro_hasMembershipLevel(2, $user_id)) {
            $course_id = 437;
            // Check if user is not already enrolled in the course
            if (!tutor_utils()->is_enrolled($course_id, $user_id)) {
                // Enroll user in course ID 437
                $selected_id = $course_id; // Assuming course ID is used as $selected_id
                $order_id = null; // If you have an order ID, you can provide it here
                $student_id = $user_id;

                // Enroll user using tutor_utils()->do_enroll()
                $enrollment_result = tutor_utils()->do_enroll($selected_id, $order_id, $student_id);

                // Log the result for debugging
                error_log('Enrollment Result: ' . var_export($enrollment_result, true));
            }
        } else  if (pmpro_hasMembershipLevel(3, $user_id)) {
            $course_id = 231;
            // Check if user is not already enrolled in the course
            if (!tutor_utils()->is_enrolled($course_id, $user_id)) {
                // Enroll user in course ID 437
                $selected_id = $course_id; // Assuming course ID is used as $selected_id
                $order_id = null; // If you have an order ID, you can provide it here
                $student_id = $user_id;

                // Enroll user using tutor_utils()->do_enroll()
                $enrollment_result = tutor_utils()->do_enroll($selected_id, $order_id, $student_id);

                // Log the result for debugging
                error_log('Enrollment Result: ' . var_export($enrollment_result, true));
            }
        }
    }
}

add_action('init', 'auto_enroll_member_in_course');