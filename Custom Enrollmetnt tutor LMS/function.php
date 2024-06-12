<?php 

function shakib_custom_enrollment_proccess($entryId, $formData, $form)
{
	// Check if the form ID matches the desired form (in this case, form ID 4)
	if ($form->id != 4) {
		return;
	}

	// Log the form data for debugging purposes
	error_log(print_r($formData, true));
	error_log($formData);

	// Extract the course ID, order ID, and user ID from the submitted form data
	$course_id = isset($formData['post_id']) ? $formData['post_id'] : null;
	$user_id = isset($formData['user_id']) ? $formData['user_id'] : null;

	// If course ID, order ID, and user ID are available, proceed with enrollment
	if ($course_id && $user_id) {
		// Enroll the user in the course using Tutor LMS functions
		$enrollment_result = tutor_utils()->do_enroll($course_id, 0 , $user_id);

		// Check if the enrollment was successful and possibly log the result or handle errors
		if ($enrollment_result) {
			// Enrollment successful, you can log this or perform other actions if needed
			error_log("User ID $user_id has been successfully enrolled in Course ID $course_id with Order ID $order_id.");
			wp_redirect(home_url('dashboard'));
			exit(); // Ensure the script stops executing after redirect
		} else {
			// Enrollment failed, handle the error accordingly
			error_log("Failed to enroll User ID $user_id in Course ID $course_id with Order ID $order_id.");
		}
	} else {
		// Handle cases where course_id, order_id, or user_id is not provided
		error_log("Course ID, Order ID, or User ID is missing from the form submission.");
	}
}

// Hook the function to the form submission action
add_action('fluentform/submission_inserted', 'shakib_custom_enrollment_proccess', 20, 3);