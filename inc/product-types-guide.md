# Product Types System - Developer Guide

## Overview

The Festa Ceylon theme includes a comprehensive product attributes system that allows you to create different product types with their own specific attributes. Currently, the system supports three product types:

1. **Fabrics** - Raw materials for tailoring and crafting
2. **Shawls** - Fashion accessories and wraps  
3. **Cloths** - Ready-to-wear clothing items

## Architecture

The system is built using the following components:

- **Main Class**: `Festa_Ceylon_Product_Types` (in `/inc/product-attributes.php`)
- **Admin JavaScript**: `/assets/js/admin-product-attributes.js`
- **Integration**: Hooks into WooCommerce product admin and frontend display

## Adding a New Product Type

### Step 1: Define the Product Type

Edit `/inc/product-attributes.php` and add your new product type to the `get_product_types()` method:

```php
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
        ),
        // Add your new product type here
        'your_new_type' => array(
            'label' => __('Your New Type', 'festa-ceylon-wp'),
            'description' => __('Description of your new product type', 'festa-ceylon-wp'),
            'attributes' => self::get_your_new_type_attributes()
        )
    );
}
```

### Step 2: Define Attributes for Your Product Type

Create a new method in the same class to define the attributes:

```php
/**
 * Get your-new-type-specific attributes
 */
public static function get_your_new_type_attributes() {
    return array(
        'attribute_key' => array(
            'label' => __('Attribute Label', 'festa-ceylon-wp'),
            'type' => 'select', // or 'text', 'textarea'
            'options' => array( // only for select type
                'option1' => __('Option 1', 'festa-ceylon-wp'),
                'option2' => __('Option 2', 'festa-ceylon-wp'),
            ),
            'required' => true, // or false
            'placeholder' => __('Placeholder text', 'festa-ceylon-wp') // for text/textarea
        ),
        // Add more attributes as needed
    );
}
```

### Step 3: Attribute Field Types

The system supports three field types:

#### Select Field
```php
'field_name' => array(
    'label' => __('Field Label', 'festa-ceylon-wp'),
    'type' => 'select',
    'options' => array(
        'value1' => __('Display Text 1', 'festa-ceylon-wp'),
        'value2' => __('Display Text 2', 'festa-ceylon-wp'),
    ),
    'required' => true
)
```

#### Text Field
```php
'field_name' => array(
    'label' => __('Field Label', 'festa-ceylon-wp'),
    'type' => 'text',
    'placeholder' => __('Enter value...', 'festa-ceylon-wp'),
    'required' => false
)
```

#### Textarea Field
```php
'field_name' => array(
    'label' => __('Field Label', 'festa-ceylon-wp'),
    'type' => 'textarea',
    'placeholder' => __('Enter detailed information...', 'festa-ceylon-wp'),
    'required' => false
)
```

## Attribute Naming Convention

- Use lowercase with underscores for attribute keys
- Prefix will be automatically added (`_festa_`) when saving to database
- Example: `fabric_type` becomes `_festa_fabric_type` in the database

## Frontend Display

Attributes are automatically displayed on the single product page using the `festa_ceylon_display_product_attributes()` function. The display includes:

- Automatic formatting based on field type
- Select fields show as badges
- Text fields show as plain text
- Textarea fields show with line breaks preserved
- Empty fields are not displayed

## Customizing Frontend Display

To customize how attributes are displayed, you can:

1. **Override the display function**: Remove the default hook and add your own
```php
remove_action('woocommerce_single_product_summary', 'festa_ceylon_display_product_attributes', 25);
add_action('woocommerce_single_product_summary', 'your_custom_display_function', 25);
```

2. **Use CSS to style the output**: Target the `.product-attributes` class
```css
.product-attributes {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
}
```

3. **Filter the attributes before display**: Use WordPress filters
```php
add_filter('festa_ceylon_product_attributes_display', 'your_filter_function', 10, 3);
```

## Database Storage

All attributes are stored as WordPress post meta with the following pattern:
- Meta key: `_festa_[attribute_key]`
- Meta value: The sanitized user input

Example:
- Attribute key: `fabric_type`
- Database key: `_festa_fabric_type`
- Value: `cotton`

## Retrieving Attributes Programmatically

