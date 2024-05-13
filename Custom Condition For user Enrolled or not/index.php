<?php 


$user_id = get_current_user_id(); // Get the current user's ID
$course_id = get_the_ID(); 

return  (tutor_utils()->is_enrolled($course_id, $user_id));
