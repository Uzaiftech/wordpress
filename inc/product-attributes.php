<?php
/**
 * Product Attributes System
 * Handles different product types (Fabrics, Shawls, Cloths) with their specific attributes
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
 * Product Types Configuration
 */
class Festa_Ceylon_Product_Types {
    
    /**
     * Get all product types with their configurations
     */
    public static function get_product_types() {
        return array(
            'fabrics' => array(
                'label' => __('Fabrics', 'festa-ceylon-wp'),
                'description' => __('Raw materials for tailoring and crafting', 'festa-ceylon-wp'),
                'attributes' => self::get_fabric_attributes()
            ),
            'shawls' => array(
                'label' => __('Shawls', 'festa-ceylon-wp'),
                'description' => __('Fashion accessories and wraps', 'festa-ceylon-wp'),
                'attributes' => self::get_shawl_attributes()
            ),
            'cloths' => array(
                'label' => __('Cloths', 'festa-ceylon-wp'),
                'description' => __('Ready-to-wear clothing items', 'festa-ceylon-wp'),
                'attributes' => self::get_cloth_attributes()
            )
        );
    }
    
    /**
     * Get fabric-specific attributes
     */
    public static function get_fabric_attributes() {
        return array(
            'fabric_type' => array(
                'label' => __('Fabric Type/Weave', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'cotton' => __('Cotton', 'festa-ceylon-wp'),
                    'linen' => __('Linen', 'festa-ceylon-wp'),
                    'silk' => __('Silk', 'festa-ceylon-wp'),
                    'wool' => __('Wool', 'festa-ceylon-wp'),
                    'polyester' => __('Polyester', 'festa-ceylon-wp'),
                    'cotton_blend' => __('Cotton Blend', 'festa-ceylon-wp'),
                    'satin' => __('Satin', 'festa-ceylon-wp'),
                    'chiffon' => __('Chiffon', 'festa-ceylon-wp'),
                    'denim' => __('Denim', 'festa-ceylon-wp'),
                    'other' => __('Other', 'festa-ceylon-wp')
                ),
                'required' => true
            ),
            'material_composition' => array(
                'label' => __('Material/Composition', 'festa-ceylon-wp'),
                'type' => 'text',
                'placeholder' => __('e.g., 100% Cotton, Cotton-Poly Blend', 'festa-ceylon-wp'),
                'required' => true
            ),
            'pattern_design' => array(
                'label' => __('Pattern/Design', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'plain' => __('Plain', 'festa-ceylon-wp'),
                    'printed' => __('Printed', 'festa-ceylon-wp'),
                    'embroidered' => __('Embroidered', 'festa-ceylon-wp'),
                    'striped' => __('Striped', 'festa-ceylon-wp'),
                    'floral' => __('Floral', 'festa-ceylon-wp'),
                    'geometric' => __('Geometric', 'festa-ceylon-wp'),
                    'abstract' => __('Abstract', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'gsm_weight' => array(
                'label' => __('GSM/Weight', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'lightweight' => __('Lightweight (80-150 GSM)', 'festa-ceylon-wp'),
                    'medium' => __('Medium (150-250 GSM)', 'festa-ceylon-wp'),
                    'heavy' => __('Heavy (250+ GSM)', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'fabric_width' => array(
                'label' => __('Width', 'festa-ceylon-wp'),
                'type' => 'text',
                'placeholder' => __('e.g., 45 inches, 110 cm', 'festa-ceylon-wp'),
                'required' => true
            ),
            'unit_of_sale' => array(
                'label' => __('Unit of Sale', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'meter' => __('Per Meter', 'festa-ceylon-wp'),
                    'yard' => __('Per Yard', 'festa-ceylon-wp'),
                    'roll' => __('Per Roll', 'festa-ceylon-wp')
                ),
                'required' => true
            ),
            'texture_finish' => array(
                'label' => __('Texture/Finish', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'matte' => __('Matte', 'festa-ceylon-wp'),
                    'glossy' => __('Glossy', 'festa-ceylon-wp'),
                    'sheer' => __('Sheer', 'festa-ceylon-wp'),
                    'rough' => __('Rough', 'festa-ceylon-wp'),
                    'soft' => __('Soft', 'festa-ceylon-wp'),
                    'smooth' => __('Smooth', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'occasion_use' => array(
                'label' => __('Occasion/Use', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'casual_wear' => __('Casual Wear', 'festa-ceylon-wp'),
                    'formal_wear' => __('Formal Wear', 'festa-ceylon-wp'),
                    'upholstery' => __('Upholstery', 'festa-ceylon-wp'),
                    'crafting' => __('Crafting', 'festa-ceylon-wp'),
                    'home_decor' => __('Home Decor', 'festa-ceylon-wp'),
                    'curtains' => __('Curtains', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'care_instructions' => array(
                'label' => __('Care Instructions', 'festa-ceylon-wp'),
                'type' => 'textarea',
                'placeholder' => __('Machine wash, Dry clean, Hand wash, etc.', 'festa-ceylon-wp'),
                'required' => false
            )
        );
    }
    
    /**
     * Get shawl-specific attributes
     */
    public static function get_shawl_attributes() {
        return array(
            'shawl_material' => array(
                'label' => __('Material', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'wool' => __('Wool', 'festa-ceylon-wp'),
                    'cashmere' => __('Cashmere', 'festa-ceylon-wp'),
                    'pashmina' => __('Pashmina', 'festa-ceylon-wp'),
                    'cotton' => __('Cotton', 'festa-ceylon-wp'),
                    'silk' => __('Silk', 'festa-ceylon-wp'),
                    'wool_blend' => __('Wool Blend', 'festa-ceylon-wp'),
                    'cotton_blend' => __('Cotton Blend', 'festa-ceylon-wp'),
                    'synthetic' => __('Synthetic', 'festa-ceylon-wp')
                ),
                'required' => true
            ),
            'weave_type' => array(
                'label' => __('Weave/Type', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'handwoven' => __('Handwoven', 'festa-ceylon-wp'),
                    'machine_woven' => __('Machine-woven', 'festa-ceylon-wp'),
                    'jacquard' => __('Jacquard', 'festa-ceylon-wp'),
                    'embroidered' => __('Embroidered', 'festa-ceylon-wp'),
                    'knitted' => __('Knitted', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'design_pattern' => array(
                'label' => __('Design/Pattern', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'solid' => __('Solid', 'festa-ceylon-wp'),
                    'stripes' => __('Stripes', 'festa-ceylon-wp'),
                    'paisley' => __('Paisley', 'festa-ceylon-wp'),
                    'floral' => __('Floral', 'festa-ceylon-wp'),
                    'traditional' => __('Traditional', 'festa-ceylon-wp'),
                    'modern' => __('Modern', 'festa-ceylon-wp'),
                    'geometric' => __('Geometric', 'festa-ceylon-wp'),
                    'abstract' => __('Abstract', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'shawl_length' => array(
                'label' => __('Length', 'festa-ceylon-wp'),
                'type' => 'text',
                'placeholder' => __('e.g., 180 cm, 70 inches', 'festa-ceylon-wp'),
                'required' => true
            ),
            'shawl_width' => array(
                'label' => __('Width', 'festa-ceylon-wp'),
                'type' => 'text',
                'placeholder' => __('e.g., 70 cm, 28 inches', 'festa-ceylon-wp'),
                'required' => true
            ),
            'thickness_warmth' => array(
                'label' => __('Thickness/Warmth Level', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'light' => __('Light', 'festa-ceylon-wp'),
                    'medium' => __('Medium', 'festa-ceylon-wp'),
                    'heavy' => __('Heavy', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'edge_finish' => array(
                'label' => __('Edge Finish', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'fringed' => __('Fringed', 'festa-ceylon-wp'),
                    'hemmed' => __('Hemmed', 'festa-ceylon-wp'),
                    'tassels' => __('Tassels', 'festa-ceylon-wp'),
                    'raw_edge' => __('Raw Edge', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'shawl_occasion' => array(
                'label' => __('Occasion', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'casual' => __('Casual', 'festa-ceylon-wp'),
                    'party' => __('Party', 'festa-ceylon-wp'),
                    'winter_wear' => __('Winter Wear', 'festa-ceylon-wp'),
                    'religious' => __('Religious', 'festa-ceylon-wp'),
                    'formal' => __('Formal', 'festa-ceylon-wp'),
                    'wedding' => __('Wedding', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'region_origin' => array(
                'label' => __('Region/Origin', 'festa-ceylon-wp'),
                'type' => 'text',
                'placeholder' => __('e.g., Kashmiri, Turkish, Afghan', 'festa-ceylon-wp'),
                'required' => false
            ),
            'care_instructions' => array(
                'label' => __('Care Instructions', 'festa-ceylon-wp'),
                'type' => 'textarea',
                'placeholder' => __('Dry clean only, Hand wash, etc.', 'festa-ceylon-wp'),
                'required' => false
            )
        );
    }
    
    /**
     * Get cloth-specific attributes
     */
    public static function get_cloth_attributes() {
        return array(
            'clothing_category' => array(
                'label' => __('Category', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'shirts' => __('Shirts', 'festa-ceylon-wp'),
                    'dresses' => __('Dresses', 'festa-ceylon-wp'),
                    'pants' => __('Pants', 'festa-ceylon-wp'),
                    'kurtas' => __('Kurtas', 'festa-ceylon-wp'),
                    'sarees' => __('Sarees', 'festa-ceylon-wp'),
                    'suits' => __('Suits', 'festa-ceylon-wp'),
                    'blouses' => __('Blouses', 'festa-ceylon-wp'),
                    'skirts' => __('Skirts', 'festa-ceylon-wp'),
                    'jackets' => __('Jackets', 'festa-ceylon-wp'),
                    'tops' => __('Tops', 'festa-ceylon-wp')
                ),
                'required' => true
            ),
            'target_audience' => array(
                'label' => __('Gender/Target Audience', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'men' => __('Men', 'festa-ceylon-wp'),
                    'women' => __('Women', 'festa-ceylon-wp'),
                    'kids' => __('Kids', 'festa-ceylon-wp'),
                    'unisex' => __('Unisex', 'festa-ceylon-wp')
                ),
                'required' => true
            ),
            'cloth_material' => array(
                'label' => __('Material/Fabric', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'cotton' => __('Cotton', 'festa-ceylon-wp'),
                    'silk' => __('Silk', 'festa-ceylon-wp'),
                    'linen' => __('Linen', 'festa-ceylon-wp'),
                    'polyester' => __('Polyester', 'festa-ceylon-wp'),
                    'wool' => __('Wool', 'festa-ceylon-wp'),
                    'cotton_blend' => __('Cotton Blend', 'festa-ceylon-wp'),
                    'silk_blend' => __('Silk Blend', 'festa-ceylon-wp'),
                    'synthetic' => __('Synthetic', 'festa-ceylon-wp')
                ),
                'required' => true
            ),
            'cloth_pattern' => array(
                'label' => __('Pattern/Design', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'solid' => __('Solid', 'festa-ceylon-wp'),
                    'printed' => __('Printed', 'festa-ceylon-wp'),
                    'embroidered' => __('Embroidered', 'festa-ceylon-wp'),
                    'striped' => __('Striped', 'festa-ceylon-wp'),
                    'checkered' => __('Checkered', 'festa-ceylon-wp'),
                    'floral' => __('Floral', 'festa-ceylon-wp'),
                    'geometric' => __('Geometric', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'cloth_size' => array(
                'label' => __('Size', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'xs' => __('XS', 'festa-ceylon-wp'),
                    's' => __('S', 'festa-ceylon-wp'),
                    'm' => __('M', 'festa-ceylon-wp'),
                    'l' => __('L', 'festa-ceylon-wp'),
                    'xl' => __('XL', 'festa-ceylon-wp'),
                    'xxl' => __('XXL', 'festa-ceylon-wp'),
                    'xxxl' => __('XXXL', 'festa-ceylon-wp'),
                    'free_size' => __('Free Size', 'festa-ceylon-wp')
                ),
                'required' => true
            ),
            'fit_type' => array(
                'label' => __('Fit Type', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'slim' => __('Slim Fit', 'festa-ceylon-wp'),
                    'regular' => __('Regular Fit', 'festa-ceylon-wp'),
                    'loose' => __('Loose/Oversized', 'festa-ceylon-wp'),
                    'tailored' => __('Tailored', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'sleeve_type' => array(
                'label' => __('Sleeve Type', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'full_sleeve' => __('Full Sleeve', 'festa-ceylon-wp'),
                    'half_sleeve' => __('Half Sleeve', 'festa-ceylon-wp'),
                    'sleeveless' => __('Sleeveless', 'festa-ceylon-wp'),
                    'three_quarter' => __('3/4 Sleeve', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'neckline_collar' => array(
                'label' => __('Neckline/Collar', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'round_neck' => __('Round Neck', 'festa-ceylon-wp'),
                    'v_neck' => __('V-Neck', 'festa-ceylon-wp'),
                    'mandarin' => __('Mandarin Collar', 'festa-ceylon-wp'),
                    'shirt_collar' => __('Shirt Collar', 'festa-ceylon-wp'),
                    'boat_neck' => __('Boat Neck', 'festa-ceylon-wp'),
                    'high_neck' => __('High Neck', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'cloth_occasion' => array(
                'label' => __('Occasion/Use', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'casual' => __('Casual', 'festa-ceylon-wp'),
                    'formal' => __('Formal', 'festa-ceylon-wp'),
                    'party_wear' => __('Party Wear', 'festa-ceylon-wp'),
                    'office_wear' => __('Office Wear', 'festa-ceylon-wp'),
                    'festive' => __('Festive', 'festa-ceylon-wp'),
                    'wedding' => __('Wedding', 'festa-ceylon-wp'),
                    'ethnic' => __('Ethnic', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'season' => array(
                'label' => __('Season', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'summer' => __('Summer', 'festa-ceylon-wp'),
                    'winter' => __('Winter', 'festa-ceylon-wp'),
                    'monsoon' => __('Monsoon', 'festa-ceylon-wp'),
                    'all_season' => __('All Season', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'garment_length' => array(
                'label' => __('Length', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'short' => __('Short', 'festa-ceylon-wp'),
                    'knee_length' => __('Knee Length', 'festa-ceylon-wp'),
                    'midi' => __('Midi', 'festa-ceylon-wp'),
                    'ankle_length' => __('Ankle Length', 'festa-ceylon-wp'),
                    'floor_length' => __('Floor Length', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'closure_type' => array(
                'label' => __('Closure Type', 'festa-ceylon-wp'),
                'type' => 'select',
                'options' => array(
                    'buttons' => __('Buttons', 'festa-ceylon-wp'),
                    'zipper' => __('Zipper', 'festa-ceylon-wp'),
                    'hook' => __('Hook', 'festa-ceylon-wp'),
                    'elastic' => __('Elastic', 'festa-ceylon-wp'),
                    'tie_up' => __('Tie-up', 'festa-ceylon-wp'),
                    'pullover' => __('Pullover', 'festa-ceylon-wp')
                ),
                'required' => false
            ),
            'care_instructions' => array(
                'label' => __('Care Instructions', 'festa-ceylon-wp'),
                'type' => 'textarea',
                'placeholder' => __('Machine wash, Hand wash, Dry clean, etc.', 'festa-ceylon-wp'),
                'required' => false
            )
        );
    }
}

/**
 * Initialize Product Attributes System
 */
function festa_ceylon_init_product_attributes() {
    // Add product type field to admin
    add_action('woocommerce_product_options_general_product_data', 'festa_ceylon_add_product_type_field');
    
    // Add dynamic attribute fields based on product type
    add_action('woocommerce_product_options_general_product_data', 'festa_ceylon_add_dynamic_attribute_fields');
    
    // Save product type and attributes
    add_action('woocommerce_process_product_meta', 'festa_ceylon_save_product_attributes');
    
    // Display attributes on frontend
    add_action('woocommerce_single_product_summary', 'festa_ceylon_display_product_attributes', 25);
    
    // Add AJAX handler for dynamic attribute loading
    add_action('wp_ajax_festa_ceylon_load_attributes', 'festa_ceylon_ajax_load_attributes');
    
    // Enqueue admin scripts
    add_action('admin_enqueue_scripts', 'festa_ceylon_admin_scripts');
}
add_action('init', 'festa_ceylon_init_product_attributes');

/**
 * Add product type selection field
 */
function festa_ceylon_add_product_type_field() {
    global $post;
    
    $product_types = Festa_Ceylon_Product_Types::get_product_types();
    $options = array('' => __('Select Product Type', 'festa-ceylon-wp'));
    
    foreach ($product_types as $key => $type) {
        $options[$key] = $type['label'];
    }
    
    woocommerce_wp_select(array(
        'id' => '_festa_product_type',
        'label' => __('Product Type', 'festa-ceylon-wp'),
        'options' => $options,
        'desc_tip' => true,
        'description' => __('Select the type of product to show relevant attributes.', 'festa-ceylon-wp'),
    ));
}

/**
 * Add dynamic attribute fields container
 */
function festa_ceylon_add_dynamic_attribute_fields() {
    echo '<div id="festa-dynamic-attributes" class="options_group">';
    echo '<p class="form-field"><em>' . __('Select a product type above to see relevant attributes.', 'festa-ceylon-wp') . '</em></p>';
    echo '</div>';
}

/**
 * Save product attributes
 */
function festa_ceylon_save_product_attributes($post_id) {
    // Save product type
    $product_type = isset($_POST['_festa_product_type']) ? sanitize_text_field($_POST['_festa_product_type']) : '';
    update_post_meta($post_id, '_festa_product_type', $product_type);
    
    // Save attributes based on product type
    if ($product_type) {
        $product_types = Festa_Ceylon_Product_Types::get_product_types();
        
        if (isset($product_types[$product_type])) {
            $attributes = $product_types[$product_type]['attributes'];
            
            foreach ($attributes as $key => $attribute) {
                $field_name = '_festa_' . $key;
                
                if (isset($_POST[$field_name])) {
                    $value = '';
                    
                    if ($attribute['type'] === 'textarea') {
                        $value = sanitize_textarea_field($_POST[$field_name]);
                    } else {
                        $value = sanitize_text_field($_POST[$field_name]);
                    }
                    
                    update_post_meta($post_id, $field_name, $value);
                }
            }
        }
    }
}

/**
 * AJAX handler for loading dynamic attributes
 */
function festa_ceylon_ajax_load_attributes() {
    check_ajax_referer('festa_ceylon_nonce', 'nonce');
    
    $product_type = sanitize_text_field($_POST['product_type']);
    $product_id = intval($_POST['product_id']);
    
    if (!$product_type) {
        wp_send_json_error('Invalid product type');
    }
    
    $product_types = Festa_Ceylon_Product_Types::get_product_types();
    
    if (!isset($product_types[$product_type])) {
        wp_send_json_error('Product type not found');
    }
    
    $attributes = $product_types[$product_type]['attributes'];
    $html = '';
    
    foreach ($attributes as $key => $attribute) {
        $field_name = '_festa_' . $key;
        $current_value = get_post_meta($product_id, $field_name, true);
        
        $html .= '<p class="form-field">';
        $html .= '<label for="' . esc_attr($field_name) . '">' . esc_html($attribute['label']);
        
        if (isset($attribute['required']) && $attribute['required']) {
            $html .= ' <span class="required">*</span>';
        }
        
        $html .= '</label>';
        
        switch ($attribute['type']) {
            case 'select':
                $html .= '<select id="' . esc_attr($field_name) . '" name="' . esc_attr($field_name) . '" class="select short">';
                $html .= '<option value="">' . __('Select...', 'festa-ceylon-wp') . '</option>';
                
                foreach ($attribute['options'] as $option_key => $option_label) {
                    $selected = selected($current_value, $option_key, false);
                    $html .= '<option value="' . esc_attr($option_key) . '"' . $selected . '>' . esc_html($option_label) . '</option>';
                }
                
                $html .= '</select>';
                break;
                
            case 'textarea':
                $placeholder = isset($attribute['placeholder']) ? $attribute['placeholder'] : '';
                $html .= '<textarea id="' . esc_attr($field_name) . '" name="' . esc_attr($field_name) . '" placeholder="' . esc_attr($placeholder) . '" rows="3" cols="20">' . esc_textarea($current_value) . '</textarea>';
                break;
                
            default: // text
                $placeholder = isset($attribute['placeholder']) ? $attribute['placeholder'] : '';
                $html .= '<input type="text" id="' . esc_attr($field_name) . '" name="' . esc_attr($field_name) . '" value="' . esc_attr($current_value) . '" placeholder="' . esc_attr($placeholder) . '" />';
                break;
        }
        
        $html .= '</p>';
    }
    
    wp_send_json_success($html);
}

/**
 * Display product attributes on frontend
 */
function festa_ceylon_display_product_attributes() {
    global $product;
    
    $product_type = get_post_meta($product->get_id(), '_festa_product_type', true);
    
    if (!$product_type) {
        return;
    }
    
    $product_types = Festa_Ceylon_Product_Types::get_product_types();
    
    if (!isset($product_types[$product_type])) {
        return;
    }
    
    $attributes = $product_types[$product_type]['attributes'];
    $has_attributes = false;
    
    // Check if any attributes have values
    foreach ($attributes as $key => $attribute) {
        $field_name = '_festa_' . $key;
        $value = get_post_meta($product->get_id(), $field_name, true);
        
        if (!empty($value)) {
            $has_attributes = true;
            break;
        }
    }
    
    if (!$has_attributes) {
        return;
    }
    
    echo '<div class="product-attributes mt-4" data-type="' . esc_attr($product_type) . '">';
    echo '<h5 class="mb-3">' . esc_html($product_types[$product_type]['label']) . ' ' . __('Details', 'festa-ceylon-wp') . '</h5>';
    echo '<div class="row">';
    
    $count = 0;
    foreach ($attributes as $key => $attribute) {
        $field_name = '_festa_' . $key;
        $value = get_post_meta($product->get_id(), $field_name, true);
        
        if (!empty($value)) {
            echo '<div class="col-md-6 mb-2">';
            echo '<strong>' . esc_html($attribute['label']) . ':</strong> ';
            
            // Format value based on type
            if ($attribute['type'] === 'select' && isset($attribute['options'][$value])) {
                echo '<span class="badge bg-secondary">' . esc_html($attribute['options'][$value]) . '</span>';
            } elseif ($attribute['type'] === 'textarea') {
                echo '<div class="mt-1"><small class="text-muted">' . wp_kses_post(nl2br($value)) . '</small></div>';
            } else {
                echo '<span class="text-muted">' . esc_html($value) . '</span>';
            }
            
            echo '</div>';
            
            $count++;
            if ($count % 2 === 0) {
                echo '</div><div class="row">';
            }
        }
    }
    
    echo '</div>';
    echo '</div>';
}

/**
 * Enqueue admin scripts
 */
function festa_ceylon_admin_scripts($hook) {
    global $post_type;
    
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        if ($post_type === 'product') {
            wp_enqueue_script(
                'festa-ceylon-product-attributes',
                get_template_directory_uri() . '/assets/js/admin-product-attributes.js',
                array('jquery'),
                FESTA_CEYLON_VERSION,
                true
            );
            
            wp_localize_script('festa-ceylon-product-attributes', 'festa_ceylon_admin', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('festa_ceylon_nonce'),
                'product_id' => isset($GLOBALS['post']) ? $GLOBALS['post']->ID : 0,
            ));
        }
    }
}