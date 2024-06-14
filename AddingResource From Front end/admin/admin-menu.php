<?php

function tiny_scholars_enqueue_admin_scripts() {
    // Enqueue jQuery (it's already included with WordPress)
    wp_enqueue_script('jquery');

    // Enqueue Bootstrap CSS
    wp_enqueue_style('tiny-scholars-bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2');
    // Enqueue Font Awesome
    wp_enqueue_script('tiny-scholars-font-awesome', 'https://kit.fontawesome.com/46882cce5e.js', array(), null, true);
}

// Hook into the admin_enqueue_scripts action
add_action('admin_enqueue_scripts', 'tiny_scholars_enqueue_admin_scripts');



// Add Tutor's Subjects Admin Menu
function tiny_schoolars_call_function_for_admin_widget_menu()
{
    add_menu_page(
        'Tiny Schoolars', // Page title
        'Tiny Schoolars', // Menu title
        'manage_options',    // Capability required to access the menu
        'tiny-schoolars',   // Menu slug
        'tiny_schoolars_page_content', // Callback function to display the page content
        'dashicons-flag',    // Icon for the menu (you can choose from Dashicons: https://developer.wordpress.org/resource/dashicons/)
        9                   // Menu position
    );

    add_submenu_page(
        'tiny-schoolars',
        'Announcement',
        'Announcement',
        'manage_options',
        'announcement',
        'tiny_anouncement_callback_function',
        10
    );
    add_submenu_page(
        'tiny-schoolars',
        'Add New Announcement',
        'Add New Announcement',
        'manage_options',
        'add-new-announcement',
        'tiny_add_new_anouncement_callback_function',
        10
    );
}

//Admin Menu Call
add_action('admin_menu', 'tiny_schoolars_call_function_for_admin_widget_menu');

// Callback function to display the page content


function tiny_schoolars_page_content()
{
?>
<div class="wrap">
    <style>
        .gridbox-box-items {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-template-rows: 1fr;
            grid-column-gap: 25px;
            grid-row-gap: 25px;
        }

        .gridbox-box-items .card {
            border: 1px solid #efefee;
            padding: 30px;
            display: grid;
            place-items: center;
        }
        .gridbox-box-items .card i{
            font-size: 30px;
            margin-bottom: 25px;
            color: #493A81;
            text-decoration: none;
        }
        .gridbox-box-items a{
            font-size: 21px;
            font-family: 'Poppins';
            color: #493A81;
            text-decoration: none;

        }
        .gridbox-box-items .card h3{
            font-size: 21px;
            font-family: 'Poppins';
            color: #493A81;
            text-decoration: none;

        }
    </style>
    <h2>Tiny Schoolars Admin Dashboard</h2>
  
        <div class="subject-container">
        <div class="container">
            <div class="row">
                <div class="gridbox-box-items">
                    <div class="item">
                        <a href="">
                        <div class="card">
                            <i class="fas fa-bullhorn"></i>
                            <h3>Annoucements</h3>
                        </div>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}

function tiny_anouncement_callback_function()
{

    require_once(__DIR__ . '\template-parts\announcements.php');
}

function tiny_add_new_anouncement_callback_function(){
    
    require_once(__DIR__ . '\template-parts\add-new-annoucement.php');
}