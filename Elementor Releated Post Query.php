function releted_post_query($query) {
    // Get current post ID
    $post_id = get_the_ID();

    // Get current post categories
    $categories = wp_get_post_categories($post_id);

    // Proceed only if categories exist
    if (!empty($categories)) {
        $query->set('category__in', $categories); // Include posts from same categories
        $query->set('post__not_in', array($post_id)); // Exclude current post
        $query->set('posts_per_page', 6); // Optional: limit number of related posts
    }
}

add_action('elementor/query/releted_post_query', 'releted_post_query');
