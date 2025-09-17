<?php
/**
 * WooCommerce Integration
 *
 * @package Festa_Ceylon_WP
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Return early if WooCommerce is not active
if (!class_exists('WooCommerce')) {
    return;
}

/**
 * WooCommerce setup function
 */
function festa_ceylon_woocommerce_setup() {
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ));
    
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'festa_ceylon_woocommerce_setup');

/**
 * Remove default WooCommerce wrapper
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
 * Add custom WooCommerce wrapper
 */
function festa_ceylon_woocommerce_wrapper_start() {
    echo '<div class="container py-5"><div class="row"><div class="col-12">';
}
add_action('woocommerce_before_main_content', 'festa_ceylon_woocommerce_wrapper_start', 10);

function festa_ceylon_woocommerce_wrapper_end() {
    echo '</div></div></div>';
}
add_action('woocommerce_after_main_content', 'festa_ceylon_woocommerce_wrapper_end', 10);

/**
 * Customize WooCommerce breadcrumbs
 */
function festa_ceylon_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => ' <i class="bi bi-chevron-right mx-2"></i> ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb breadcrumb-nav mb-4" aria-label="breadcrumb"><ol class="breadcrumb">',
        'wrap_after'  => '</ol></nav>',
        'before'      => '<li class="breadcrumb-item">',
        'after'       => '</li>',
        'home'        => esc_html__('Home', 'festa-ceylon-wp'),
    );
}
add_filter('woocommerce_breadcrumb_defaults', 'festa_ceylon_woocommerce_breadcrumbs');

/**
 * Customize products per page
 */
function festa_ceylon_products_per_page() {
    return 12;
}
add_filter('loop_shop_per_page', 'festa_ceylon_products_per_page', 20);

/**
 * Customize product columns
 */
function festa_ceylon_loop_columns() {
    return 3;
}
add_filter('loop_shop_columns', 'festa_ceylon_loop_columns');

/**
 * Add Bootstrap classes to WooCommerce elements
 */
function festa_ceylon_woocommerce_bootstrap_classes() {
    // Add Bootstrap classes to buttons
    add_filter('woocommerce_loop_add_to_cart_link', function($link) {
        return str_replace('class="button', 'class="btn btn-primary button', $link);
    });
    
    // Add Bootstrap classes to form inputs
    add_action('wp_footer', function() {
        if (is_woocommerce() || is_cart() || is_checkout()) {
            ?>
            <script>
            jQuery(document).ready(function($) {
                // Add Bootstrap classes to form elements
                $('.woocommerce input[type="text"], .woocommerce input[type="email"], .woocommerce input[type="tel"], .woocommerce input[type="password"], .woocommerce textarea, .woocommerce select').addClass('form-control');
                $('.woocommerce input[type="submit"], .woocommerce button[type="submit"], .woocommerce .button').addClass('btn btn-primary');
                $('.woocommerce .quantity input').addClass('form-control text-center');
                $('.woocommerce-message, .woocommerce-info').addClass('alert alert-info');
                $('.woocommerce-error').addClass('alert alert-danger');
                
                // Add Bootstrap table classes
                $('.woocommerce table').addClass('table table-striped');
                
                // Add Bootstrap form classes
                $('.woocommerce form .form-row').addClass('mb-3');
                $('.woocommerce form label').addClass('form-label');
            });
            </script>
            <?php
        }
    });
}
add_action('init', 'festa_ceylon_woocommerce_bootstrap_classes');

/**
 * Customize single product layout
 */
function festa_ceylon_single_product_layout() {
    // Remove default product tabs
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
    
    // Add custom product tabs with Bootstrap styling
    add_action('woocommerce_after_single_product_summary', 'festa_ceylon_custom_product_tabs', 10);
}
add_action('init', 'festa_ceylon_single_product_layout');

/**
 * Custom product tabs with Bootstrap styling
 */
