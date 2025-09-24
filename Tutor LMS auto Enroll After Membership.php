<?php
/**
 * Auto-enroll user into ALL TutorLMS courses that share categories
 * mapped to the PMPro membership level they just received.
 *
 * Works on membership grant/level change via PMPro hooks.
 */

add_action('pmpro_after_change_membership_level', function ($level_id, $user_id, $cancel_level) {
    // Safety checks
    if (empty($level_id) || empty($user_id)) {
        return;
    }
    if (!function_exists('tutor_utils')) {
        return; // Tutor LMS not active
    }

    // Prevent re-entrant loops if the hook fires multiple times in a request
    $lock_key = 'mc_pmpl_enroll_lock_' . $user_id . '_' . $level_id;
    if (did_action($lock_key)) {
        return;
    }
    do_action($lock_key);

    mc_pmpl_enroll_user_for_level_courses((int) $user_id, (int) $level_id);
}, 10, 3);

/**
 * (Optional) Also run right after successful checkout.
 * This helps in cases where 'after_change_membership_level' is skipped by add-ons.
 */
add_action('pmpro_after_checkout', function ($user_id, $order) {
    if (empty($user_id) || empty($order) || empty($order->membership_id)) {
        return;
    }
    if (!function_exists('tutor_utils')) {
        return;
    }
    $level_id = (int) $order->membership_id;
    $lock_key = 'mc_pmpl_enroll_lock_' . $user_id . '_' . $level_id;
    if (did_action($lock_key)) {
        return;
    }
    do_action($lock_key);

    mc_pmpl_enroll_user_for_level_courses((int) $user_id, (int) $level_id);
}, 10, 2);

/**
 * Core: Enroll a user into all courses matching categories linked to a PMPro level.
 */
if (!function_exists('mc_pmpl_enroll_user_for_level_courses')) {
    function mc_pmpl_enroll_user_for_level_courses($user_id, $level_id) {
        global $wpdb;

        // 1) Get category term_ids mapped to this membership level
        $table = $wpdb->prefix . 'pmpro_memberships_categories';
        $term_ids = $wpdb->get_col($wpdb->prepare(
            "SELECT DISTINCT category_id FROM {$table} WHERE membership_id = %d",
            $level_id
        ));
        $term_ids = array_map('intval', (array) $term_ids);
        if (empty($term_ids)) {
            return; // No categories mapped to this level
        }

        // 2) Find ALL courses in those categories (Tutor default taxonomy: 'course-category')
        $courses = get_posts([
            'post_type'      => 'courses',
            'post_status'    => 'publish',
            'fields'         => 'ids',
            'nopaging'       => true,
            'tax_query'      => [
                [
                    'taxonomy' => 'course-category',
                    'field'    => 'term_id',
                    'terms'    => $term_ids,
                    'operator' => 'IN',
                ],
            ],
        ]);
        if (empty($courses)) {
            return;
        }

        // 3) Enroll the user into each course if not already enrolled
        foreach ($courses as $course_id) {
            // Skip if already enrolled
            if (tutor_utils()->is_enrolled($course_id, $user_id)) {
                continue;
            }

            // Mark this as membership-driven enroll so we can set status=completed
            $GLOBALS['mc_pmpl_membership_enrolling'] = true;

            // Enroll (no Woo/Order id needed)
            tutor_utils()->do_enroll($course_id, 0, $user_id);

            // Cleanup per-iteration to avoid leaking globals
            unset($GLOBALS['mc_pmpl_membership_enrolling']);
        }
    }
}

/**
 * Ensure membership-driven enrollments are 'completed' (not 'pending').
 */
add_filter('tutor_enroll_data', function ($data) {
    if (!empty($GLOBALS['mc_pmpl_membership_enrolling'])) {
        $data['post_status'] = 'completed';
    }
    return $data;
});
