add_filter('fluentform/validation_errors', function ($errors, $formData, $form) {
 
    if ($form->id  !== 3) {
        return $errors;
    }

    // Map your field handles correctly
    $email    = isset($formData['email']) ? sanitize_email($formData['email']) : ''; 

    // Duplicate checks -> attach to specific fields
    if ($email && email_exists($email)) {
        $errors['email'][] = __('Email already exists.', 'textdomain');
    }  
    return $errors;
}, 10, 3);


 
add_action('fluentform/before_insert_submission', 'register_teacher', 10, 3);

function register_teacher($insertData, $data, $form)
{ 
    if ($form->id !== 3) {
        return $insertData;
    }
 
$error = true;
    // Safety net: re-check duplicates (validation should have blocked already)
    if ($error) {
        wp_send_json_error([
            'errors' => [ 
                'email' => [__('A User Already Registered with this Email.', 'textdomain')]
            ]
        ]);
        wp_die();
    }
	     
 
    // IMPORTANT: Always return $insertData
    return $insertData;
}
 
