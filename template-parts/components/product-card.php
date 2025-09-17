<?php
/**
 * Product Card Component
 *
 * @package Festa_Ceylon_WP
 */

if (!class_exists('WooCommerce')) {
    return;
}

global $product;

if (!$product) {
    return;
}

$product_id = $product->get_id();
$product_name = $product->get_name();
$product_price = $product->get_price_html();
$product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'medium');
$product_url = get_permalink($product_id);
$is_on_sale = $product->is_on_sale();
$is_in_stock = $product->is_in_stock();
$is_featured = $product->is_featured();
?>

<div class="product-card card h-100 border-0 shadow-sm hover-lift">
    <div class="position-relative overflow-hidden">
        <a href="<?php echo esc_url($product_url); ?>">
            <?php if ($product_image) : ?>
                <img src="<?php echo esc_url($product_image[0]); ?>" 
                     alt="<?php echo esc_attr($product_name); ?>" 
                     class="card-img-top product-image"
                     style="height: 250px; object-fit: cover; transition: transform 0.5s ease;">
            <?php else : ?>
                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 250px;">
                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                </div>
            <?php endif; ?>
        </a>
        
        <!-- Product Overlay -->
        <div class="product-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-25 opacity-0 transition-opacity"></div>
        
        <!-- Product Badges -->
        <div class="position-absolute top-3 start-3 d-flex flex-column gap-2">
            <?php if ($is_featured) : ?>
                <span class="badge bg-warning text-dark"><?php esc_html_e('Featured', 'festa-ceylon-wp'); ?></span>
            <?php endif; ?>
            
            <?php if ($is_on_sale) : ?>
                <span class="badge bg-danger"><?php esc_html_e('Sale', 'festa-ceylon-wp'); ?></span>
            <?php endif; ?>
            
            <?php if (!$is_in_stock) : ?>
                <span class="badge bg-secondary"><?php esc_html_e('Out of Stock', 'festa-ceylon-wp'); ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Product Actions -->
        <div class="product-actions position-absolute top-3 end-3 d-flex flex-column gap-2 opacity-0 transition-opacity">
            <!-- Wishlist Button -->
            <button type="button" class="btn btn-light btn-sm rounded-circle p-2 wishlist-btn" 
                    data-product-id="<?php echo esc_attr($product_id); ?>"
                    title="<?php esc_attr_e('Add to Wishlist', 'festa-ceylon-wp'); ?>">
                <i class="bi bi-heart"></i>
            </button>
            
            <!-- Quick View Button -->
            <a href="<?php echo esc_url($product_url); ?>" 
               class="btn btn-light btn-sm rounded-circle p-2"
               title="<?php esc_attr_e('Quick View', 'festa-ceylon-wp'); ?>">
                <i class="bi bi-eye"></i>
            </a>
        </div>
        
        <!-- Add to Cart Button (appears on hover) -->
        <div class="position-absolute bottom-3 start-3 end-3 opacity-0 transition-opacity add-to-cart-wrapper">
            <?php if ($is_in_stock) : ?>
                <button type="button" 
                        class="btn btn-primary w-100 btn-sm add-to-cart-btn" 
                        data-product-id="<?php echo esc_attr($product_id); ?>">
                    <i class="bi bi-bag me-2"></i>
                    <?php esc_html_e('Add to Cart', 'festa-ceylon-wp'); ?>
                </button>
            <?php else : ?>
                <button type="button" class="btn btn-secondary w-100 btn-sm" disabled>
                    <?php esc_html_e('Out of Stock', 'festa-ceylon-wp'); ?>
                </button>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="card-body p-3">
        <!-- Product Categories -->
        <?php
        $product_categories = wp_get_post_terms($product_id, 'product_cat');
        if (!empty($product_categories) && !is_wp_error($product_categories)) :
            ?>
            <div class="product-categories mb-2">
                <?php foreach (array_slice($product_categories, 0, 2) as $category) : ?>
                    <span class="badge bg-light text-muted me-1" style="font-size: 0.7rem;">
                        <?php echo esc_html($category->name); ?>
                    </span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Product Title -->
        <h5 class="card-title mb-2">
            <a href="<?php echo esc_url($product_url); ?>" class="text-decoration-none text-dark">
                <?php echo esc_html($product_name); ?>
            </a>
        </h5>
        
        <!-- Product Rating -->
        <?php if ($product->get_average_rating()) : ?>
            <div class="product-rating mb-2">
                <?php
                $rating = $product->get_average_rating();
                $rating_count = $product->get_rating_count();
                ?>
                <div class="d-flex align-items-center">
                    <div class="stars text-warning me-2">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <i class="bi bi-star<?php echo $i <= $rating ? '-fill' : ''; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <small class="text-muted">(<?php echo esc_html($rating_count); ?>)</small>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Product Price -->
        <div class="product-price mb-3">
            <span class="h6 text-primary fw-bold"><?php echo wp_kses_post($product_price); ?></span>
        </div>
        
        <!-- Product Actions Footer -->
        <div class="d-flex justify-content-between align-items-center">
            <?php if ($is_in_stock) : ?>
                <button type="button" 
                        class="btn btn-outline-primary btn-sm add-to-cart-btn" 
                        data-product-id="<?php echo esc_attr($product_id); ?>">
                    <i class="bi bi-bag me-1"></i>
                    <?php esc_html_e('Add', 'festa-ceylon-wp'); ?>
                </button>
            <?php else : ?>
                <button type="button" class="btn btn-outline-secondary btn-sm" disabled>
                    <?php esc_html_e('Out of Stock', 'festa-ceylon-wp'); ?>
                </button>
            <?php endif; ?>
            
            <a href="<?php echo esc_url($product_url); ?>" class="btn btn-link btn-sm p-0">
                <?php esc_html_e('View Details', 'festa-ceylon-wp'); ?>
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>

<style>
.product-card:hover .product-overlay,
.product-card:hover .product-actions,
.product-card:hover .add-to-cart-wrapper {
    opacity: 1 !important;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-card .transition-opacity {
    transition: opacity 0.3s ease;
}

.product-card .card-title a:hover {
    color: var(--bs-primary) !important;
}

.wishlist-btn.active {
    background-color: var(--bs-danger) !important;
    color: white !important;
}

.wishlist-btn.active i::before {
    content: "\f2eb"; /* filled heart */
}
</style>