function festa_ceylon_custom_product_tabs() {
    global $product;
    
    $tabs = apply_filters('woocommerce_product_tabs', array());
    
    if (!empty($tabs)) :
        ?>
        <div class="woocommerce-tabs wc-tabs-wrapper mt-5">
            <ul class="nav nav-tabs wc-tabs" role="tablist">
                <?php $i = 0; foreach ($tabs as $key => $tab) : ?>
                    <li class="nav-item <?php echo esc_attr($key); ?>_tab" role="presentation">
                        <button class="nav-link <?php echo $i === 0 ? 'active' : ''; ?>" 
                                id="<?php echo esc_attr($key); ?>-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#<?php echo esc_attr($key); ?>" 
                                type="button" 
                                role="tab" 
                                aria-controls="<?php echo esc_attr($key); ?>" 
                                aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>">
                            <?php echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $tab['title'], $key)); ?>
                        </button>
                    </li>
                <?php $i++; endforeach; ?>
            </ul>
            
            <div class="tab-content woocommerce-Tabs-panel--<?php echo esc_attr($key); ?>">
                <?php $i = 0; foreach ($tabs as $key => $tab) : ?>
                    <div class="tab-pane fade <?php echo $i === 0 ? 'show active' : ''; ?> woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?>" 
                         id="<?php echo esc_attr($key); ?>" 
                         role="tabpanel" 
                         aria-labelledby="<?php echo esc_attr($key); ?>-tab">
                        <div class="p-4">
                            <?php
                            if (isset($tab['callback'])) {
                                call_user_func($tab['callback'], $key, $tab);
                            }
                            ?>
                        </div>
                    </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>
        <?php
    endif;
}

/**
 * Customize cart page layout
 */
function festa_ceylon_cart_layout() {
    // Add Bootstrap classes to cart table
    add_filter('woocommerce_cart_item_remove_link', function($link) {
        return str_replace('class="remove"', 'class="remove btn btn-sm btn-outline-danger"', $link);
    });
}
add_action('init', 'festa_ceylon_cart_layout');

/**
 * Customize checkout page layout
 */
function festa_ceylon_checkout_layout() {
    // Add custom checkout styling
    add_action('wp_footer', function() {
        if (is_checkout()) {
            ?>
            <script>
            jQuery(document).ready(function($) {
                // Add Bootstrap classes to checkout form
                $('.woocommerce-checkout .col2-set .col-1, .woocommerce-checkout .col2-set .col-2').addClass('col-md-6');
                $('.woocommerce-checkout #order_review_heading').addClass('h4 mb-3');
                $('.woocommerce-checkout #order_review').addClass('card');
                $('.woocommerce-checkout #order_review .shop_table').addClass('table mb-0');
                $('.woocommerce-checkout .woocommerce-checkout-payment').addClass('card-footer');
            });
            </script>
            <style>
            .woocommerce-checkout .col2-set {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -15px;
            }
            .woocommerce-checkout .col2-set .col-1,
            .woocommerce-checkout .col2-set .col-2 {
                padding: 0 15px;
                flex: 0 0 50%;
                max-width: 50%;
            }
            @media (max-width: 768px) {
                .woocommerce-checkout .col2-set .col-1,
                .woocommerce-checkout .col2-set .col-2 {
                    flex: 0 0 100%;
                    max-width: 100%;
                }
            }
            </style>
            <?php
        }
    });
}
add_action('init', 'festa_ceylon_checkout_layout');

/**
 * Add custom fields to product
 */
function festa_ceylon_product_custom_fields() {
    global $post;
    
    // Add fabric type field
    woocommerce_wp_select(array(
        'id' => '_fabric_type',
        'label' => esc_html__('Fabric Type', 'festa-ceylon-wp'),
        'options' => array(
            '' => esc_html__('Select fabric type', 'festa-ceylon-wp'),
            'cotton' => esc_html__('Cotton', 'festa-ceylon-wp'),
            'silk' => esc_html__('Silk', 'festa-ceylon-wp'),
            'linen' => esc_html__('Linen', 'festa-ceylon-wp'),
            'wool' => esc_html__('Wool', 'festa-ceylon-wp'),
            'synthetic' => esc_html__('Synthetic', 'festa-ceylon-wp'),
        ),
    ));
    
    // Add care instructions field
    woocommerce_wp_textarea_input(array(
        'id' => '_care_instructions',
        'label' => esc_html__('Care Instructions', 'festa-ceylon-wp'),
        'placeholder' => esc_html__('Enter care instructions...', 'festa-ceylon-wp'),
    ));
}
add_action('woocommerce_product_options_general_product_data', 'festa_ceylon_product_custom_fields');

