<?php
/**
 * The front page template file
 *
 * @package Festa_Ceylon_WP
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <!-- Hero Section -->
    <?php get_template_part('template-parts/components/hero'); ?>
    
    <!-- Featured Products Section -->
    <?php if (class_exists('WooCommerce')) : ?>
        <section class="featured-products py-5">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h2 class="display-5 fw-bold mb-3"><?php esc_html_e('Featured Products', 'festa-ceylon-wp'); ?></h2>
                        <p class="lead text-muted"><?php esc_html_e('Discover our handpicked selection of premium fabrics and textile products', 'festa-ceylon-wp'); ?></p>
                    </div>
                </div>
                
                <div class="row g-4">
                    <?php
                    // Get featured products
                    $featured_products = wc_get_featured_product_ids();
                    
                    if (!empty($featured_products)) {
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 8,
                            'post__in' => $featured_products,
                            'meta_query' => array(
                                array(
                                    'key' => '_visibility',
                                    'value' => array('catalog', 'visible'),
                                    'compare' => 'IN'
                                )
                            )
                        );
                    } else {
                        // Fallback to recent products if no featured products
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 8,
                            'meta_query' => array(
                                array(
                                    'key' => '_visibility',
                                    'value' => array('catalog', 'visible'),
                                    'compare' => 'IN'
                                )
                            )
                        );
                    }
                    
                    $products = new WP_Query($args);
                    
                    if ($products->have_posts()) :
                        while ($products->have_posts()) : $products->the_post();
                            global $product;
                            ?>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <?php get_template_part('template-parts/components/product-card'); ?>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
                
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn-primary btn-lg">
                            <?php esc_html_e('View All Products', 'festa-ceylon-wp'); ?>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Categories Section -->
    <?php get_template_part('template-parts/components/categories-section'); ?>
    
    <!-- Newsletter Section -->
    <?php get_template_part('template-parts/components/newsletter-section'); ?>
    
</main><!-- #main -->

<?php
get_footer();
?>