<?php

function add_a_new_announcement()
{
    global $wpdb;

    // Get the values
    $title = $_POST['title'];
    $details = $_POST['details'];

    // Define the table name
    $table_name = $wpdb->prefix . 'tiny_announcements';

    // Insert initial data into the table
    $result = $wpdb->insert(
        $table_name,
        array(
            'title' => $title,
            'details' => $details,
            'date_created' => date('d F Y'), // Current date and time
            'parents' => json_encode(array(0)), // Initially an array with 0 // Parent Id show Seen the announcements
        )
    );

    // Check for errors during insertion
    if ($result === false) {
        // If there was an error, send JSON error response
        wp_send_json_error('Error inserting data: ' . $wpdb->last_error);
    } else {
        // If insertion was successful, send JSON success response
        wp_send_json_success('Data successfully added');
    }
    die;
}
add_action('wp_ajax_add_a_new_announcement', 'add_a_new_announcement');
add_action('wp_ajax_nopriv_add_a_new_announcement', 'add_a_new_announcement');
function add_a_new_qna()
{
    global $wpdb;

    // Get the values
    $title = $_POST['title'];
    $datetime = $_POST['datetime'];
    $zoomurl = $_POST['zoomurl'];
    $howoften = $_POST['howoften'];
    $untilduration = $_POST['untilduration'];
    $response = '';

    if ("" == $howoften) {
        $datetimeObj = new DateTime($datetime);
        $formattedDate = $datetimeObj->format('Y-m-d H:i:s');
        // Insert the post with the specified publish date
        $post_id = wp_insert_post(array(
            'post_title'    => $title,
            'post_status'   => 'publish',
            'post_type'     => 'weekly-call',
            'post_date'     => $formattedDate,
            'post_date_gmt' => get_gmt_from_date($formattedDate)
        ));

        if (!is_wp_error($post_id)) {
            update_post_meta($post_id, 'date', $datetime);
            update_post_meta($post_id, 'zoom_link', $zoomurl);
        }
        // Check for errors during insertion
        if ($post_id === false) {
            // If there was an error, send JSON error response
            $response .= 'Error inserting Qna Call: ' . $post_id . ' ';
        } else {
            // If insertion was successful, send JSON success response
            $response .= 'Single Q&A Added Successfully ' . $post_id . ' ';
        }
    } else {

        if ($howoften  == "1") {
            //Do for daily
            for ($i = 0; $i < $untilduration; $i++) {
                // Convert the string to a DateTime object
                $datetimeObj = new DateTime($datetime);
                if ($i !== 0) {
                    // Add one day to the DateTime object
                    $datetimeObj->modify('+1 day');
                    // Format the DateTime object back to the desired format
                }
                $datetime = $datetimeObj->format('Y-m-d\TH:i');
                $formattedDate = $datetimeObj->format('Y-m-d H:i:s');

                // Format the DateTime object to Y-m-d H:i:s for WordPress

                // Insert the post with the specified publish date
                $post_id = wp_insert_post(array(
                    'post_title'    => $title,
                    'post_status'   => 'publish',
                    'post_type'     => 'weekly-call',
                    'post_date'     => $formattedDate,
                    'post_date_gmt' => get_gmt_from_date($formattedDate)
                ));


                if (!is_wp_error($post_id)) {
                    update_post_meta($post_id, 'date', $datetime);
                    update_post_meta($post_id, 'zoom_link', $zoomurl);
                }
                // Check for errors during insertion
                if ($post_id === false) {
                    // If there was an error, send JSON error response

                    // If there was an error, send JSON error response
                    $response .= 'Error inserting Qna Call: ' . $post_id . ' <br> ';
                } else {
                    // If insertion was successful, send JSON success response
                    $response .= 'Recurring Q&A Added Successfully ' . $post_id . ' <br> ';
                }
            }
        } elseif ($howoften  == "2") {
            //Do for Weekly
            for ($i = 0; $i < $untilduration; $i++) {

                // Convert the string to a DateTime object
                $datetimeObj = new DateTime($datetime);
                if ($i !== 0) {
                    // Add one day to the DateTime object
                    $datetimeObj->modify('+1 week');
                    // Format the DateTime object back to the desired format
                }
                $datetime = $datetimeObj->format('Y-m-d\TH:i');
                $formattedDate = $datetimeObj->format('Y-m-d H:i:s');

                // Format the DateTime object to Y-m-d H:i:s for WordPress

                // Insert the post with the specified publish date
                $post_id = wp_insert_post(array(
                    'post_title'    => $title,
                    'post_status'   => 'publish',
                    'post_type'     => 'weekly-call',
                    'post_date'     => $formattedDate,
                    'post_date_gmt' => get_gmt_from_date($formattedDate)
                ));




                if (!is_wp_error($post_id)) {
                    update_post_meta($post_id, 'date', $datetime);
                    update_post_meta($post_id, 'zoom_link', $zoomurl);
                }
                // Check for errors during insertion
                if ($post_id === false) {
                    // If there was an error, send JSON error response

                    // If there was an error, send JSON error response
                    $response .= 'Error inserting Qna Call: ' . $post_id . ' <br> ';
                } else {
                    // If insertion was successful, send JSON success response
                    $response .= 'Recurring Q&A Added Successfully ' . $post_id . ' <br> ';
                }
            }
        } elseif ($howoften  == "3") {
            //Do for Monthly
            for ($i = 0; $i < $untilduration; $i++) {
                // Convert the string to a DateTime object
                $datetimeObj = new DateTime($datetime);
                if ($i !== 0) {
                    // Add one day to the DateTime object
                    $datetimeObj->modify('+1 month');
                    // Format the DateTime object back to the desired format
                }
                $datetime = $datetimeObj->format('Y-m-d\TH:i');
                $formattedDate = $datetimeObj->format('Y-m-d H:i:s');

                // Format the DateTime object to Y-m-d H:i:s for WordPress

                // Insert the post with the specified publish date
                $post_id = wp_insert_post(array(
                    'post_title'    => $title,
                    'post_status'   => 'publish',
                    'post_type'     => 'weekly-call',
                    'post_date'     => $formattedDate,
                    'post_date_gmt' => get_gmt_from_date($formattedDate)
                ));


                if (!is_wp_error($post_id)) {
                    update_post_meta($post_id, 'date', $datetime);
                    update_post_meta($post_id, 'zoom_link', $zoomurl);
                }
                // Check for errors during insertion
                if ($post_id === false) {
                    // If there was an error, send JSON error response

                    // If there was an error, send JSON error response
                    $response .= 'Error inserting Qna Call: ' . $post_id . ' <br> ';
                } else {
                    // If insertion was successful, send JSON success response
                    $response .= 'Recurring Q&A Added Successfully ' . $post_id . ' <br> ';
                }
            }
        }
    }
    wp_send_json_error($response);
    die;
}
add_action('wp_ajax_add_a_new_qna', 'add_a_new_qna');
add_action('wp_ajax_nopriv_add_a_new_qna', 'add_a_new_qna');



