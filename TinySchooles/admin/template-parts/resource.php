<style>
    .archive-gridbox {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        grid-column-gap: 25px;
        grid-row-gap: 20px;
    }

    .archive-gridbox .item {
        background-color: #fff0;
        position: relative;
        border-radius: 6px;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        height: 100%;
        justify-content: center;
        align-items: center;
        /* border: 1px solid #e6e6e6; */
        padding: 15px;
    }
    .archive-gridbox .item .buttonss{
        opacity: 0;
        transition: all 0.4s;
    }
    .archive-gridbox .item:hover .buttonss{
        opacity: 1;
    }

    .archive-gridbox .item a {
        color: #000;
        text-decoration: none;
        text-align: center;
    }

    .archive-gridbox .item a .texts h6 {
        color: #000;
        text-decoration: none;
        text-align: center;
        font-size: 24px;
        padding: 20px 0 0 0;
    }

    .archive-gridbox .item .image {
        overflow: hidden;
    }

    .archive-gridbox .item .image img {
        max-width: 100%;
        width: 100%;
        height: 180px;
        border-radius: 9px;
        border: 1px solid #e6e6e6;
        margin-bottom: 8px;
        transition: all 0.4s;
    }

    .archive-gridbox .item .image img:hover {
        scale: 1.2;
    }

    body .tutor-dashboard .tutor-dashboard-content .tutor-capitalize-text {
        text-transform: capitalize;
        display: inline-block;
    }

    .box-for-each {
        border-top: 3px solid #000000;
        border-bottom: 3px solid #000000;
        padding: 30px;
    }

    .row .tutor-fs-5.tutor-fw-medium.tutor-color-black.tutor-mb-24 {
        text-decoration: none;
        font-size: 51px;
        font-weight: 800;
    }
</style>







<div class="row">
    <div class="col-md-12">
        <div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24 "><?php esc_html_e('Videos', 'tutor'); ?></div>


        <div class="archive-gridbox">

            <?php

            $args = array(
                'post_type' => 'resource', // Post-type key
                'posts_per_page' => -1, // -1 retrieves all posts
                //include taxanomy texonomoy is Resouce type. & filter by video texonomy
                'tax_query' => array(
                    array(
                        'taxonomy' => 'resource-type', // Taxonomy name
                        'field' => 'slug', // Use 'slug' to specify term by its slug
                        'terms' => 'video', // Term slug to filter by
                    ),
                ),
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $post_id = get_the_ID();
                    $post_title = get_the_title($post_id);
                    $post_thumbnail_id = get_post_thumbnail_id($post_id);
                    $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                    $url = get_permalink($post_id);

            ?>

                    <div class="item">
                        <a href="<?php echo $url; ?>">
                            <div class="image">
                                <img src="<?php echo $post_thumbnail_url; ?>" alt="">
                            </div>
                            <div class="texts">
                                <div class="headline">
                                    <h6><?php echo $post_title; ?></h6>
                                </div>
                            </div>
                        </a>
                        <?php if (return_on_based_user_role('administrator')) {
                        ?>
                            <div class="buttonss">
                                <div class="btn btn-danger delete-resource-item--ajax" data-post-id="<?php echo $post_id; ?>">Delete</div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                <?php
                }
                ?>
                <div class="item"></div>
                <div class="item"></div>
                <div class="item"></div>

            <?php
                // Restore original post data
                wp_reset_postdata();
            } else {
                // No posts found
                echo 'No VIdeos found';
            }


            ?>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12">
        <div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24 "><?php esc_html_e('PDFs', 'tutor'); ?></div>


        <div class="archive-gridbox">

            <?php

            $args = array(
                'post_type' => 'resource', // Post-type key
                'posts_per_page' => -1, // -1 retrieves all posts
                //include taxanomy texonomoy is Resouce type. & filter by video texonomy
                'tax_query' => array(
                    array(
                        'taxonomy' => 'resource-type', // Taxonomy name
                        'field' => 'slug', // Use 'slug' to specify term by its slug
                        'terms' => 'pdf', // Term slug to filter by
                    ),
                ),
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $post_id = get_the_ID();
                    $post_title = get_the_title($post_id);
                    $post_thumbnail_id = get_post_thumbnail_id($post_id);
                    $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                    $url = get_permalink($post_id);

            ?>

                    <div class="item">
                        <a href="<?php echo $url; ?>">
                            <div class="image">
                                <img src="<?php echo $post_thumbnail_url; ?>" alt="">
                            </div>
                            <div class="texts">
                                <div class="headline">
                                    <h6><?php echo $post_title; ?></h6>
                                </div>

                            </div>
                        </a>
                        <?php if (return_on_based_user_role('administrator')) {
                        ?>
                            <div class="buttonss">
                                <div class="btn btn-danger delete-resource-item--ajax" data-post-id="<?php echo $post_id; ?>">Delete</div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                <?php
                }
                ?>
                <div class="item"></div>
                <div class="item"></div>
                <div class="item"></div>

            <?php
                // Restore original post data
                wp_reset_postdata();
            } else {
                // No posts found
                echo 'No PDFs found';
            }


            ?>
        </div>
    </div>
</div>


<div class="row mt-5">
    <div class="col-md-12">
        <div class="tutor-fs-5 tutor-fw-medium tutor-color-black  tutor-mb-24"><?php esc_html_e('Useful Links', 'tutor'); ?></div>
        <div class="archive-gridbox">

            <?php

            $args = array(
                'post_type' => 'resource', // Post-type key
                'posts_per_page' => -1, // -1 retrieves all posts
                //include taxanomy texonomoy is Resouce type. & filter by video texonomy
                'tax_query' => array(
                    array(
                        'taxonomy' => 'resource-type', // Taxonomy name
                        'field' => 'slug', // Use 'slug' to specify term by its slug
                        'terms' => 'useful-link', // Term slug to filter by
                    ),
                ),
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $post_id = get_the_ID();
                    $post_title = get_the_title($post_id);
                    $post_thumbnail_id = get_post_thumbnail_id($post_id);
                    $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                    $url = get_permalink($post_id);

            ?>

                    <div class="item">
                        <a href="<?php echo $url; ?>">
                            <div class="image">
                                <img src="<?php echo $post_thumbnail_url; ?>" alt="">
                            </div>
                            <div class="texts">
                                <div class="headline">
                                    <h6><?php echo $post_title; ?></h6>
                                </div>

                            </div>
                        </a>
                        <?php if (return_on_based_user_role('administrator')) {
                        ?>
                            <div class="buttonss">
                                <div class="btn btn-danger delete-resource-item--ajax" data-post-id="<?php echo $post_id; ?>">Delete</div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                <?php
                }
                ?>
                <div class="item"></div>
                <div class="item"></div>
                <div class="item"></div>

            <?php
                // Restore original post data
                wp_reset_postdata();
            } else {
                // No posts found
                echo 'No Usefull Links Found';
            }


            ?>
        </div>
    </div>
</div>