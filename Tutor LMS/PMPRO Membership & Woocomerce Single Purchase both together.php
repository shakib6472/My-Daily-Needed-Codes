/**
 * PIXELS — TUTOR LMS + PMPRO + WOOCOMMERCE INTEGRATION (ALL-IN-ONE)
 * P1: WC product "Course" tab + two-way link
 * P2: Course page — hide Price/Wishlist + Lifetime buy card
 * P3: Auto-enroll after WC (lifetime) purchase
 * P4: Auto-enroll/un-enroll by PMPro category subscription
 * Paste WITHOUT <?php. Run on: Everywhere.
 */

/* Level -> allowed category IDs, read live from PMPro's own table
 * (where Tutor "Category wise membership" checkboxes are stored). No hardcoding. */
function pixels_level_category_map() {
    global $wpdb;
    $table = $wpdb->prefix . 'pmpro_memberships_categories';
    $rows  = $wpdb->get_results( "SELECT membership_id, category_id FROM {$table}" );

    $map = array();
    if ( $rows ) {
        foreach ( $rows as $r ) {
            $map[ (int) $r->membership_id ][] = (int) $r->category_id;
        }
    }
    return $map;
}


/* ===== PART 1 — WC product "Course" tab + bidirectional link ===== */

// Add the "Course" tab.
add_filter( 'woocommerce_product_data_tabs', function ( $tabs ) {
    $tabs['linked_course'] = array(
        'label'    => __( 'Course', 'pixels' ),
        'target'   => 'linked_course_product_data',
        'class'    => array(),
        'priority' => 65,
    );
    return $tabs;
} );

// Tab content: dropdown of all published courses.
add_action( 'woocommerce_product_data_panels', function () {
    global $post;
    $selected = get_post_meta( $post->ID, '_linked_tutor_course_id', true );

    $courses = get_posts( array(
        'post_type'   => 'courses',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby'     => 'title',
        'order'       => 'ASC',
    ) );

    echo '<div id="linked_course_product_data" class="panel woocommerce_options_panel"><div class="options_group">';
    echo '<p class="form-field"><label for="_linked_tutor_course_id">' . esc_html__( 'Linked Course', 'pixels' ) . '</label>';
    echo '<select id="_linked_tutor_course_id" name="_linked_tutor_course_id" class="select short">';
    echo '<option value="">' . esc_html__( '— Select a course —', 'pixels' ) . '</option>';
    foreach ( $courses as $course ) {
        printf( '<option value="%1$d" %2$s>%3$s</option>',
            (int) $course->ID,
            selected( $selected, $course->ID, false ),
            esc_html( $course->post_title )
        );
    }
    echo '</select></p></div></div>';
} );

// Save link on BOTH product and course; clean stale reverse link if re-pointed.
add_action( 'woocommerce_process_product_meta', function ( $product_id ) {
    $course_id = filter_input( INPUT_POST, '_linked_tutor_course_id', FILTER_SANITIZE_NUMBER_INT );
    $course_id = $course_id ? (int) $course_id : 0;
    $previous  = (int) get_post_meta( $product_id, '_linked_tutor_course_id', true );

    if ( $course_id ) {
        update_post_meta( $product_id, '_linked_tutor_course_id', $course_id );
        update_post_meta( $course_id, '_linked_wc_product_id', $product_id );
    } else {
        delete_post_meta( $product_id, '_linked_tutor_course_id' );
    }

    if ( $previous && $previous !== $course_id ) {
        if ( (int) get_post_meta( $previous, '_linked_wc_product_id', true ) === (int) $product_id ) {
            delete_post_meta( $previous, '_linked_wc_product_id' );
        }
    }
} );


/* ===== PART 2 — Course page: CSS cleanup + Lifetime card ===== */

// Hide sidebar "Price: Free" row + Wishlist button.
add_action( 'wp_head', function () {
    if ( ! function_exists( 'tutor' ) || ! is_singular( 'courses' ) ) {
        return;
    }
    ?>
    <style id="pixels-course-cleanup">
        .edublink-course-details-features-item.course-price,
        .tutor-course-bookmark,
        .eb-tl-sidebar-wishlist { display: none !important; }
    </style>
    <?php
} );