```php
// Get product type
$product_type = get_post_meta($product_id, '_festa_product_type', true);

// Get specific attribute
$fabric_type = get_post_meta($product_id, '_festa_fabric_type', true);

// Get all attributes for a product type
$product_types = Festa_Ceylon_Product_Types::get_product_types();
if (isset($product_types[$product_type])) {
    $attributes = $product_types[$product_type]['attributes'];
    
    foreach ($attributes as $key => $config) {
        $value = get_post_meta($product_id, '_festa_' . $key, true);
        // Process the value
    }
}
```

## Admin Interface Features

The admin interface includes:

- **Dynamic Loading**: Attributes load via AJAX when product type is selected
- **Validation**: Required fields are validated before saving
- **Auto-save**: Changes are automatically saved (optional)
- **Error Highlighting**: Invalid fields are highlighted in red
- **Tooltips**: Helpful hints based on placeholder text

## Extending the System

### Adding Custom Validation

```php
add_action('woocommerce_process_product_meta', 'your_custom_validation', 5);

function your_custom_validation($post_id) {
    $product_type = get_post_meta($post_id, '_festa_product_type', true);
    
    if ($product_type === 'your_type') {
        $required_field = $_POST['_festa_your_field'] ?? '';
        
        if (empty($required_field)) {
            // Add error handling
            add_action('admin_notices', function() {
                echo '<div class="notice notice-error"><p>Your field is required!</p></div>';
            });
        }
    }
}
```

### Adding Custom Field Types

To add new field types, modify the `festa_ceylon_ajax_load_attributes()` function in `/inc/product-attributes.php`:

```php
case 'your_custom_type':
    // Your custom field HTML generation
    $html .= '<input type="your-type" ...>';
    break;
```

## Best Practices

1. **Use Translation Functions**: Always wrap text in `__()` or `esc_html__()`
2. **Sanitize Input**: Use appropriate sanitization functions
3. **Validate Data**: Check required fields and data formats
4. **Follow Naming Conventions**: Use consistent naming patterns
5. **Test Thoroughly**: Test with different product types and edge cases

## Troubleshooting

### Common Issues

1. **Attributes not loading**: Check JavaScript console for AJAX errors
2. **Data not saving**: Verify field names match the expected pattern
3. **Display issues**: Check if product type is set correctly
4. **Translation issues**: Ensure text domain is correct (`festa-ceylon-wp`)

### Debug Mode

Enable WordPress debug mode to see detailed error messages:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

## Example: Adding "Jewelry" Product Type

Here's a complete example of adding a new "Jewelry" product type:

```php
// In get_product_types() method
'jewelry' => array(
    'label' => __('Jewelry', 'festa-ceylon-wp'),
    'description' => __('Handcrafted jewelry and accessories', 'festa-ceylon-wp'),
    'attributes' => self::get_jewelry_attributes()
),

// New method for jewelry attributes
public static function get_jewelry_attributes() {
    return array(
        'jewelry_type' => array(
            'label' => __('Jewelry Type', 'festa-ceylon-wp'),
            'type' => 'select',
            'options' => array(
                'necklace' => __('Necklace', 'festa-ceylon-wp'),
                'earrings' => __('Earrings', 'festa-ceylon-wp'),
                'bracelet' => __('Bracelet', 'festa-ceylon-wp'),
                'ring' => __('Ring', 'festa-ceylon-wp'),
            ),
            'required' => true
        ),
        'metal_type' => array(
            'label' => __('Metal Type', 'festa-ceylon-wp'),
            'type' => 'select',
            'options' => array(
                'gold' => __('Gold', 'festa-ceylon-wp'),
                'silver' => __('Silver', 'festa-ceylon-wp'),
                'platinum' => __('Platinum', 'festa-ceylon-wp'),
            ),
            'required' => true
        ),
        'gemstone' => array(
            'label' => __('Gemstone', 'festa-ceylon-wp'),
            'type' => 'text',
            'placeholder' => __('e.g., Diamond, Ruby, Sapphire', 'festa-ceylon-wp'),
            'required' => false
        ),
        'jewelry_size' => array(
            'label' => __('Size', 'festa-ceylon-wp'),
            'type' => 'text',
            'placeholder' => __('e.g., 16 inches, Size 7', 'festa-ceylon-wp'),
            'required' => false
        )
    );
}
```

This system provides a flexible foundation for managing different product types with their specific attributes while maintaining consistency and ease of use.