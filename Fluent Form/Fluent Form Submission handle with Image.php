add_action('fluentform/before_submission_confirmation', 'register_teacher_and_organization', 10, 3);

function register_teacher_and_organization($entryId, $data, $form)
{
    // Run only for target form
    if ((int) $form->id !== 3) {
        return;
    }

    // Ensure required includes for media/file functions
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    // ------------- Extract & sanitize form fields -------------
    // Adjust field keys if needed to match your FF form handles
    $first_name = isset($data['names']['first_name']) ? sanitize_text_field($data['names']['first_name']) : '';
    $last_name = isset($data['names']['last_name']) ? sanitize_text_field($data['names']['last_name']) : '';
    $full_name = trim($first_name . ' ' . $last_name);
    $email = isset($data['email']) ? sanitize_email($data['email']) : '';
    $phone = isset($data['phone']) ? sanitize_text_field($data['phone']) : '';
    $username = isset($data['Username']) ? sanitize_user($data['Username']) : '';
    $password = isset($data['Password']) ? (string) $data['Password'] : wp_generate_password(12, true, true);

    $bio = isset($data['Instructor_s_Bio']) ? wp_kses_post($data['Instructor_s_Bio']) : '';
    $quote = isset($data['Instructor_s_Quote']) ? wp_kses_post($data['Instructor_s_Quote']) : '';
    $experience = isset($data['Years_of_Experience_']) ? sanitize_text_field($data['Years_of_Experience_']) : '';
    $students = isset($data['Number_of_Students']) ? sanitize_text_field($data['Number_of_Students']) : '';
    $univ_partners = isset($data['Number_of_University_Partners']) ? sanitize_text_field($data['Number_of_University_Partners']) : '';

    $organization_name = isset($data['Organization_Name_']) ? sanitize_text_field($data['Organization_Name_']) : '';
    $org_short_desc = isset($data['Organization_s_Short_Description_']) ? wp_kses_post($data['Organization_s_Short_Description_']) : '';
    $org_details = isset($data['Organization_s_Details']) ? wp_kses_post($data['Organization_s_Details']) : '';
    $page_title = isset($data['page_title']) ? sanitize_text_field($data['page_title']) : '';

    // Files/Images (Fluent Forms often returns arrays)
    $instructor_profile = !empty($data['Instructor_s__Profile']) ? (is_array($data['Instructor_s__Profile']) ? $data['Instructor_s__Profile'][0] : $data['Instructor_s__Profile']) : '';
    $organization_logo = !empty($data['Organization_Logo_']) ? (is_array($data['Organization_Logo_']) ? $data['Organization_Logo_'][0] : $data['Organization_Logo_']) : '';
    $gallery_images = !empty($data['Upload_Gallery_Images']) ? (array) $data['Upload_Gallery_Images'] : [];

    // Debug if needed
    error_log('FF DATA: ' . print_r($data, true));
    error_log('Instructor Profile raw: ' . print_r($instructor_profile, true));

    // ------------- Duplicate user checks (server-side safety) -------------
    if (username_exists($username)) {
        wp_send_json_error([
            'errors' => [
                'Username' => [__('A User Already Registered with this Username.', 'textdomain')]
            ]
        ]);
        wp_die();
    }

    if (email_exists($email)) {
        wp_send_json_error([
            'errors' => [
                'email' => [__('A User Already Registered with this Email.', 'textdomain')]
            ]
        ]);
        wp_die();
    }

    // ------------- Create user -------------
    $user_id = wp_create_user($username, $password, $email);
    if (is_wp_error($user_id)) {
        wp_send_json_error([
            'errors' => [
                'general' => [__('Failed to create user. Please try again.', 'textdomain')]
            ]
        ]);
        wp_die();
    }

    // Update profile fields
    wp_update_user([
        'ID' => $user_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'display_name' => $full_name,
    ]);

    update_user_meta($user_id, 'phone', $phone);
    update_user_meta($user_id, 'instructor_bio', $bio);
    update_user_meta($user_id, 'instructor_quote', $quote);
    update_user_meta($user_id, 'years_of_experience', $experience);
    update_user_meta($user_id, 'number_of_students', $students);
    update_user_meta($user_id, 'number_of_university_partners', $univ_partners);
    update_user_meta($user_id, 'organization_name', $organization_name);
    update_user_meta($user_id, 'organization_short_description', $org_short_desc);
    update_user_meta($user_id, 'organization_details', $org_details);

    // Role + login
    $user = new WP_User($user_id);
    $user->set_role('tutor_instructor');
    update_user_meta($user_id, '_tutor_instructor_status', 'pending');

    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);



    // ------------- Import images -------------
    $profile_image_id = null;
    $organization_logo_id = null;
    $gallery_attachment_ids = [];

    if (!empty($instructor_profile)) {
        //get attachment id
        $profile_image_id = attachment_url_to_postid($instructor_profile);

        if (!is_wp_error($profile_image_id)) {
            update_user_meta($user_id, 'instructor_profile', (int) $profile_image_id);
        } else {
            error_log('Profile image import failed: ' . print_r($profile_image_id, true));
        }
    }

    if (!empty($organization_logo)) {
        $organization_logo_id = attachment_url_to_postid($organization_logo);
        if (!is_wp_error($organization_logo_id)) {
            update_user_meta($user_id, 'organization_logo', (int) $organization_logo_id);
        } else {
            error_log('Organization logo import failed: ' . print_r($organization_logo_id, true));
        }
    }

    if (!empty($gallery_images)) {
        foreach ($gallery_images as $image_url) {
            if (empty($image_url))
                continue;
            $aid = attachment_url_to_postid($image_url);
            if (!is_wp_error($aid)) {
                $gallery_attachment_ids[] = (int) $aid;
            }
        }
        if (!empty($gallery_attachment_ids)) {
            update_user_meta($user_id, 'organization_gallery', $gallery_attachment_ids);
        }
    }

    // ------------- Create "organization" post -------------
    $post_title = trim($organization_name . ' By ' . $full_name);
    $org_post_data = [
        'post_title' => $post_title ?: 'Untitled Organization',
        'post_content' => '',
        'post_status' => 'pending',
        'post_author' => $user_id,
        'post_type' => 'organization',
    ];

    $org_post_id = wp_insert_post($org_post_data);
    if (is_wp_error($org_post_id)) {
        wp_send_json_error([
            'errors' => [
                'general' => [__('Failed to create organization post. Please try again.', 'textdomain')]
            ]
        ]);
        wp_die();
    }

    // Save organization metas
    if (!empty($organization_logo_id) && !is_wp_error($organization_logo_id)) {
        update_post_meta($org_post_id, 'organization_logo', (int) $organization_logo_id);
    }

    if (!empty($gallery_attachment_ids)) {
        update_post_meta($org_post_id, 'gallery_image_count', count($gallery_attachment_ids));
        foreach ($gallery_attachment_ids as $index => $attachment_id) {
            update_post_meta($org_post_id, 'gallery_image_' . ($index + 1), (int) $attachment_id);
        }
    }

    update_post_meta($org_post_id, 'organization_short_description', $org_short_desc);
    update_post_meta($org_post_id, 'instructor_id', $user_id);
    update_post_meta($org_post_id, 'hero_section_heading', $page_title);
    update_post_meta($org_post_id, 'number_of_university_partners', $univ_partners);
    update_post_meta($org_post_id, 'number_of_students', $students);
    update_post_meta($org_post_id, 'years_of_experience', $experience);
    update_post_meta($org_post_id, 'instructors_full_name', $full_name);
    update_post_meta($org_post_id, 'instructor_bio', $bio);
    update_post_meta($org_post_id, 'instructor_quote', $quote);

    // ------------- Create "about-us" post -------------
    $about_post_data = [
        'post_title' => 'About - ' . ($organization_name ?: $full_name),
        'post_content' => $org_details,
        'post_status' => 'pending',
        'post_author' => $user_id,
        'post_type' => 'about-us',
    ];
    $about_post_id = wp_insert_post($about_post_data);

    if (is_wp_error($about_post_id)) {
        wp_send_json_error([
            'errors' => [
                'general' => [__('Failed to create about us post. Please try again.', 'textdomain')]
            ]
        ]);
        wp_die();
    }

    // Relate posts ↔ user
    update_post_meta($org_post_id, 'about_us_page', $about_post_id);
    update_user_meta($user_id, 'organization_post_id', $org_post_id);
    update_user_meta($user_id, 'about_us_post_id', $about_post_id);

    // Instructor images to posts (only if valid)
    if (!empty($profile_image_id) && !is_wp_error($profile_image_id)) {
        update_post_meta($about_post_id, 'instructor_image', (int) $profile_image_id);
        update_post_meta($org_post_id, 'instructor_image', (int) $profile_image_id);
    }

    // About-us metas
    update_post_meta($about_post_id, 'instructor_id', $user_id);
    update_post_meta($about_post_id, 'instructor_full_name', $full_name);
    update_post_meta($about_post_id, 'instructor_bio', $bio);
    update_post_meta($about_post_id, 'instructor_quote', $quote);
    update_post_meta($about_post_id, 'years_of_experience', $experience);
    update_post_meta($about_post_id, 'number_of_students', $students);
    update_post_meta($about_post_id, 'number_of_university_partners', $univ_partners);
    update_post_meta($about_post_id, 'organization_short_description', $org_short_desc);
    update_post_meta($about_post_id, 'organization_details', $org_details);

    // // IMPORTANT: Always return $insertData 
    // return $data;
}
