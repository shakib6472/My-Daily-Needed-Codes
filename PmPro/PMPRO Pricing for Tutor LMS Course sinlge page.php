<?php
/**
 * Render PMPro level buttons for TutorLMS single course, filtered by matching course categories.
 * Hide buttons entirely if the current user already has any matching level.
 * Tutor LMS
 *  Edumall Theme
 */

add_action('tutor_course/single/enroll_box/after_thumbnail', function () {
    if (!is_singular('courses')) {
        return;
    }
    if (!function_exists('pmpro_getAllLevels')) {
        return;
    }

    global $post, $wpdb;

    // 1) Gather course categories (Tutor default taxonomy).
    $terms = get_the_terms($post->ID, 'course-category');
    if (empty($terms) || is_wp_error($terms)) {
        return;
    }
    $term_ids = wp_list_pluck($terms, 'term_id');

    // 2) Map categories -> PMPro levels.
    $table = $wpdb->prefix . 'pmpro_memberships_categories';
    $placeholders = implode(',', array_fill(0, count($term_ids), '%d'));
    $sql = $wpdb->prepare(
        "SELECT DISTINCT membership_id 
         FROM {$table}
         WHERE category_id IN ($placeholders)",
        $term_ids
    );
    $level_ids = array_map('intval', (array) $wpdb->get_col($sql));

    if (empty($level_ids)) {
        return;
    }

    // ✅ NEW: If the logged-in user already has any of these levels, don't render buttons.
    // pmpro_hasMembershipLevel accepts an array of level IDs.
    if (is_user_logged_in() && function_exists('pmpro_hasMembershipLevel')) {
        $user_id = get_current_user_id();
        if (pmpro_hasMembershipLevel($level_ids, $user_id)) {
            // User already has a membership that matches this course's category.
            // Let Tutor's enrollment UI show; do not duplicate with pricing buttons.
            return;
        }
    }

    // 3) Fetch matching levels and display buttons (for non-members / non-matching members).
    $all_levels = pmpro_getAllLevels(true, true);
    $levels = array_filter($all_levels, function($lvl) use ($level_ids) {
        return in_array((int)$lvl->id, $level_ids, true);
    });
    if (empty($levels)) {
        return;
    }

    usort($levels, function($a, $b) {
        return (float)$a->initial_payment <=> (float)$b->initial_payment;
    });

    echo '<div class="tutor-pmpro-levels" style="margin-top:12px;">';
    echo '<h4 style="margin:0 0 8px;">Membership Access</h4>';

    foreach ($levels as $level) {
        $price_text = mc_pmpl_format_level_price($level);
        $checkout_url = esc_url(pmpro_url('checkout', '?level=' . (int)$level->id . '&redirect_to=' . urlencode(get_permalink($post))));

        echo '<div class="tutor-pmpro-level" style="padding:10px 12px;border:1px solid #e5e7eb;border-radius:10px;margin-bottom:10px;">';
        echo '<div style="display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;">';
        echo '<div>';
        echo '<div style="font-weight:600;">' . esc_html($level->name) . '</div>';
        echo '<div style="font-size:13px;opacity:0.8;">' . wp_kses_post($price_text) . '</div>';
        echo '</div>';
        echo '<a class="tutor-button" href="' . $checkout_url . '" style="padding:8px 12px;border-radius:8px;background:#111827;color:#fff;text-decoration:none;">Choose Plan</a>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
}, 10);

/**
 * Helper: Pretty format PMPro level pricing.
 */
if (!function_exists('mc_pmpl_format_level_price')) {
    function mc_pmpl_format_level_price($level) {
        if (function_exists('pmpro_getLevelCost')) {
            return pmpro_getLevelCost($level, false, true); // short format
        }
        $initial = (float)$level->initial_payment;
        $recurring = (float)$level->billing_amount;
        $cycle_n = (int)$level->cycle_number;
        $cycle_p = isset($level->cycle_period) ? strtolower($level->cycle_period) : '';
        $parts = [];
        $parts[] = $initial > 0 ? sprintf('$%s initial', number_format($initial, 2)) : 'Free to start';
        if ($recurring > 0 && $cycle_n > 0 && $cycle_p) {
            $interval = $cycle_n === 1 ? $cycle_p : $cycle_n . ' ' . $cycle_p;
            $parts[] = sprintf('then $%s / %s', number_format($recurring, 2), $interval);
        }
        if (!empty($level->expiration_number) && !empty($level->expiration_period)) {
            $parts[] = sprintf('(expires in %s %s)', (int)$level->expiration_number, strtolower($level->expiration_period));
        }
        return implode(' • ', $parts);
    }
}