// Lifetime (one-time) purchase card in the sidebar.
add_action( 'tutor_course/single/entry/after', function () {
    if ( ! function_exists( 'tutor_utils' ) ) {
        return;
    }
    $course_id = get_the_ID();
    if ( ! $course_id ) {
        return;
    }

    $product_id = (int) get_post_meta( $course_id, '_linked_wc_product_id', true );
    if ( ! $product_id ) {
        return;
    }

    $product = wc_get_product( $product_id );
    if ( ! $product || ! $product->is_purchasable() ) {
        return;
    }

    // Already enrolled (subscription or lifetime)? Hide the buy option.
    if ( tutor_utils()->is_enrolled( $course_id ) ) {
        return;
    }

    $checkout_url = add_query_arg( 'add-to-cart', $product_id, wc_get_checkout_url() );
    $price_html   = $product->get_price_html();
    ?>
    <div class="tutor-pmpro-single-course-pricing tutor-mt-24">
        <h3 class="tutor-fs-5 tutor-fw-bold tutor-mb-16"><?php esc_html_e( 'Prefer one-time access?', 'pixels' ); ?></h3>
        <label class="tutor-pmpro-level-highlight">
            <div class="tutor-pmpro-level-header tutor-d-flex tutor-align-center tutor-justify-between">
                <div class="tutor-d-flex tutor-align-center">
                    <span class="tutor-fs-5 tutor-fw-medium tutor-ml-12"><?php esc_html_e( 'Lifetime', 'pixels' ); ?></span>
                </div>
                <div class="tutor-fs-4">
                    <span class="tutor-fw-bold"><?php echo wp_kses_post( $price_html ); ?></span>
                </div>
            </div>
            <div class="tutor-pmpro-level-desc tutor-mt-20">
                <div class="tutor-fs-6 tutor-color-muted tutor-mb-20"><?php esc_html_e( 'Pay once, keep access forever.', 'pixels' ); ?></div>
                <a href="<?php echo esc_url( $checkout_url ); ?>" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-btn-block">
                    <?php esc_html_e( 'Buy Lifetime Access', 'pixels' ); ?>
                </a>
            </div>
        </label>
    </div>
    <?php
} );


/* ===== SHARED HELPERS ===== */

/* Enroll user + force enrollment to "completed".
 * Tutor creates enrollments as "pending" for purchasable courses, which
 * is_enrolled() ignores — so we force "completed". This is the core fix. */
function pixels_enroll_user_in_course( $course_id, $user_id, $order_id = 0, $via = '' ) {
    if ( ! function_exists( 'tutor_utils' ) || ! $course_id || ! $user_id ) {
        return 0;
    }
    if ( tutor_utils()->is_enrolled( $course_id, $user_id ) ) {
        return 0;
    }

    tutor_utils()->do_enroll( $course_id, $order_id, $user_id );
    $enrol_id = pixels_get_latest_enrollment_id( $course_id, $user_id );

    if ( $enrol_id ) {
        if ( get_post_status( $enrol_id ) !== 'completed' ) {
            wp_update_post( array( 'ID' => $enrol_id, 'post_status' => 'completed' ) );
        }
        if ( $via ) {
            update_post_meta( $enrol_id, '_pixels_enrolled_via', $via );
        }
    }
    return $enrol_id;
}

/* Latest enrollment post ID (any status, since it may be "pending"). */
function pixels_get_latest_enrollment_id( $course_id, $user_id ) {
    $rows = get_posts( array(
        'post_type'   => 'tutor_enrolled',
        'post_status' => array( 'completed', 'pending' ),
        'post_parent' => $course_id,
        'author'      => $user_id,
        'numberposts' => 1,
        'orderby'     => 'ID',
        'order'       => 'DESC',
        'fields'      => 'ids',
    ) );
    return ! empty( $rows ) ? (int) $rows[0] : 0;
}

/* Cancel ONLY subscription-created enrollments; lifetime/WC/manual stay safe. */
function pixels_cancel_pmpro_enrollment( $course_id, $user_id ) {
    $enrollments = get_posts( array(
        'post_type'   => 'tutor_enrolled',
        'post_status' => 'completed',
        'post_parent' => $course_id,
        'author'      => $user_id,
        'numberposts' => -1,
        'fields'      => 'ids',
    ) );

    foreach ( $enrollments as $enrol_id ) {
        $by_order = get_post_meta( $enrol_id, '_tutor_enrolled_by_order_id', true );
        $via      = get_post_meta( $enrol_id, '_pixels_enrolled_via', true );
        if ( $by_order || $via !== 'pmpro' ) {
            continue; // WC / lifetime / manual -> never cancel
        }
        wp_update_post( array( 'ID' => $enrol_id, 'post_status' => 'cancel' ) );
    }
}


