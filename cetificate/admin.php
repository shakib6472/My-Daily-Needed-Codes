<?php


// Add Tutor's Subjects Admin Menu
function tiny_schoolars_call_function_for_admin_widget_menu()
{
    add_menu_page(
        'Certificates', // Page title
        'Certificates', // Menu title
        'manage_options',    // Capability required to access the menu
        'certificates',   // Menu slug
        'tiny_schoolars_page_content', // Callback function to display the page content
        'dashicons-flag',    // Icon for the menu (you can choose from Dashicons: https://developer.wordpress.org/resource/dashicons/)
        9                   // Menu position
    );
    add_submenu_page(
        'certificates',
        'All Certificates',
        'All Cetificates',
        'manage_options',
        'all-certificates',
        'all_certificate_callback'
    );
}

//Admin Menu Call
add_action('admin_menu', 'tiny_schoolars_call_function_for_admin_widget_menu');

// Callback function to display the page content


function tiny_schoolars_page_content()
{
?>
    <div class="wrap">

        <h2>Add a new certificate</h2>
        <div class="subject-container">

            <div class="container">
                <div class="row position-relative">

                    <div class="spiner">
                        <div class="spinning"></div>
                        <p class="text mt-5">Adding the Certificate</p>
                    </div>


                    <form action="">
                        <div class="form-row mb-3">
                            <label class="form-label">Certificate ID</label>
                            <input type="text" id="certificae-id" class="form-control" placeholder="e.g 15465487654">
                        </div>
                        <div class="form-row mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" id="name" class="form-control" placeholder="e.g Shakib Shown">
                        </div>
                        <div class="form-row mb-3">
                            <label class="form-label">Date of birth</label>
                            <input type="date" id="dob" class="form-control" placeholder="e.g 16 July 2024">
                        </div>
                        <div class="form-row mb-3">
                            <label class="form-label">Course Name</label>
                            <input type="text" id="course_name" class="form-control" placeholder="e.g Becholor of Science">
                        </div>
                        <div class="form-row mb-3">
                            <label class="form-label">Issue Date</label>
                            <input type="date" id="issue" class="form-control" placeholder="e.g 16 July 2024">
                        </div>
                        <div class="form-row mb-3">
                            <label class="form-label">Expire Date</label>
                            <input type="date" id="expire" class="form-control" placeholder="e.g 16 July 2024">
                        </div>
                        <p class="error text-danger">
                            PLeae Enter All Details
                        </p>

                        <div class="btn btn-primary add-new-certificate">Add New Certificate</div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
}


function all_certificate_callback()
{
?>

    <div class="wrap">
        <div class="container">
            <div class="row">
                <div class="table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>DOB</th>
                                <th>Course Name</th>
                                <th>Issue Date</th>
                                <th>Expire Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            global $wpdb;
                            // Define the table name
                            $table_name = $wpdb->prefix . 'certificate_details';


                            // Get all rows from the table
                            $rows = $wpdb->get_results("SELECT * FROM $table_name");

                            // Echo the id column for each row
                            foreach ($rows as $row) {
                               //echo $row->id . '<br>';
                                ?> 

                                <tr>
                                    <td><?php echo $row->certi_id; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->dob; ?></td>
                                    <td><?php echo $row->course_name; ?></td>
                                    <td><?php echo $row->issue_date; ?></td>
                                    <td><?php echo $row->expire_date; ?></td>
                                   
                                </tr>
                                
                                
                                <?php 
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


<?php
}
