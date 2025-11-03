<?php
class Elementor_swagbulk_product_loop extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'swagbulk-single-due';
    }

    public function get_title()
    {
        return esc_html__('Product Single Due', 'swagbulk');
    }

    public function get_icon()
    {
        return 'fas fa-stop';
    }
    protected function _register_controls()
    {
    }

    public function get_categories()
    {
        return ['basic'];
    }

    public function get_keywords()
    {
        return ['product', 'due'];
    }

    protected function render()
    {

        $settings = $this->get_settings();
        // Get the current user's ID
        $user_id = get_current_user_id();

        // Get the due amount for the current user
        $due_amount = get_user_meta($user_id, 'due_amount', true);

        // Display the due amount if it exists
        if ($due_amount) {
            echo '<div class="">';
            echo '<h3 class="due amount product-single-page-a ">Due Amount: £' . esc_html($due_amount) . '</h3>';
            echo '</div>';
        }
    }
}
