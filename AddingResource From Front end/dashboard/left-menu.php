<?php

class Menu_bar
{
    private $value;

    function __construct($value)
    {
        $this->value = $value;
        $this->do_the_menu_bar_with_condition();
    }

    private function echo_active($name)
    {
        if ($name == $this->value) {
            echo 'active';
        }
    }

    private function do_the_menu_bar_with_condition()
    {
        ob_start();



?>

        <script src='https://kit.fontawesome.com/46882cce5e.js' crossorigin='anonymous'></script>

        <style>
            .tutor-dashboard .tutor-dashboard-left-menu .tutor-dashboard-menu-item {
                margin-bottom: 5px;
                border-bottom: 0.5px solid #efefef;
                border-left: 0.5px solid #ebebeb;
            }

            .tutor-dashboard .image-icon {
                width: 38px;
                margin-right: 0px;
                margin-top: -2px;
            }

            .tutor-dashboard .tutor-dashboard-left-menu .tutor-dashboard-menu-item-icon {
                font-size: 25px;
                margin-right: 5px;
            }
        </style>

        <div class="tutor-col-12 tutor-col-md-4 tutor-col-lg-3 tutor-dashboard-left-menu">
            <ul class="tutor-dashboard-permalinks">
                <div class="menu-box">
                    <li class="tutor-dashboard-menu-item tutor-dashboard-menu-index <?php $this->echo_active('introduction') ?>">
                        <a href="<?php echo home_url('/dashboard/introduction'); ?>" class="tutor-dashboard-menu-item-link tutor-fs-6 tutor-color-black">

                            <i class="fab fa-youtube"></i>
                            <span class="tutor-dashboard-menu-item-text tutor-ml-12">
                                Introduction </span>
                        </a>
                    </li>
                    <?php
                    if (return_on_based_user_role('parent')) {
                    ?>


                        <li class="tutor-dashboard-menu-item tutor-dashboard-menu-index <?php $this->echo_active('my-students') ?>">
                            <a href="<?php echo home_url('/dashboard/my-students'); ?>" class="tutor-dashboard-menu-item-link tutor-fs-6 tutor-color-black">

                                <i class="fa-solid fa-graduation-cap"></i>
                                <span class="tutor-dashboard-menu-item-text tutor-ml-12">
                                    My Students </span>
                            </a>
                        </li>

                    <?php

                    }

                    ?>
                   <li class="tutor-dashboard-menu-item tutor-dashboard-menu-index <?php $this->echo_active('resource') ?>">
                            <a href="<?php echo home_url('/dashboard/resources'); ?>" class="tutor-dashboard-menu-item-link tutor-fs-6 tutor-color-black">
                                <i class="fa-solid fa-folder-open"></i>
                                <span class="tutor-dashboard-menu-item-text tutor-ml-12">
                                    Resources </span>
                            </a>
                        </li>

                   
                    <li class="tutor-dashboard-menu-item tutor-dashboard-menu-logout <?php $this->echo_active('logout') ?>">
                        <a data-no-instant="" href="<?php echo wp_logout_url(); ?>" class="tutor-dashboard-menu-item-link tutor-fs-6 tutor-color-black">
                            <span class="tutor-icon-signout tutor-dashboard-menu-item-icon"></span> <span class="tutor-dashboard-menu-item-text tutor-ml-12">
                                Logout </span>
                        </a>
                    </li>

                </div>
            </ul>
        </div>

<?php

        // Get the buffered content and echo it
        echo ob_get_clean();
    }
}


// // Usage:
// $value = "courses"; // Pass the value you want to check against
// $leftMenu = new Left_menu($value);