<?php
/**
 * Theme Setup Functions
 *
 * @package Festa_Ceylon_WP
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add theme support for various WordPress features
 */
function festa_ceylon_theme_support() {
    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');
    
    // Add support for wide and full alignment
    add_theme_support('align-wide');
    
    // Add support for block editor color palette
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => esc_html__('Primary', 'festa-ceylon-wp'),
            'slug'  => 'primary',
            'color' => '#d97706',
        ),
        array(
            'name'  => esc_html__('Secondary', 'festa-ceylon-wp'),
            'slug'  => 'secondary',
            'color' => '#f97316',
        ),
        array(
            'name'  => esc_html__('Accent', 'festa-ceylon-wp'),
            'slug'  => 'accent',
            'color' => '#e5b100',
        ),
        array(
            'name'  => esc_html__('Dark', 'festa-ceylon-wp'),
            'slug'  => 'dark',
            'color' => '#374151',
        ),
        array(
            'name'  => esc_html__('Light', 'festa-ceylon-wp'),
            'slug'  => 'light',
            'color' => '#f8fafc',
        ),
    ));
    
    // Add support for custom font sizes
    add_theme_support('editor-font-sizes', array(
        array(
            'name' => esc_html__('Small', 'festa-ceylon-wp'),
            'size' => 14,
            'slug' => 'small'
        ),
        array(
            'name' => esc_html__('Regular', 'festa-ceylon-wp'),
            'size' => 16,
            'slug' => 'regular'
        ),
        array(
            'name' => esc_html__('Large', 'festa-ceylon-wp'),
            'size' => 20,
            'slug' => 'large'
        ),
        array(
            'name' => esc_html__('Extra Large', 'festa-ceylon-wp'),
            'size' => 24,
            'slug' => 'extra-large'
        )
    ));
}
add_action('after_setup_theme', 'festa_ceylon_theme_support');

/**
 * Add custom image sizes
 */
function festa_ceylon_image_sizes() {
    add_image_size('festa-product-thumb', 300, 300, true);
    add_image_size('festa-product-medium', 600, 600, true);
    add_image_size('festa-hero-image', 800, 600, true);
    add_image_size('festa-category-thumb', 400, 300, true);
}
add_action('after_setup_theme', 'festa_ceylon_image_sizes');

/**
 * Register custom post types if needed
 */
function festa_ceylon_custom_post_types() {
    // Testimonials post type
    register_post_type('testimonial', array(
        'labels' => array(
            'name' => esc_html__('Testimonials', 'festa-ceylon-wp'),
            'singular_name' => esc_html__('Testimonial', 'festa-ceylon-wp'),
            'add_new' => esc_html__('Add New', 'festa-ceylon-wp'),
            'add_new_item' => esc_html__('Add New Testimonial', 'festa-ceylon-wp'),
            'edit_item' => esc_html__('Edit Testimonial', 'festa-ceylon-wp'),
            'new_item' => esc_html__('New Testimonial', 'festa-ceylon-wp'),
            'view_item' => esc_html__('View Testimonial', 'festa-ceylon-wp'),
            'search_items' => esc_html__('Search Testimonials', 'festa-ceylon-wp'),
            'not_found' => esc_html__('No testimonials found', 'festa-ceylon-wp'),
            'not_found_in_trash' => esc_html__('No testimonials found in trash', 'festa-ceylon-wp'),
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-format-quote',
    ));
}
add_action('init', 'festa_ceylon_custom_post_types');

/**
 * Newsletter signup AJAX handler
 */
function festa_ceylon_newsletter_signup() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['newsletter_nonce'], 'festa_ceylon_newsletter')) {
        wp_send_json_error(array('message' => esc_html__('Security check failed.', 'festa-ceylon-wp')));
    }
    
    $email = sanitize_email($_POST['newsletter_email']);
    
    if (!is_email($email)) {
        wp_send_json_error(array('message' => esc_html__('Please enter a valid email address.', 'festa-ceylon-wp')));
    }
    
    // Check if email already exists
    $existing_subscriber = get_option('festa_ceylon_newsletter_subscribers', array());
    
    if (in_array($email, $existing_subscriber)) {
        wp_send_json_error(array('message' => esc_html__('This email is already subscribed.', 'festa-ceylon-wp')));
    }
    
    // Add email to subscribers list
    $existing_subscriber[] = $email;
    update_option('festa_ceylon_newsletter_subscribers', $existing_subscriber);
    
    // Send confirmation email (optional)
    $subject = sprintf(esc_html__('Welcome to %s Newsletter!', 'festa-ceylon-wp'), get_bloginfo('name'));
    $message = sprintf(
        esc_html__('Thank you for subscribing to our newsletter! You\'ll be the first to know about our latest collections and exclusive offers.', 'festa-ceylon-wp')
    );
    
    wp_mail($email, $subject, $message);
    
    wp_send_json_success(array('message' => esc_html__('Thank you for subscribing! Check your email for confirmation.', 'festa-ceylon-wp')));
}
add_action('wp_ajax_festa_ceylon_newsletter_signup', 'festa_ceylon_newsletter_signup');
add_action('wp_ajax_nopriv_festa_ceylon_newsletter_signup', 'festa_ceylon_newsletter_signup');

