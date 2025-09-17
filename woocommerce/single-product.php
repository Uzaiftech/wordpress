<?php
/**
 * The Template for displaying all single products
 *
 * @package Festa_Ceylon_WP
 */

defined('ABSPATH') || exit;

get_header('shop'); ?>

<?php
/**
 * woocommerce_before_main_content hook.
 */
do_action('woocommerce_before_main_content');
?>

<?php while (have_posts()) : ?>
    <?php the_post(); ?>

    <div id="product-<?php the_ID(); ?>" <?php wc_product_class('single-product-wrapper', $product); ?>>
        
        <!-- Product Breadcrumbs -->
        <div class="product-breadcrumbs mb-4">
            <?php
            /**
             * woocommerce_before_single_product_summary hook.
             */
            do_action('woocommerce_before_single_product');
            ?>
        </div>

        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6 mb-4">
                <div class="product-images-wrapper">
                    <?php
                    /**
                     * woocommerce_before_single_product_summary hook.
                     */
                    do_action('woocommerce_before_single_product_summary');
                    ?>
                </div>
            </div>

            <!-- Product Summary -->
            <div class="col-lg-6">
                <div class="summary entry-summary">
                    <div class="product-summary-wrapper">
                        <?php
                        /**
                         * woocommerce_single_product_summary hook.
                         */
                        do_action('woocommerce_single_product_summary');
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Data Tabs -->
        <div class="product-tabs-wrapper mt-5">
            <?php
            /**
             * woocommerce_after_single_product_summary hook.
             */
            do_action('woocommerce_after_single_product_summary');
            ?>
        </div>

        <!-- Related Products -->
        <div class="related-products-wrapper mt-5">
            <?php
            // Get related products
            $related_products = wc_get_related_products($product->get_id(), 4);
            
            if (!empty($related_products)) :
                ?>
                <section class="related-products py-5 bg-light rounded">
                    <div class="container-fluid">
                        <h3 class="text-center mb-4"><?php esc_html_e('Related Products', 'festa-ceylon-wp'); ?></h3>
                        <div class="row g-4">
                            <?php
                            foreach ($related_products as $related_product_id) :
                                $related_product = wc_get_product($related_product_id);
                                if (!$related_product) continue;
                                ?>
                                <div class="col-lg-3 col-md-6">
                                    <div class="product-card card h-100 border-0 shadow-sm hover-lift">
                                        <div class="position-relative overflow-hidden">
                                            <a href="<?php echo esc_url(get_permalink($related_product_id)); ?>">
                                                <?php
                                                $image = wp_get_attachment_image_src(get_post_thumbnail_id($related_product_id), 'medium');
                                                if ($image) :
                                                    ?>
                                                    <img src="<?php echo esc_url($image[0]); ?>" 
                                                         alt="<?php echo esc_attr($related_product->get_name()); ?>" 
                                                         class="card-img-top"
                                                         style="height: 200px; object-fit: cover;">
                                                <?php else : ?>
                                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                                        <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <div class="card-body p-3">
                                            <h6 class="card-title">
                                                <a href="<?php echo esc_url(get_permalink($related_product_id)); ?>" class="text-decoration-none text-dark">
                                                    <?php echo esc_html($related_product->get_name()); ?>
                                                </a>
                                            </h6>
                                            <div class="product-price text-primary fw-bold">
                                                <?php echo wp_kses_post($related_product->get_price_html()); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                </section>
                <?php
            endif;
            ?>
        </div>

    </div>

    <?php
    /**
     * woocommerce_after_single_product hook.
     */
    do_action('woocommerce_after_single_product');
    ?>

<?php endwhile; // end of the loop. ?>

<?php
/**
 * woocommerce_after_main_content hook.
 */
do_action('woocommerce_after_main_content');
?>

<style>
/* Single Product Styling */
.single-product-wrapper .product-images-wrapper .woocommerce-product-gallery {
    margin-bottom: 0;
}

.single-product-wrapper .product-images-wrapper .woocommerce-product-gallery__wrapper {
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.single-product-wrapper .product-images-wrapper .woocommerce-product-gallery__image {
    margin-bottom: 0;
}

.single-product-wrapper .summary .product_title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--bs-dark);
}

.single-product-wrapper .summary .price {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--bs-primary);
    margin-bottom: 1rem;
}

.single-product-wrapper .summary .woocommerce-product-rating {
    margin-bottom: 1rem;
}

.single-product-wrapper .summary .woocommerce-product-details__short-description {
    font-size: 1.1rem;
    line-height: 1.6;
    color: var(--bs-secondary);
    margin-bottom: 2rem;
}

.single-product-wrapper .summary .cart {
    margin-bottom: 2rem;
}

.single-product-wrapper .summary .cart .quantity {
    margin-right: 1rem;
}

.single-product-wrapper .summary .cart .quantity input {
    width: 80px;
    text-align: center;
    border-radius: 0.5rem;
}

.single-product-wrapper .summary .cart .single_add_to_cart_button {
    padding: 0.75rem 2rem;
    font-weight: 600;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.single-product-wrapper .summary .cart .single_add_to_cart_button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(217, 119, 6, 0.3);
}

.single-product-wrapper .product_meta {
    border-top: 1px solid var(--bs-border-color);
    padding-top: 1rem;
    margin-top: 2rem;
}

.single-product-wrapper .product_meta > span {
    display: block;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

/* Product Tabs Styling */
.product-tabs-wrapper .nav-tabs {
    border-bottom: 2px solid var(--bs-border-color);
}

.product-tabs-wrapper .nav-tabs .nav-link {
    border: none;
    border-bottom: 2px solid transparent;
    background: none;
    color: var(--bs-secondary);
    font-weight: 600;
    padding: 1rem 1.5rem;
    transition: all 0.3s ease;
}

.product-tabs-wrapper .nav-tabs .nav-link:hover {
    border-bottom-color: var(--bs-primary);
    color: var(--bs-primary);
}

.product-tabs-wrapper .nav-tabs .nav-link.active {
    border-bottom-color: var(--bs-primary);
    color: var(--bs-primary);
    background: none;
}

.product-tabs-wrapper .tab-content {
    border: 1px solid var(--bs-border-color);
    border-top: none;
    border-radius: 0 0 0.5rem 0.5rem;
}

/* Related Products Styling */
.related-products .product-card:hover {
    transform: translateY(-5px);
}

.related-products .product-card .card-img-top {
    transition: transform 0.3s ease;
}

.related-products .product-card:hover .card-img-top {
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    .single-product-wrapper .summary .product_title {
        font-size: 1.5rem;
    }
    
    .single-product-wrapper .summary .price {
        font-size: 1.25rem;
    }
    
    .single-product-wrapper .summary .cart {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .single-product-wrapper .summary .cart .quantity {
        margin-right: 0;
    }
}
</style>

<?php
get_footer('shop');
?>