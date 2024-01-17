<?php
class Elementor_spitznagel_news_arcive extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'news-arcive';
    }

    public function get_title()
    {
        return esc_html__('News Archive Slider', 'spitznagel');
    }

    public function get_icon()
    {
        return 'eicon-slide';
    }
    protected function register_controls()
    {
        // <script src="https://kit.fontawesome.com/46882cce5e.js" crossorigin="anonymous"></script>
        //Adding Css & JS
        wp_enqueue_style('news-arcive-form-css', plugin_dir_url(__FILE__) . 'news-arcive.css', [], '1.0.0', 'all');
        wp_enqueue_style('news-arcive-form-bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', [], '1.0.0', 'all');
        wp_enqueue_script('jquery');
        wp_enqueue_script('news-arcive-slick-jquery-form-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', [], '1.0.0', true);
        wp_enqueue_script('news-arcive-fa-y-form-js', 'https://kit.fontawesome.com/46882cce5e.js', [], '1.0.0', false);
        wp_enqueue_script('news-arcive-form-js', plugin_dir_url(__FILE__) . 'news-arcive.js', [], '1.0.0', true);
        //adding Controls

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'spitznagel'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'news-arcive-year',
            [

                'label' => esc_html__('Choose Year', 'spitznagel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '2024',
                'options' => [
                    '2023' => esc_html__('2023', 'spitznagel'),
                    '2024' => esc_html__('2024', 'spitznagel'),
                    '2025'  => esc_html__('2025', 'spitznagel'),
                    '2026' => esc_html__('2026', 'spitznagel'),
                    '2027' => esc_html__('2027', 'spitznagel'),
                    '2028' => esc_html__('2028', 'spitznagel'),
                ],

            ]
        );
        $this->add_control(
            'news-arcive-month',
            [

                'label' => esc_html__('Choose Month', 'spitznagel'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '01',
                'options' => [
                    '01' => esc_html__('January', 'spitznagel'),
                    '02' => esc_html__('February', 'spitznagel'),
                    '03' => esc_html__('March', 'spitznagel'),
                    '04' => esc_html__('April', 'spitznagel'),
                    '05' => esc_html__('May', 'spitznagel'),
                    '06' => esc_html__('June', 'spitznagel'),
                    '07' => esc_html__('July', 'spitznagel'),
                    '08' => esc_html__('August', 'spitznagel'),
                    '09' => esc_html__('September', 'spitznagel'),
                    '10' => esc_html__('October', 'spitznagel'),
                    '11' => esc_html__('November', 'spitznagel'),
                    '12' => esc_html__('December', 'spitznagel'),
                ],

            ]
        );

        $this->end_controls_section();
    }

    public function get_categories()
    {
        return ['basic'];
    }

    public function get_keywords()
    {
        return ['news', 'slide'];
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $args = array(
            'post_type'      => 'post', // Adjust post type as needed
            'posts_per_page' => -1,     // Retrieve all posts
            'date_query'     => array(
                array(
                    'year'  => intval($settings['news-arcive-year']),
                    'month' => intval($settings['news-arcive-month']),
                ),
            ),
        );

        $december2023_posts = new WP_Query($args);
?>
        <style>

        </style>

        <div class="containear">
            <div class="row category-slider  clearance-bestselling-category__list ">

                <?php

                if ($december2023_posts->have_posts()) {
                    while ($december2023_posts->have_posts()) {
                        $december2023_posts->the_post();
                        $original_text = "Blindtexte nennt man Texte, die bei der Produktion von Publikationen oder Webseiten als Platzhalter für spätere Inhalte stehen, wenn der eigentliche Text noch nicht vorhanden ist. Sie werden";
                        // Split the text into an array of words
                        $words = explode(' ', $original_text);
                        $max_words = 18;
                        $ellipsis = '...';

                        // Check if the number of words is greater than the maximum allowed
                        if (count($words) > $max_words) {
                            // Slice the array to only include the first $max_words elements
                            $words = array_slice($words, 0, $max_words);

                            // Join the words back together into a string
                            $text = implode(' ', $words);

                            // Append the ellipsis
                            $text .= $ellipsis;
                        }


                        $limited_text = $text;
                        // Your loop content here
                        $post_date = get_the_date('d/m/Y');
                ?>
                        <div class="post-items">
                            <div class="news-archive news-box">
                                <p class="date"><?php echo $post_date ?></p>
                                <h6 class="headline"><?php echo 'Headline'; //the_title(); 
                                                        ?></h6>
                                <p class="description"><?php echo $limited_text; ?></p>
                                <img class="button-image" src="https://constructserver.de/spitznagel.de/wp-content/uploads/2024/01/mehrerfahren.png" alt="">
                            </div>
                        </div>
                <?php
                    }
                    wp_reset_postdata(); // Reset the post data to the main loop
                } else {
                    echo 'No posts found in ' . intval($settings['news-arcive-month']) . '/' . intval($settings['news-arcive-year'])  . '.';
                }
                ?>
            </div>
        </div>


        <script>

        </script>
<?php
    }
}



?>