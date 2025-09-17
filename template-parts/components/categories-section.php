<?php
/**
 * Categories Section Component
 *
 * @package Festa_Ceylon_WP
 */

if (!class_exists('WooCommerce')) {
    return;
}

// Get product categories
$categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => true,
    'exclude' => array(get_option('default_product_cat')), // Exclude uncategorized
    'number' => 6,
));

if (empty($categories) || is_wp_error($categories)) {
    return;
}
?>

<section class="categories-section py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold mb-3"><?php esc_html_e('Shop by Category', 'festa-ceylon-wp'); ?></h2>
                <p class="lead text-muted"><?php esc_html_e('Explore our diverse collection of premium textiles and fabrics', 'festa-ceylon-wp'); ?></p>
            </div>
        </div>
        
        <div class="row g-4">
            <?php foreach ($categories as $category) : 
                $category_image_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $category_image = wp_get_attachment_image_src($category_image_id, 'medium');
                $category_url = get_term_link($category);
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="category-card card h-100 border-0 shadow-sm hover-lift">
                        <div class="position-relative overflow-hidden">
                            <a href="<?php echo esc_url($category_url); ?>">
                                <?php if ($category_image) : ?>
                                    <img src="<?php echo esc_url($category_image[0]); ?>" 
                                         alt="<?php echo esc_attr($category->name); ?>" 
                                         class="card-img-top category-image"
                                         style="height: 200px; object-fit: cover; transition: transform 0.5s ease;">
                                <?php else : ?>
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-gradient-primary text-white" 
                                         style="height: 200px; background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-secondary) 100%);">
                                        <div class="text-center">
                                            <i class="bi bi-grid-3x3-gap display-4 mb-2"></i>
                                            <h5 class="mb-0"><?php echo esc_html($category->name); ?></h5>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </a>
                            
                            <!-- Category Overlay -->
                            <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-40 d-flex align-items-center justify-content-center opacity-0 transition-opacity">
                                <div class="text-center text-white">
                                    <h5 class="mb-2"><?php echo esc_html($category->name); ?></h5>
                                    <p class="mb-3 small"><?php printf(esc_html__('%d Products', 'festa-ceylon-wp'), $category->count); ?></p>
                                    <span class="btn btn-light btn-sm">
                                        <?php esc_html_e('Shop Now', 'festa-ceylon-wp'); ?>
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title mb-2">
                                <a href="<?php echo esc_url($category_url); ?>" class="text-decoration-none text-dark">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            </h5>
                            
                            <?php if ($category->description) : ?>
                                <p class="card-text text-muted small mb-3">
                                    <?php echo esc_html(wp_trim_words($category->description, 15)); ?>
                                </p>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">
                                    <?php printf(esc_html__('%d Products', 'festa-ceylon-wp'), $category->count); ?>
                                </span>
                                <a href="<?php echo esc_url($category_url); ?>" class="btn btn-outline-primary btn-sm">
                                    <?php esc_html_e('Explore', 'festa-ceylon-wp'); ?>
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- View All Categories Button -->
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('View All Categories', 'festa-ceylon-wp'); ?>
                    <i class="bi bi-grid ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.category-card:hover .category-overlay {
    opacity: 1 !important;
}

.category-card:hover .category-image {
    transform: scale(1.05);
}

.category-card .transition-opacity {
    transition: opacity 0.3s ease;
}

.category-card .card-title a:hover {
    color: var(--bs-primary) !important;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-secondary) 100%) !important;
}

@media (max-width: 768px) {
    .category-card .card-img-top,
    .category-card .bg-gradient-primary {
        height: 150px !important;
    }
}
</style>