/* ===== PART 3 — Auto-enroll after a WooCommerce purchase ===== */
add_action( 'woocommerce_order_status_processing', 'pixels_enroll_from_wc_order', 10, 1 );
add_action( 'woocommerce_order_status_completed',  'pixels_enroll_from_wc_order', 10, 1 );

function pixels_enroll_from_wc_order( $order_id ) {
    if ( ! function_exists( 'tutor_utils' ) ) {
        return;
    }
    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        return;
    }
    $user_id = $order->get_user_id();
    if ( ! $user_id ) {
        return; // guest checkout, no account -> nobody to enroll
    }
    if ( $order->get_meta( '_pixels_tutor_enrolled' ) === 'yes' ) {
        return; // already processed
    }

    foreach ( $order->get_items() as $item ) {
        $product_id = $item->get_product_id();
        if ( ! $product_id ) {
            continue;
        }
        $course_id = (int) get_post_meta( $product_id, '_linked_tutor_course_id', true );
        if ( ! $course_id ) {
            continue;
        }
        pixels_enroll_user_in_course( $course_id, $user_id, $order_id, 'lifetime' );
    }

    $order->update_meta_data( '_pixels_tutor_enrolled', 'yes' );
    $order->save();
}


/* ===== PART 4 — PMPro category subscription -> enroll / un-enroll ===== */
add_action( 'pmpro_after_change_membership_level', 'pixels_pmpro_sync_enrollments', 10, 3 );

function pixels_pmpro_sync_enrollments( $level_id, $user_id, $cancel_level = null ) {
    if ( ! function_exists( 'tutor_utils' ) || ! function_exists( 'pmpro_getMembershipLevelsForUser' ) ) {
        return;
    }

    $map = pixels_level_category_map();

    // Categories the user is STILL entitled to (across all active levels).
    $active_levels = pmpro_getMembershipLevelsForUser( $user_id );
    $entitled_cats = array();
    if ( ! empty( $active_levels ) ) {
        foreach ( $active_levels as $lvl ) {
            if ( isset( $map[ $lvl->id ] ) ) {
                $entitled_cats = array_merge( $entitled_cats, $map[ $lvl->id ] );
            }
        }
    }
    $entitled_cats = array_unique( array_map( 'intval', $entitled_cats ) );

    // Enroll into all courses in the entitled categories.
    if ( $entitled_cats ) {
        $courses = get_posts( array(
            'post_type'   => 'courses',
            'post_status' => 'publish',
            'numberposts' => -1,
            'fields'      => 'ids',
            'tax_query'   => array( array(
                'taxonomy' => 'course-category',
                'field'    => 'term_id',
                'terms'    => $entitled_cats,
            ) ),
        ) );
        foreach ( $courses as $course_id ) {
            pixels_enroll_user_in_course( $course_id, $user_id, 0, 'pmpro' );
        }
    }

    // Un-enroll from categories the user no longer has.
    $all_cats = array();
    foreach ( $map as $cats ) {
        $all_cats = array_merge( $all_cats, $cats );
    }
    $lost_cats = array_diff( array_unique( array_map( 'intval', $all_cats ) ), $entitled_cats );

    if ( $lost_cats ) {
        $lost_courses = get_posts( array(
            'post_type'   => 'courses',
            'post_status' => 'publish',
            'numberposts' => -1,
            'fields'      => 'ids',
            'tax_query'   => array( array(
                'taxonomy' => 'course-category',
                'field'    => 'term_id',
                'terms'    => $lost_cats,
            ) ),
        ) );
        foreach ( $lost_courses as $course_id ) {
            $course_terms = wp_get_post_terms( $course_id, 'course-category', array( 'fields' => 'ids' ) );
            if ( array_intersect( $course_terms, $entitled_cats ) ) {
                continue; // still covered by another active category
            }
            pixels_cancel_pmpro_enrollment( $course_id, $user_id );
        }
    }
}
