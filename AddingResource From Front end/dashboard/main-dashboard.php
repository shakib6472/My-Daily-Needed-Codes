<?php
class Elementor_tiny_tutor_main_dashboard_elementor extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'tiny-main-dashboard';
    }

    public function get_title()
    {
        return esc_html__('tiny Dashboard', 'boikotha');
    }

    public function get_icon()
    {
        return 'eicon-slider-album';
    }
    protected function _register_controls()
    {

        $this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Dashboard Item', 'tinyschoolars' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'dashboard-item',
			[
				'label' => esc_html__( 'Dashboard Item', 'tinyschoolars' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'dashboard',
				'options' => [
					'resource' => esc_html__( 'Resource', 'tinyschoolars' ),
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
        return ['dash', 'Dashboard'];
    }

    protected function render()
    {

        $settings = $this->get_settings();


        require_once(__DIR__ . '/head.php');

        // Now you can create an instance of the Left_menu class
        $value = $settings['dashboard-item']; // Pass the value you want to check against
        // Pagination.
        $per_page = 6;
        $offset   = 0;

        require_once(__DIR__ . '/parts/'.$value .'.php');


    }
}
