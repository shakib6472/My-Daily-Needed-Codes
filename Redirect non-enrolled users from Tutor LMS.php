 
/**
 * Redirect non-enrolled users from Tutor LMS course single to its product page
 */
add_action('template_redirect', function () {

    // 1) Run only on front-end course single pages
    if ( is_admin() || is_preview() || ! function_exists('tutor') ) {
        return;
    }

    $course_post_type = tutor()->course_post_type ?? 'courses';
    if ( ! is_singular( $course_post_type ) ) {
        return;
    }

    $course_id = get_queried_object_id();
    if ( ! $course_id ) {
        return;
    }

    // 2) If user is logged in & enrolled: do NOT redirect
    $is_logged_in = is_user_logged_in();
    $is_enrolled  = false;

    if ( $is_logged_in && function_exists('tutor_utils') ) {
        // Check enrollment
        $utils = tutor_utils();
        if ( method_exists($utils, 'is_enrolled') ) {
            $is_enrolled = (bool) $utils->is_enrolled( $course_id, get_current_user_id() );
        } elseif ( function_exists('tutor_is_enrolled') ) {
            // Fallback helper if available
            $is_enrolled = (bool) tutor_is_enrolled( $course_id, get_current_user_id() );
        }
    }

    if ( $is_logged_in && $is_enrolled ) {
        // Enrolled users can view the course; do not redirect.
        return;
    }

    // 3) For NOT logged-in OR logged-in but NOT enrolled -> redirect to product
    // Try common meta keys Tutor LMS uses to store the linked WooCommerce product ID
    $product_id = 0;

    // Most common key
    $product_id = (int) get_post_meta( $course_id, '_tutor_course_product_id', true );

    // Fallback keys (some setups/plugins may use different keys)
    if ( ! $product_id ) {
        $product_id = (int) get_post_meta( $course_id, 'tutor_course_product_id', true );
    }
    if ( ! $product_id ) {
        $product_id = (int) get_post_meta( $course_id, '_tutor_course_product', true );
    }

    // If still not found, you can map via a custom field of your own (optional)
    // $product_id = $product_id ?: (int) get_post_meta( $course_id, 'your_custom_product_meta_key', true );

    // If no product is attached, do nothing (prevents redirect loops)
    if ( ! $product_id ) {
        return;
    }

    // Validate product & permalink
    $product_link = get_permalink( $product_id );
    if ( ! $product_link ) {
        return;
    }

    // Avoid redirect loop: only redirect if we're not already at the product page
    if ( trailingslashit( $product_link ) === trailingslashit( home_url( add_query_arg( [], $_SERVER['REQUEST_URI'] ?? '' ) ) ) ) {
        return;
    }

    // Perform safe redirect
    wp_safe_redirect( $product_link, 302 );
    exit;
});




 

/**
 * Optional hardening: if any order transitions into "processing" or "on-hold",
 * bump it to "completed" immediately. Useful for COD/bank transfer, etc.
 */
add_action('woocommerce_order_status_processing', function ($order_id) {
    $order = wc_get_order($order_id);
    if ( $order ) {
        $order->update_status('completed', __('Auto-completed from processing.', 'your-textdomain'));
    }
});
 