/**
 * Add custom CSS classes to body
 */
function festa_ceylon_custom_body_classes($classes) {
    // Add Bootstrap classes
    $classes[] = 'bootstrap-enabled';
    
    // Add page-specific classes
    if (is_front_page()) {
        $classes[] = 'homepage';
    }
    
    if (class_exists('WooCommerce') && is_woocommerce()) {
        $classes[] = 'woocommerce-active';
    }
    
    return $classes;
}
add_filter('body_class', 'festa_ceylon_custom_body_classes');

/**
 * Customize WordPress login page
 */
function festa_ceylon_login_styles() {
    ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/logo.png);
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            width: 100%;
            height: 80px;
        }
        
        .wp-core-ui .button-primary {
            background: #d97706;
            border-color: #d97706;
            color: #fff;
            text-decoration: none;
            text-shadow: none;
        }
        
        .wp-core-ui .button-primary:hover {
            background: #f97316;
            border-color: #f97316;
        }
        
        #loginform {
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
    <?php
}
add_action('login_enqueue_scripts', 'festa_ceylon_login_styles');

/**
 * Change login logo URL
 */
function festa_ceylon_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'festa_ceylon_login_logo_url');

/**
 * Change login logo title
 */
function festa_ceylon_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter('login_headertitle', 'festa_ceylon_login_logo_url_title');

/**
 * Add theme options to admin bar
 */
function festa_ceylon_admin_bar_menu($wp_admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $wp_admin_bar->add_menu(array(
        'id'    => 'festa-ceylon-options',
        'title' => esc_html__('Theme Options', 'festa-ceylon-wp'),
        'href'  => admin_url('customize.php'),
        'meta'  => array(
            'title' => esc_html__('Customize Theme', 'festa-ceylon-wp'),
        ),
    ));
}
add_action('admin_bar_menu', 'festa_ceylon_admin_bar_menu', 999);

/**
 * Add custom dashboard widget
 */
function festa_ceylon_dashboard_widget() {
    wp_add_dashboard_widget(
        'festa_ceylon_dashboard_widget',
        esc_html__('Festa Ceylon Theme', 'festa-ceylon-wp'),
        'festa_ceylon_dashboard_widget_content'
    );
}
add_action('wp_dashboard_setup', 'festa_ceylon_dashboard_widget');

function festa_ceylon_dashboard_widget_content() {
    ?>
    <div class="festa-ceylon-dashboard-widget">
        <h4><?php esc_html_e('Welcome to Festa Ceylon Theme!', 'festa-ceylon-wp'); ?></h4>
        <p><?php esc_html_e('Thank you for using our premium textile e-commerce theme. Here are some quick links to get you started:', 'festa-ceylon-wp'); ?></p>
        
        <ul>
            <li><a href="<?php echo admin_url('customize.php'); ?>"><?php esc_html_e('Customize Theme', 'festa-ceylon-wp'); ?></a></li>
            <?php if (class_exists('WooCommerce')) : ?>
                <li><a href="<?php echo admin_url('edit.php?post_type=product'); ?>"><?php esc_html_e('Manage Products', 'festa-ceylon-wp'); ?></a></li>
                <li><a href="<?php echo admin_url('admin.php?page=wc-settings'); ?>"><?php esc_html_e('WooCommerce Settings', 'festa-ceylon-wp'); ?></a></li>
            <?php endif; ?>
            <li><a href="<?php echo admin_url('nav-menus.php'); ?>"><?php esc_html_e('Manage Menus', 'festa-ceylon-wp'); ?></a></li>
            <li><a href="<?php echo admin_url('widgets.php'); ?>"><?php esc_html_e('Manage Widgets', 'festa-ceylon-wp'); ?></a></li>
        </ul>
        
        <?php if (class_exists('WooCommerce')) : ?>
            <div class="festa-stats mt-3">
                <h5><?php esc_html_e('Quick Stats', 'festa-ceylon-wp'); ?></h5>
                <p>
                    <strong><?php esc_html_e('Products:', 'festa-ceylon-wp'); ?></strong> 
                    <?php echo wp_count_posts('product')->publish; ?>
                </p>
                <p>
                    <strong><?php esc_html_e('Orders:', 'festa-ceylon-wp'); ?></strong> 
                    <?php echo wp_count_posts('shop_order')->wc_processing + wp_count_posts('shop_order')->wc_completed; ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
    
    <style>
    .festa-ceylon-dashboard-widget ul {
        list-style: disc;
        margin-left: 20px;
    }
    .festa-ceylon-dashboard-widget li {
        margin-bottom: 5px;
    }
    .festa-stats {
        border-top: 1px solid #eee;
        padding-top: 10px;
    }
    </style>
    <?php
}