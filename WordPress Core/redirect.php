add_action('template_redirect', function () {
    if (trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') === 'profile') {
        wp_safe_redirect(home_url('/dashboard/'), 301);
        exit;
    }
});
