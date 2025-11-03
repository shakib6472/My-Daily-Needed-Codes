<?php
/**
 * Elementor Hello World Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */ 
class Hello_World_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Hello World widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Hello World';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Hello World widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Custom Flip Box', 'boilerplate-elementor-extension' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Hello World widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fas fa-bullhorn';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Hello World widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Register Hello World widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Front Settings', 'boilerplate-elementor-extension' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'front_bg',
			[
				'label' => esc_html__( 'Front BG', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #flip-card .flip-card-front, #flip-card .flip-card-back' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'f_heading_color',
			[
				'label' => esc_html__( 'Front heading', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} h1.rp-flip-heading.rp-white' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'f_btn_bg',
			[
				'label' => esc_html__( 'Btn bg', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rp-flip-btn' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'f_btn_bg_hover',
			[
				'label' => esc_html__( 'Btn bg hover', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rp-flip-btn:hover' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'f_btn_text',
			[
				'label' => esc_html__( 'Btn Text', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rp-flip-btn' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'f_btn_text_border',
			[
				'label' => esc_html__( 'Btn border', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rp-flip-btn' => 'border: 4px solid {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'front_title',
			[
				'label' => __( 'Front Heading', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Social Marketer', 'boilerplate-elementor-extension' ),
				'default' => 'Social Marketing',
			]
        );

		$this->add_control(
			'front_image',
			[
				'label' => esc_html__( 'Choose Image', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
        
		$this->add_control(
			'front_button_text',
			[
				'label' => __( 'Button Text', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Get Demo ID', 'boilerplate-elementor-extension' ),
				'default' => 'Get Demo ID',
			]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section2',
			[
				'label' => __( 'Back Settings', 'boilerplate-elementor-extension' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'h_bg',
			[
				'label' => esc_html__( 'back bg', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #flip-card .flip-card-back' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'h_bg_btn',
			[
				'label' => esc_html__( 'button bg', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #flip-card-btn-turn-to-front' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'h_bg_btn_hover',
			[
				'label' => esc_html__( 'button hover', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #flip-card-btn-turn-to-front' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'h_btn_color',
			[
				'label' => esc_html__( 'button text', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a#flip-card-btn-turn-to-front' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'back_title',
			[
				'label' => __( 'Back Heading', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Demo ID', 'boilerplate-elementor-extension' ),
				'default' => 'Demo ID',
			]
        );

		$this->add_control(
			'back_username',
			[
				'label' => __( 'Username', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Username', 'boilerplate-elementor-extension' ),
			]
        );

		$this->add_control(
			'back_password',
			[
				'label' => __( 'Password', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Password', 'boilerplate-elementor-extension' ),
			]
        );

        
		$this->add_control(
			'back_button_text',
			[
				'label' => __( 'Button Text', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Get Demo ID', 'boilerplate-elementor-extension' ),
				'default' => 'Get Demo ID',
			]
        );

		$this->add_control(
			'back_button_url',
			[
				'label' => __( 'Button url', 'boilerplate-elementor-extension' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Get Demo ID', 'boilerplate-elementor-extension' ),
				'default' => '#',
			]
        );

		$this->end_controls_section();
	}

	/**
	 * Render Hello World widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		?>
		
		
		<div id="flip-card">
        <div class="flip-card-front">
            <h1 class="rp-flip-heading rp-white"><?php echo $settings['front_title']; ?></h1>
			<?php echo '<img src="' . $settings['front_image']['url'] . '">';?>

            <button class="rp-flip-btn" id="flip-card-btn-turn-to-back"><?php echo $settings['front_button_text']; ?></button>
        </div>
        <div class="flip-card-back">
            <h1 class="rp-flip-heading rp-white"><?php echo $settings['back_title']; ?></h1>
            <div class="container-info">
                <div class="login-data">
                    <div class="info-wrapper">
                        <span>Username-</span>
                        <label id="labelToCopy"><?php echo $settings['back_username']; ?></label>
                    </div>
                    <button onclick="copyToClipboard()">Copy</button>

                </div>
                <div class="login-data">
                    <div class="info-wrapper">
                        <span>Password-</span>
                        <label id="labelToCopy2"><?php echo $settings['back_password']; ?></label>
                    </div>
                    <button onclick="copyToClipboard2()">Copy</button>
                </div>
            </div>
            <a  target="_blank" href="<?php echo $settings['back_button_url']; ?>" class="rp-flip-btn rp-back-btn" id="flip-card-btn-turn-to-front"><?php echo $settings['back_button_text']; ?></a>
        </div>
    </div>
		
		
		<?;

	}

}