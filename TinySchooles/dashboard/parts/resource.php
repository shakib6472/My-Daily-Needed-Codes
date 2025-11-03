<div class="tutor-row tutor-frontend-dashboard-maincontent">
    <?php $leftMenu = new Menu_bar($value); ?>

    <div class="tutor-col-12 tutor-col-md-8 tutor-col-lg-9">
        <div class="tutor-dashboard-content">
            <!-- Section Titel -->
            <div class="d-flex justify-content-between align-items-start">

                <div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-capitalize-text tutor-mb-24 tutor-dashboard-title"><?php esc_html_e('', 'tutor'); ?></div>

                <?php

                if (return_on_based_user_role('administrator')) {
                ?>
                    <div class="buttons">
                        <div class="btn btn-success add-new-resouce">Add New Resource</div>
                    </div>
                <?php

                }
                ?>
            </div>

            <?php

            if (return_on_based_user_role('administrator')) {
            ?>
                <style>
                    .hidden {
                        display: none;
                    }

                    .buttons {
                        margin-bottom: 5%;
                    }

                    .tutor-dashboard .tutor-dashboard-content .tutor-capitalize-text .tutor-dashboard-title {
                        text-transform: capitalize;
                        border-bottom: 2px solid #2B7F58;
                    }
                </style>
                <div class="hidden">

                    <?php
                    $plugins_dir_path = WP_PLUGIN_DIR;
                    require_once($plugins_dir_path . '/tiny-schoolars/admin/template-parts/add-a-new-resource.php');
                    ?>

                </div>
            <?php
            }
            ?>




            <!-- Section Contents -->
            <?php
            $plugins_dir_path = WP_PLUGIN_DIR;
            require_once($plugins_dir_path . '/tiny-schoolars/admin/template-parts/resource.php');
            ?>
        </div>

    </div>
</div>
</div>
</div>
<?php $footer = new footer_menu(); ?>
</div>



<script>
    jQuery(document).ready(function($) {
        $('.buttons .add-new-resouce').click(function(e) {
            e.preventDefault();
            $(this).text(function(_, oldText) {
                return oldText === 'Add New Resource' ? 'Close' : 'Add New Resource';
            });
            $(this).toggleClass('btn-success btn-danger');
            $('.hidden').toggle(500);
            $('.d.hidden').hide(500);

        });
        
        
        

    });
</script>