function add_a_new_question()
{
    if (is_user_logged_in()) {

        // Get the values
        $title = $_POST['question'];
        $description = $_POST['description'];
        $priority = $_POST['ticket_priority'];
        //$category = $_POST['ticket_category'];
        $user_id = get_current_user_id();
        $response = '';

        $ticket_id = wp_insert_post(array(
            'post_type' => 'support_ticket',
            'post_title' => $title,
            'post_content' => $description,
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
        ));

        if ($ticket_id) {
            $response .= 'Post has been Created. Id is : ' . $ticket_id;
            // wp_set_object_terms($ticket_id, $category, 'ticket_category');
            wp_set_object_terms($ticket_id, $priority, 'ticket_priority');

            // Add custom field for ticket status
            update_post_meta($ticket_id, 'ticket_status', 'open');
            // Notify admin/support staff via email
            wp_mail('shakib6472@hotmail.com', 'New Support Ticket Submitted', 'A new support ticket has been submitted.');
        }
    }
    wp_send_json_error($response);
    die;
}
add_action('wp_ajax_add_a_new_question', 'add_a_new_question');
add_action('wp_ajax_nopriv_add_a_new_question', 'add_a_new_question');



function add_a_new_resource()
{
    if (is_user_logged_in()) {

        // Get the values

        $title = $_POST['title'];
        $resource_type = $_POST['resource_type'];
        $resouce_url = $_POST['resouce_url'];
        $thumbnail_id = $_POST['thumbnail_id'];
        // Get the term ID from its slug
        $term = get_term_by('slug', $resource_type, 'resource-type');
        $term_id = $term->term_id;
        $user_id = get_current_user_id();
        $response = '';

        $post_id = wp_insert_post(array(
            'post_type' => 'resource',
            'post_title' => $title,
            'post_status' => 'publish',
            'tax_input' => array(
                'resource-type' => array($term_id), // Set the category using its term ID
            ),
        ));

        if ($post_id) {
            $response .= 'Post has been Created. Id is : ' . $post_id;
            // Add custom field for ticket status
            update_post_meta($post_id, 'source_link', $resouce_url);
            $response .= 'Post Thumbnail setting Started';
            set_post_thumbnail($post_id, $thumbnail_id);
            $response .= 'Post Thumbnail setting Ended';
            $response .= 'Post Thumbnail Has benn setet for : ' . $post_id;
        }
    }
    wp_send_json_error($response);
    die;
}
add_action('wp_ajax_add_a_new_resource', 'add_a_new_resource');
add_action('wp_ajax_nopriv_add_a_new_resource', 'add_a_new_resource');

