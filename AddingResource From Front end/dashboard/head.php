
<script src='https://kit.fontawesome.com/46882cce5e.js' crossorigin='anonymous'></script>

<?php 
$current_user_id = get_current_user_id();
$user_info = get_userdata($current_user_id);
$total_time_spend_in_dashboard = get_user_meta($current_user_id,'total_time_spend_in_dashboard');
$total_time_spend_in_dashboard_intval = intval(get_user_meta($current_user_id,'total_time_spend_in_dashboard',true));


?>

<link rel='stylesheet' id='tutor-frontend-dashboard-css-css' href='https://uktalearninghub.com/wp-content/plugins/tutor/assets/css/tutor-frontend-dashboard.min.css?ver=2.7.0' media='all' />
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>

<div class="tutor-wrap tutor-wrap-parent tutor-dashboard tutor-frontend-dashboard tutor-dashboard-student tutor-pb-80">
            <div class="tutor-container">
                <div class="tutor-row tutor-d-flex tutor-justify-between tutor-frontend-dashboard-header">
                    <div class="tutor-header-left-side tutor-dashboard-header tutor-col-md-6 tutor-d-flex tutor-align-center" style="border: none;">
                    </div>
                    <style>
                        /* Additional CSS styles */
                        .clock {
                            font-size: 3rem;
                            font-weight: bold;
                        }
                    </style>

                </div>
