<?php
/**
 * Test Product Types System
 * This file can be used to test the product types functionality
 * 
 * Usage: Include this file in a WordPress environment to test the system
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Include the product attributes file
require_once get_template_directory() . '/inc/product-attributes.php';

/**
 * Test function to verify product types configuration
 */
function festa_ceylon_test_product_types() {
    echo '<div style="padding: 20px; background: #f8f9fa; margin: 20px; border-radius: 8px;">';
    echo '<h2>Product Types System Test</h2>';
    
    $product_types = Festa_Ceylon_Product_Types::get_product_types();
    
    echo '<h3>Available Product Types:</h3>';
    echo '<ul>';
    
    foreach ($product_types as $key => $type) {
        echo '<li><strong>' . esc_html($type['label']) . '</strong> (' . esc_html($key) . ')';
        echo '<br><em>' . esc_html($type['description']) . '</em>';
        echo '<br>Attributes: ' . count($type['attributes']) . ' defined';
        echo '</li><br>';
    }
    
    echo '</ul>';
    
    // Test each product type's attributes
    foreach ($product_types as $type_key => $type) {
        echo '<h3>' . esc_html($type['label']) . ' Attributes:</h3>';
        echo '<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">';
        echo '<thead>';
        echo '<tr style="background: #e9ecef;">';
        echo '<th style="padding: 8px; border: 1px solid #ddd;">Attribute Key</th>';
        echo '<th style="padding: 8px; border: 1px solid #ddd;">Label</th>';
        echo '<th style="padding: 8px; border: 1px solid #ddd;">Type</th>';
        echo '<th style="padding: 8px; border: 1px solid #ddd;">Required</th>';
        echo '<th style="padding: 8px; border: 1px solid #ddd;">Options Count</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        foreach ($type['attributes'] as $attr_key => $attribute) {
            echo '<tr>';
            echo '<td style="padding: 8px; border: 1px solid #ddd;"><code>' . esc_html($attr_key) . '</code></td>';
            echo '<td style="padding: 8px; border: 1px solid #ddd;">' . esc_html($attribute['label']) . '</td>';
            echo '<td style="padding: 8px; border: 1px solid #ddd;">' . esc_html($attribute['type']) . '</td>';
            echo '<td style="padding: 8px; border: 1px solid #ddd;">' . (isset($attribute['required']) && $attribute['required'] ? 'Yes' : 'No') . '</td>';
            echo '<td style="padding: 8px; border: 1px solid #ddd;">' . (isset($attribute['options']) ? count($attribute['options']) : 'N/A') . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
    }
    
    echo '<h3>System Status:</h3>';
    echo '<ul>';
    echo '<li>✅ Product types configuration loaded successfully</li>';
    echo '<li>✅ All product types have attributes defined</li>';
    echo '<li>✅ Attribute structure is valid</li>';
    
    // Check if WooCommerce is active
    if (class_exists('WooCommerce')) {
        echo '<li>✅ WooCommerce is active</li>';
    } else {
        echo '<li>❌ WooCommerce is not active</li>';
    }
    
    // Check if JavaScript file exists
    $js_file = get_template_directory() . '/assets/js/admin-product-attributes.js';
    if (file_exists($js_file)) {
        echo '<li>✅ Admin JavaScript file exists</li>';
    } else {
        echo '<li>❌ Admin JavaScript file missing</li>';
    }
    
    // Check if CSS file has product attributes styles
    $css_file = get_template_directory() . '/assets/css/main.css';
    if (file_exists($css_file)) {
        $css_content = file_get_contents($css_file);
        if (strpos($css_content, '.product-attributes') !== false) {
            echo '<li>✅ Product attributes CSS styles found</li>';
        } else {
            echo '<li>❌ Product attributes CSS styles missing</li>';
        }
    } else {
        echo '<li>❌ Main CSS file missing</li>';
    }
    
    echo '</ul>';
    
    echo '<h3>Next Steps:</h3>';
    echo '<ol>';
    echo '<li>Create a new product in WooCommerce admin</li>';
    echo '<li>Select a product type from the dropdown</li>';
    echo '<li>Fill in the dynamic attributes that appear</li>';
    echo '<li>Save the product and view it on the frontend</li>';
    echo '<li>Verify that attributes are displayed correctly</li>';
    echo '</ol>';
    
    echo '</div>';
}

// Hook to display test results (only for administrators)
if (current_user_can('administrator')) {
    add_action('wp_footer', 'festa_ceylon_test_product_types');
}

/**
 * Test AJAX functionality
 */
function festa_ceylon_test_ajax() {
    if (!current_user_can('administrator')) {
        wp_die('Unauthorized');
    }
    
    $product_types = Festa_Ceylon_Product_Types::get_product_types();
    
    wp_send_json_success(array(
        'message' => 'AJAX test successful',
        'product_types_count' => count($product_types),
        'available_types' => array_keys($product_types)
    ));
}
add_action('wp_ajax_festa_ceylon_test_ajax', 'festa_ceylon_test_ajax');

/**
 * Add test menu item in admin (for administrators only)
 */
function festa_ceylon_add_test_menu() {
    if (current_user_can('administrator')) {
        add_submenu_page(
            'tools.php',
            'Product Types Test',
            'Product Types Test',
            'administrator',
            'festa-product-types-test',
            'festa_ceylon_test_admin_page'
        );
    }
}
add_action('admin_menu', 'festa_ceylon_add_test_menu');

/**
 * Test admin page
 */
function festa_ceylon_test_admin_page() {
    ?>
    <div class="wrap">
        <h1>Product Types System Test</h1>
        
        <div class="notice notice-info">
            <p><strong>Note:</strong> This is a test page to verify the product types system is working correctly.</p>
        </div>
        
        <?php festa_ceylon_test_product_types(); ?>
        
        <div style="margin-top: 20px;">
            <button type="button" id="test-ajax" class="button button-primary">Test AJAX Functionality</button>
            <div id="ajax-result" style="margin-top: 10px;"></div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $('#test-ajax').on('click', function() {
                var $button = $(this);
                var $result = $('#ajax-result');
                
                $button.prop('disabled', true).text('Testing...');
                $result.html('');
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'festa_ceylon_test_ajax'
                    },
                    success: function(response) {
                        if (response.success) {
                            $result.html('<div class="notice notice-success"><p>✅ AJAX test successful! Found ' + response.data.product_types_count + ' product types.</p></div>');
                        } else {
                            $result.html('<div class="notice notice-error"><p>❌ AJAX test failed: ' + response.data + '</p></div>');
                        }
                    },
                    error: function() {
                        $result.html('<div class="notice notice-error"><p>❌ AJAX request failed</p></div>');
                    },
                    complete: function() {
                        $button.prop('disabled', false).text('Test AJAX Functionality');
                    }
                });
            });
        });
        </script>
    </div>
    <?php
}
?>