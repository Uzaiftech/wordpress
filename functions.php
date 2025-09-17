<?php
/**
 * Festa Ceylon WP Theme Functions
 *
 * @package Festa_Ceylon_WP
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme version
define('FESTA_CEYLON_VERSION', '1.0.0');

// Theme setup
function festa_ceylon_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    
    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'festa-ceylon-wp'),
        'footer'  => esc_html__('Footer Menu', 'festa-ceylon-wp'),
    ));
    
    // Set content width
    $GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'festa_ceylon_setup');

// Enqueue scripts and styles
function festa_ceylon_scripts() {
    // Bootstrap CSS
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2');
    
    // Bootstrap Icons
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css', array(), '1.11.1');
    
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null);
    
    // Theme stylesheet
    wp_enqueue_style('festa-ceylon-style', get_stylesheet_uri(), array('bootstrap'), FESTA_CEYLON_VERSION);
    
    // Custom CSS
    wp_enqueue_style('festa-ceylon-custom', get_template_directory_uri() . '/assets/css/main.css', array('festa-ceylon-style'), FESTA_CEYLON_VERSION);
    
    // Bootstrap JS
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array(), '5.3.2', true);
    
    // Theme JS
    wp_enqueue_script('festa-ceylon-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'bootstrap'), FESTA_CEYLON_VERSION, true);
    
    // Localize script for AJAX
    wp_localize_script('festa-ceylon-main', 'festa_ceylon_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('festa_ceylon_nonce'),
    ));
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'festa_ceylon_scripts');

// Register widget areas
function festa_ceylon_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'festa-ceylon-wp'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'festa-ceylon-wp'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 1', 'festa-ceylon-wp'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here.', 'festa-ceylon-wp'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 2', 'festa-ceylon-wp'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here.', 'festa-ceylon-wp'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 3', 'festa-ceylon-wp'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add widgets here.', 'festa-ceylon-wp'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 4', 'festa-ceylon-wp'),
        'id'            => 'footer-4',
        'description'   => esc_html__('Add widgets here.', 'festa-ceylon-wp'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ));
}
add_action('widgets_init', 'festa_ceylon_widgets_init');

// Include theme setup files
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/woocommerce.php';

// Customizer additions
function festa_ceylon_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('festa_ceylon_hero', array(
        'title'    => __('Hero Section', 'festa-ceylon-wp'),
        'priority' => 30,
    ));
    
    // Hero Title
    $wp_customize->add_setting('festa_ceylon_hero_title', array(
        'default'           => 'Premium Fabrics & Textile Artistry',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('festa_ceylon_hero_title', array(
        'label'   => __('Hero Title', 'festa-ceylon-wp'),
        'section' => 'festa_ceylon_hero',
        'type'    => 'text',
    ));
    
    // Hero Description
    $wp_customize->add_setting('festa_ceylon_hero_description', array(
        'default'           => 'Discover our curated collection of luxury fabrics sold by the meter and exquisite ready-made textile products crafted with precision.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('festa_ceylon_hero_description', array(
        'label'   => __('Hero Description', 'festa-ceylon-wp'),
        'section' => 'festa_ceylon_hero',
        'type'    => 'textarea',
    ));
    
    // Hero Button Text
    $wp_customize->add_setting('festa_ceylon_hero_button_text', array(
        'default'           => 'Shop Collection',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('festa_ceylon_hero_button_text', array(
        'label'   => __('Hero Button Text', 'festa-ceylon-wp'),
        'section' => 'festa_ceylon_hero',
        'type'    => 'text',
    ));
    
    // Hero Button URL
    $wp_customize->add_setting('festa_ceylon_hero_button_url', array(
        'default'           => '/shop',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('festa_ceylon_hero_button_url', array(
        'label'   => __('Hero Button URL', 'festa-ceylon-wp'),
        'section' => 'festa_ceylon_hero',
        'type'    => 'url',
    ));
    
    // Contact Information Section
    $wp_customize->add_section('festa_ceylon_contact', array(
        'title'    => __('Contact Information', 'festa-ceylon-wp'),
        'priority' => 35,
    ));
    
    // Email
    $wp_customize->add_setting('festa_ceylon_email', array(
        'default'           => 'hello@textilestudio.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('festa_ceylon_email', array(
        'label'   => __('Email Address', 'festa-ceylon-wp'),
        'section' => 'festa_ceylon_contact',
        'type'    => 'email',
    ));
    
    // Phone
    $wp_customize->add_setting('festa_ceylon_phone', array(
        'default'           => '+1 (555) 123-4567',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('festa_ceylon_phone', array(
        'label'   => __('Phone Number', 'festa-ceylon-wp'),
        'section' => 'festa_ceylon_contact',
        'type'    => 'text',
    ));
    
    // Address
    $wp_customize->add_setting('festa_ceylon_address', array(
        'default'           => '123 Fabric Street, Design District',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('festa_ceylon_address', array(
        'label'   => __('Address', 'festa-ceylon-wp'),
        'section' => 'festa_ceylon_contact',
        'type'    => 'text',
    ));
    
    // Social Media Section
    $wp_customize->add_section('festa_ceylon_social', array(
        'title'    => __('Social Media', 'festa-ceylon-wp'),
        'priority' => 40,
    ));
    
    // Facebook URL
    $wp_customize->add_setting('festa_ceylon_facebook', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('festa_ceylon_facebook', array(
        'label'   => __('Facebook URL', 'festa-ceylon-wp'),
        'section' => 'festa_ceylon_social',
        'type'    => 'url',
    ));
    
    // Instagram URL
    $wp_customize->add_setting('festa_ceylon_instagram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('festa_ceylon_instagram', array(
        'label'   => __('Instagram URL', 'festa-ceylon-wp'),
        'section' => 'festa_ceylon_social',
        'type'    => 'url',
    ));
    
    // Twitter URL
    $wp_customize->add_setting('festa_ceylon_twitter', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('festa_ceylon_twitter', array(
        'label'   => __('Twitter URL', 'festa-ceylon-wp'),
        'section' => 'festa_ceylon_social',
        'type'    => 'url',
    ));
}
add_action('customize_register', 'festa_ceylon_customize_register');

// Add cart count to header
function festa_ceylon_cart_count() {
    if (class_exists('WooCommerce')) {
        $count = WC()->cart->get_cart_contents_count();
        return $count;
    }
    return 0;
}

// AJAX cart count update
function festa_ceylon_update_cart_count() {
    check_ajax_referer('festa_ceylon_nonce', 'nonce');
    
    $count = festa_ceylon_cart_count();
    wp_send_json_success(array('count' => $count));
}
add_action('wp_ajax_festa_ceylon_update_cart_count', 'festa_ceylon_update_cart_count');
add_action('wp_ajax_nopriv_festa_ceylon_update_cart_count', 'festa_ceylon_update_cart_count');

// WooCommerce cart fragments
function festa_ceylon_cart_fragments($fragments) {
    $count = festa_ceylon_cart_count();
    
    ob_start();
    ?>
    <span class="cart-count badge bg-primary rounded-pill"><?php echo esc_html($count); ?></span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();
    
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'festa_ceylon_cart_fragments');

// Custom excerpt length
function festa_ceylon_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'festa_ceylon_excerpt_length');

// Custom excerpt more
function festa_ceylon_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'festa_ceylon_excerpt_more');

// Add custom body classes
function festa_ceylon_body_classes($classes) {
    // Add class for WooCommerce pages
    if (class_exists('WooCommerce')) {
        if (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) {
            $classes[] = 'woocommerce-page';
        }
    }
    
    // Add class for front page
    if (is_front_page()) {
        $classes[] = 'front-page';
    }
    
    return $classes;
}
add_filter('body_class', 'festa_ceylon_body_classes');

// Remove WooCommerce default styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Custom pagination
function festa_ceylon_pagination() {
    global $wp_query;
    
    if ($wp_query->max_num_pages <= 1) {
        return;
    }
    
    $big = 999999999;
    
    echo '<nav class="pagination-wrapper" aria-label="Page navigation">';
    echo '<ul class="pagination justify-content-center">';
    
    echo paginate_links(array(
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => max(1, get_query_var('paged')),
        'total'     => $wp_query->max_num_pages,
        'type'      => 'list',
        'prev_text' => '<i class="bi bi-chevron-left"></i>',
        'next_text' => '<i class="bi bi-chevron-right"></i>',
    ));
    
    echo '</ul>';
    echo '</nav>';
}

// Security enhancements
function festa_ceylon_security_headers() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
}
add_action('send_headers', 'festa_ceylon_security_headers');

// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');