/**
 * Save custom product fields
 */
function festa_ceylon_save_product_custom_fields($post_id) {
    $fabric_type = isset($_POST['_fabric_type']) ? sanitize_text_field($_POST['_fabric_type']) : '';
    $care_instructions = isset($_POST['_care_instructions']) ? sanitize_textarea_field($_POST['_care_instructions']) : '';
    
    update_post_meta($post_id, '_fabric_type', $fabric_type);
    update_post_meta($post_id, '_care_instructions', $care_instructions);
}
add_action('woocommerce_process_product_meta', 'festa_ceylon_save_product_custom_fields');

/**
 * Display custom fields on single product page
 */
function festa_ceylon_display_custom_fields() {
    global $product;
    
    $fabric_type = get_post_meta($product->get_id(), '_fabric_type', true);
    $care_instructions = get_post_meta($product->get_id(), '_care_instructions', true);
    
    if ($fabric_type || $care_instructions) {
        echo '<div class="product-custom-fields mt-3">';
        
        if ($fabric_type) {
            echo '<div class="fabric-type mb-2">';
            echo '<strong>' . esc_html__('Fabric Type:', 'festa-ceylon-wp') . '</strong> ';
            echo '<span class="badge bg-secondary">' . esc_html(ucfirst($fabric_type)) . '</span>';
            echo '</div>';
        }
        
        if ($care_instructions) {
            echo '<div class="care-instructions">';
            echo '<strong>' . esc_html__('Care Instructions:', 'festa-ceylon-wp') . '</strong><br>';
            echo '<small class="text-muted">' . wp_kses_post(nl2br($care_instructions)) . '</small>';
            echo '</div>';
        }
        
        echo '</div>';
    }
}
add_action('woocommerce_single_product_summary', 'festa_ceylon_display_custom_fields', 25);

/**
 * AJAX add to cart functionality
 */
function festa_ceylon_ajax_add_to_cart() {
    if (!wp_verify_nonce($_POST['nonce'], 'festa_ceylon_nonce')) {
        wp_send_json_error(array('message' => esc_html__('Security check failed.', 'festa-ceylon-wp')));
    }
    
    $product_id = absint($_POST['product_id']);
    $quantity = absint($_POST['quantity']) ?: 1;
    
    $result = WC()->cart->add_to_cart($product_id, $quantity);
    
    if ($result) {
        wp_send_json_success(array(
            'message' => esc_html__('Product added to cart successfully!', 'festa-ceylon-wp'),
            'cart_count' => WC()->cart->get_cart_contents_count(),
        ));
    } else {
        wp_send_json_error(array('message' => esc_html__('Failed to add product to cart.', 'festa-ceylon-wp')));
    }
}
add_action('wp_ajax_festa_ceylon_add_to_cart', 'festa_ceylon_ajax_add_to_cart');
add_action('wp_ajax_nopriv_festa_ceylon_add_to_cart', 'festa_ceylon_ajax_add_to_cart');

/**
 * Customize WooCommerce pagination
 */
function festa_ceylon_woocommerce_pagination_args($args) {
    $args['prev_text'] = '<i class="bi bi-chevron-left"></i> ' . esc_html__('Previous', 'festa-ceylon-wp');
    $args['next_text'] = esc_html__('Next', 'festa-ceylon-wp') . ' <i class="bi bi-chevron-right"></i>';
    return $args;
}
add_filter('woocommerce_pagination_args', 'festa_ceylon_woocommerce_pagination_args');

/**
 * Add schema markup for products
 */
function festa_ceylon_product_schema() {
    if (is_product()) {
        global $product;
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->get_name(),
            'description' => wp_strip_all_tags($product->get_description()),
            'sku' => $product->get_sku(),
            'offers' => array(
                '@type' => 'Offer',
                'price' => $product->get_price(),
                'priceCurrency' => get_woocommerce_currency(),
                'availability' => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            ),
        );
        
        if ($product->get_image_id()) {
            $image = wp_get_attachment_image_src($product->get_image_id(), 'full');
            $schema['image'] = $image[0];
        }
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'festa_ceylon_product_schema');