function delete_resource()
{
    if (is_user_logged_in()) {

        // Get the values

        $post_id = $_POST['post_id'];
        $response = '';

        if ($post_id) {
            $response .= 'Post Id geted : ' . $post_id;
            wp_delete_post($post_id);
            $response .= '<br> Post Deleted';
        }
    }
    wp_send_json_error($response);
    die;
}
add_action('wp_ajax_delete_resource', 'delete_resource');
add_action('wp_ajax_nopriv_delete_resource', 'delete_resource');

function add_a_new_game()
{
    if (is_user_logged_in()) {

        // Get the values
        $title = $_POST['title'];
        $gane_code = $_POST['gane_code'];
        $thumbnail_id = $_POST['thumbnail_id'];
        // Get the term ID from its slug
        $user_id = get_current_user_id();
        $response = '';

        $post_id = wp_insert_post(array(
            'post_type' => 'game',
            'post_title' => $title,
            'post_status' => 'publish',
        ));

        if ($post_id) {
            $response .= 'Post has been Created. Id is : ' . $post_id;
            // Add custom field for ticket status
            update_post_meta($post_id, 'iframe_code', $gane_code);
            $response .= 'Post Thumbnail setting Started';
            set_post_thumbnail($post_id, $thumbnail_id);
            $response .= 'Post Thumbnail setting Ended';
            $response .= 'Post Thumbnail Has benn setet for : ' . $post_id;
        }
    }
    wp_send_json_error($response);
    die;
}
add_action('wp_ajax_add_a_new_game', 'add_a_new_game');
add_action('wp_ajax_nopriv_add_a_new_game', 'add_a_new_game');


function add_a_new_cartoon()
{

// Get the value from the form field named 'title' and store it in the variable $title
$title = $_POST['title'];

// Check if the form field 'new_category' is set
// If it is set, store its value in the variable $new_category
// If it is not set, assign the value 0 to $new_category
$new_category = isset($_POST['new_category']) ? $_POST['new_category'] : 0;


// Get the value from the form field named 'resouce_url' and store it in the variable $resouce_url
$resouce_url = $_POST['resouce_url'];
$resource_type = $_POST['resource_type'];

// Get the value from the form field named 'thumbnail_id' and store it in the variable $thumbnail_id
$thumbnail_id = $_POST['thumbnail_id'];

// Call the function get_current_user_id() to get the ID of the currently logged-in user
// Store the user ID in the variable $user_id
$user_id = get_current_user_id();
    $response = '';

    error_log('Titel: ' . $title);
    error_log('New category: ' . $new_category);
    error_log('Resource URl: ' . $resouce_url);
    error_log('resource_type : ' . $resource_type);
    error_log('Thumbnail ID: ' . $thumbnail_id);
    error_log('user ID: ' . $user_id);

    if (is_user_logged_in()) {

        // Get the values
        $title = $_POST['title'];
        $new_category = isset($_POST['new_category']) ? $_POST['new_category'] : 0;
        $resource_type = $_POST['resource_type']; //this is the old category.
        $resouce_url = $_POST['resouce_url'];
        $thumbnail_id = $_POST['thumbnail_id'];
        $user_id = get_current_user_id();
        $response = '';


        if ('new' != $resource_type) {
            // Insert the post
            $post_id = wp_insert_post(array(
                'post_type' => 'cartoon',
                'post_title' => $title,
                'post_status' => 'publish',
            ));

            if (!is_wp_error($post_id)) {
                // Assign existing taxonomy term ID to the post
                wp_set_post_terms($post_id, $resource_type, 'cartoon-category');
                error_log('Old Category Published Seted');
            }
        } else {
            // Insert the post
            $post_id = wp_insert_post(array(
                'post_type' => 'cartoon',
                'post_title' => $title,
                'post_status' => 'publish',
            ));

            if (!is_wp_error($post_id)) {
                // Ensure the new category exists or create it if it doesn't
                $term = term_exists($new_category, 'cartoon-category');
                if ($term === 0 || $term === null) {
                    // Create the new category
                    $term = wp_insert_term($new_category, 'cartoon-category');
                    error_log('New Category Published Created');
                } else {
                    error_log('New Category Already there');
                }

                if (!is_wp_error($term)) {
                    // Get the term ID
                    $term_id = is_array($term) ? $term['term_id'] : $term;
                    // Assign the new category to the post
                    wp_set_post_terms($post_id, $term_id, 'cartoon-category');
                    error_log('New Category Published Seted');
                    }else {
                    error_log('New Category term Error');

                }
            }
        }



        if ($post_id) {
            // Indicate that the post has been successfully created along with its ID
            $response .= 'Post has been Created. ID is: ' . $post_id;

            // Add custom field for the resource link
            update_post_meta($post_id, 'source_link', $resouce_url);

            // Begin setting the post thumbnail
            $response .= 'Post Thumbnail setting Started';

            // Set the post thumbnail using the provided thumbnail ID
            set_post_thumbnail($post_id, $thumbnail_id);
            error_log(' thumbnail done');

            // Indicate that the post thumbnail setting process has ended
            $response .= 'Post Thumbnail setting Ended';

            // Confirm that the post thumbnail has been set for the post
            $response .= 'Post Thumbnail Has been set for: ' . $post_id;
            
        }
    }
    wp_send_json_error($response);
    die;
}
add_action('wp_ajax_add_a_new_cartoon', 'add_a_new_cartoon');
add_action('wp_ajax_nopriv_add_a_new_cartoon', 'add_a_new_cartoon');


