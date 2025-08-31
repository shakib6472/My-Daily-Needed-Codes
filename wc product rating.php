// Add this code to your theme's functions.php or a custom plugin
function shakib_product_rating_shortcode( $atts ) {
    global $product;

    // If inside product loop, get the current ID
    $post_id = get_the_ID();
    $product = wc_get_product( $post_id );

    if ( ! $product ) {
        return '';
    }

    $average   = $product->get_average_rating();
    $fullStars = floor( $average );
    $halfStar  = ( $average - $fullStars ) >= 0.5 ? 1 : 0;

    $output = '';

    // Full stars
    for ( $i = 1; $i <= $fullStars; $i++ ) {
        $output .= '<span class="star full">★</span>';
    }

    // Half star
    if ( $halfStar ) {
        $output .= '<span class="star half">☆</span>';
    }

    return $output;
}
add_shortcode( 'product_rating', 'shakib_product_rating_shortcode' );
