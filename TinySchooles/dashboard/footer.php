<?php

class footer_menu
{


    function __construct()
    {
        ob_start();
?>

        <!-- <div id="tutor-dashboard-footer-mobile">
            <div class="tutor-container">
                <div class="tutor-row ">
                    <a class="tutor-col-8 " href="<?php // echo home_url(''); 
                                                    ?>" style="text-align: left;">
                        <img style=" text-align:start; width: 50%;" src="https://uktalearninghub.com/wp-content/uploads/2024/04/WhatsApp-Image-2024-04-20-at-9.28.00-PM.jpeg" alt="">
                    </a>

                    <a class="tutor-col-4 " href="#">
                        <i class="ttr tutor-icon-hamburger-o tutor-dashboard-menu-toggler"></i>
                        <span>Menu</span>
                    </a>
                </div>
            </div>
        </div>
       --> 


<?php
        // Get the buffered content and echo it
        echo ob_get_clean();
    }
}


// // Usage:
// $value = "courses"; // Pass the value you want to check against
// $leftMenu = new Left_menu($value);