function submit_weekly_data()
{
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('User is not logged in');
    }


    // Validate incoming data
    if (!isset($_POST['timetableJSON'])) {
        wp_send_json_error('Timetable data is missing');
    }
    if (!isset($_POST['weekNumber'])) {
        wp_send_json_error('Week Number data is missing');
    }
    $week_number = $_POST['weekNumber'];

    if (!isset($_POST['weekNumber'])) {
        wp_send_json_error('Week Number is undefined');
    } else {
        // Sanitize and validate input parameters
        $timetableJSON = $_POST['timetableJSON'];
        error_log('timetableJSON');
        $strinignfied = json_encode($timetableJSON);
        error_log($timetableJSON);

        // Decode JSON data
        $timetable = $timetableJSON;

        // Check if decoding was successful
        if (is_null($timetable)) {
            wp_send_json_error('Error decoding timetable data');
        }

        // Get current user ID
        $user_id = get_current_user_id();

        global $wpdb;
        $table_name = $wpdb->prefix . 'tiny_time_table';

        // Check if data already exists for the user
        $existing_data = $wpdb->get_row("SELECT week_$week_number FROM $table_name WHERE user_id = $user_id");

        if ($existing_data) {
            // Data already exists, so perform an update
            $result = $wpdb->update(
                $table_name,
                array(
                    'week_' . $week_number => $timetableJSON,
                ),
                array('user_id' => $user_id)
            );

            if ($result !== false) {
                wp_send_json_success("Data updated successfully.");
            } else {
                wp_send_json_success("Error updating data.");
            }
        } else {
            // Data doesn't exist, so insert new data
            $result = $wpdb->insert(
                $table_name,
                array(
                    'user_id' => $user_id,
                    'data'    => $timetableJSON,
                )
            );
        }

        // Check if insertion was successful
        if (false === $result) {
            wp_send_json_error('Error inserting data into the database');
        }
    }
    // Send success response
    wp_send_json_success('Timetable data saved successfully');

    // Always exit after handling AJAX requests
    wp_die();
}
add_action('wp_ajax_submit_weekly_data', 'submit_weekly_data');
add_action('wp_ajax_nopriv_submit_weekly_data', 'submit_weekly_data');




function add_reply_to_tiket()
{

    // Get the values
    $post_id = $_POST['dataid'];
    $replytext = $_POST['replytext'];
    $response = '';
    if ($post_id) {
        // Add custom field for ticket status
        update_post_meta($post_id, 'ticket_status', 'Closed');
        update_post_meta($post_id, 'admin_reply', $replytext);
        $response .= 'Post reply Has Been Submited. Id is : ' . $post_id;
    }

    wp_send_json_error($response);
    die;
}
add_action('wp_ajax_add_reply_to_tiket', 'add_reply_to_tiket');
add_action('wp_ajax_nopriv_add_reply_to_tiket', 'add_reply_to_tiket');
