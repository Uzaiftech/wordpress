/**
 * Admin Product Attributes JavaScript
 * Handles dynamic loading of product attributes based on selected product type
 */

jQuery(document).ready(function($) {
    'use strict';
    
    // Handle product type change
    $('#_festa_product_type').on('change', function() {
        var productType = $(this).val();
        var $container = $('#festa-dynamic-attributes');
        
        if (!productType) {
            $container.html('<p class="form-field"><em>Select a product type above to see relevant attributes.</em></p>');
            return;
        }
        
        // Show loading state
        $container.html('<p class="form-field"><em>Loading attributes...</em></p>');
        
        // AJAX request to load attributes
        $.ajax({
            url: festa_ceylon_admin.ajax_url,
            type: 'POST',
            data: {
                action: 'festa_ceylon_load_attributes',
                product_type: productType,
                product_id: festa_ceylon_admin.product_id,
                nonce: festa_ceylon_admin.nonce
            },
            success: function(response) {
                if (response.success) {
                    $container.html(response.data);
                    
                    // Trigger change event for any select2 fields
                    $container.find('select').trigger('change');
                } else {
                    $container.html('<p class="form-field"><em style="color: red;">Error loading attributes: ' + response.data + '</em></p>');
                }
            },
            error: function() {
                $container.html('<p class="form-field"><em style="color: red;">Error loading attributes. Please try again.</em></p>');
            }
        });
    });
    
    // Load attributes on page load if product type is already selected
    var initialProductType = $('#_festa_product_type').val();
    if (initialProductType) {
        $('#_festa_product_type').trigger('change');
    }
    
    // Add validation for required fields
    $('form#post').on('submit', function(e) {
        var hasErrors = false;
        var errorMessages = [];
        
        // Check required fields
        $('#festa-dynamic-attributes .required').each(function() {
            var $label = $(this);
            var $field = $label.closest('p').find('input, select, textarea');
            
            if ($field.length && !$field.val()) {
                hasErrors = true;
                var fieldLabel = $label.parent().text().replace(' *', '');
                errorMessages.push('Please fill in the required field: ' + fieldLabel);
                
                // Highlight the field
                $field.css('border-color', '#dc3545');
            } else {
                // Remove highlight if field is filled
                $field.css('border-color', '');
            }
        });
        
        if (hasErrors) {
            e.preventDefault();
            alert('Please fill in all required fields:\n\n' + errorMessages.join('\n'));
            
            // Scroll to first error
            var $firstError = $('#festa-dynamic-attributes input[style*="border-color: rgb(220, 53, 69)"], #festa-dynamic-attributes select[style*="border-color: rgb(220, 53, 69)"], #festa-dynamic-attributes textarea[style*="border-color: rgb(220, 53, 69)"]').first();
            if ($firstError.length) {
                $('html, body').animate({
                    scrollTop: $firstError.offset().top - 100
                }, 500);
                $firstError.focus();
            }
        }
    });
    
    // Remove error highlighting when user starts typing/selecting
    $(document).on('input change', '#festa-dynamic-attributes input, #festa-dynamic-attributes select, #festa-dynamic-attributes textarea', function() {
        $(this).css('border-color', '');
    });
    
    // Add helpful tooltips
    $(document).on('mouseenter', '#festa-dynamic-attributes label', function() {
        var $this = $(this);
        var fieldName = $this.attr('for');
        var $field = $('#' + fieldName);
        
        if ($field.attr('placeholder')) {
            $this.attr('title', 'Example: ' + $field.attr('placeholder'));
        }
    });
    
    // Auto-save functionality (optional)
    var autoSaveTimeout;
    $(document).on('input change', '#festa-dynamic-attributes input, #festa-dynamic-attributes select, #festa-dynamic-attributes textarea', function() {
        clearTimeout(autoSaveTimeout);
        
        autoSaveTimeout = setTimeout(function() {
            // Trigger WordPress auto-save
            if (typeof wp !== 'undefined' && wp.autosave) {
                wp.autosave.server.triggerSave();
            }
        }, 2000);
    });
    
    // Add copy functionality for similar products
    if ($('#festa-copy-attributes').length === 0) {
        $('#_festa_product_type').after(
            '<p class="form-field">' +
            '<button type="button" id="festa-copy-attributes" class="button button-secondary" style="margin-left: 10px;">Copy from Similar Product</button>' +
            '</p>'
        );
    }
    
    $('#festa-copy-attributes').on('click', function(e) {
        e.preventDefault();
        
        var productType = $('#_festa_product_type').val();
        if (!productType) {
            alert('Please select a product type first.');
            return;
        }
        
        // This could be extended to show a modal with similar products
        alert('Copy functionality can be implemented to copy attributes from similar products of the same type.');
    });
});