<?php 


// [child_terms taxonomy="category" parent="123" hide_empty="0" orderby="name" order="ASC" no_message="No Sub States for this Country"]
add_shortcode('child_terms', function ($atts) {
	$atts = shortcode_atts(array(
		'taxonomy' => 'category',
		'parent' => '',
		'hide_empty' => '0',  
		'orderby' => 'name',
		'order' => 'ASC',
		'no_message' => 'No Sub States for this Country',
	), $atts, 'child_terms');
	$tax = sanitize_key($atts['taxonomy']);

	// Resolve parent term ID
	$parent_id = 0;
	if (is_numeric($atts['parent']) && (int) $atts['parent'] > 0) {
		$parent_id = (int) $atts['parent'];
	}
	if (!$parent_id)
		return '<div class="ss-child-terms ss-error">' . esc_html($atts['no_message']) . '</div>';

	// Query only direct children of parent
	$terms = get_terms(array(
		'taxonomy' => $tax,
		'parent' => $parent_id,
		'hide_empty' => (int) $atts['hide_empty'],
		'orderby' => sanitize_key($atts['orderby']),
		'order' => (strtoupper($atts['order']) === 'DESC') ? 'DESC' : 'ASC',
	));
	if (is_wp_error($terms) || empty($terms)) {
		return '<div class="ss-child-terms ss-empty">' . esc_html($atts['no_message']) . '</div>';
	} 
	ob_start();
	foreach ($terms as $term) {

		$link = get_term_link($term);
		?>
		<div class="elementor-element elementor-element-21a9b6a elementor-align-justify elementor-widget elementor-widget-button"
			data-id="21a9b6a" data-element_type="widget" data-widget_type="button.default">
			<a class="elementor-button elementor-button-link elementor-size-sm elementor-animation-shrink"
				href="<?php echo esc_url($link); ?>">
				<span class="elementor-button-content-wrapper">
					<span class="elementor-button-text"><?php echo esc_html($term->name); ?> (
						<?php echo esc_html($term->count); ?> )</span>
					<span class="elementor-button-icon">
						<svg aria-hidden="true" class="e-font-icon-svg e-fas-angle-right" viewBox="0 0 256 512"
							xmlns="http://www.w3.org/2000/svg">
							<path
								d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z">
							</path>
						</svg>
					</span>
				</span>
			</a>
		</div>
	<?php
	} 
	return ob_get_clean();
});


?> 
