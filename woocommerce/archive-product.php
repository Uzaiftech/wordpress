<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * @package Festa_Ceylon_WP
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 */
do_action('woocommerce_before_main_content');
?>

<header class="woocommerce-products-header mb-4">
    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
        <h1 class="woocommerce-products-header__title page-title display-5 fw-bold mb-3">
            <?php woocommerce_page_title(); ?>
        </h1>
    <?php endif; ?>

    <?php
    /**
     * Hook: woocommerce_archive_description.
     */
    do_action('woocommerce_archive_description');
    ?>
</header>

<div class="row">
    <!-- Sidebar with Filters -->
    <div class="col-lg-3 col-md-4 mb-4">
        <div class="shop-sidebar">
            <!-- Product Search -->
            <div class="widget card mb-4">
                <div class="card-body">
                    <h5 class="widget-title card-title"><?php esc_html_e('Search Products', 'festa-ceylon-wp'); ?></h5>
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="woocommerce-product-search">
                        <div class="input-group">
                            <input type="search" class="form-control" placeholder="<?php esc_attr_e('Search products...', 'festa-ceylon-wp'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                            <input type="hidden" name="post_type" value="product" />
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Product Categories -->
            <?php
            $product_categories = get_terms(array(
                'taxonomy' => 'product_cat',
                'hide_empty' => true,
                'exclude' => array(get_option('default_product_cat')),
            ));
            
            if (!empty($product_categories) && !is_wp_error($product_categories)) :
                ?>
                <div class="widget card mb-4">
                    <div class="card-body">
                        <h5 class="widget-title card-title"><?php esc_html_e('Categories', 'festa-ceylon-wp'); ?></h5>
                        <ul class="list-unstyled">
                            <?php foreach ($product_categories as $category) : ?>
                                <li class="mb-2">
                                    <a href="<?php echo esc_url(get_term_link($category)); ?>" class="text-decoration-none d-flex justify-content-between align-items-center">
                                        <span><?php echo esc_html($category->name); ?></span>
                                        <span class="badge bg-secondary"><?php echo esc_html($category->count); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Price Filter -->
            <?php if (is_active_sidebar('woocommerce-sidebar')) : ?>
                <?php dynamic_sidebar('woocommerce-sidebar'); ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Products Area -->
    <div class="col-lg-9 col-md-8">
        <?php if (woocommerce_product_loop()) : ?>
            
            <!-- Shop Controls -->
            <div class="woocommerce-shop-controls d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded">
                <div class="woocommerce-result-count">
                    <?php woocommerce_result_count(); ?>
                </div>
                <div class="woocommerce-ordering">
                    <?php woocommerce_catalog_ordering(); ?>
                </div>
            </div>

            <?php
            woocommerce_product_loop_start();

            if (wc_get_loop_prop('is_shortcode')) {
                $columns = absint(wc_get_loop_prop('columns'));
            } else {
                $columns = wc_get_default_products_per_row();
            }

            while (have_posts()) {
                the_post();

                /**
                 * Hook: woocommerce_shop_loop.
                 */
                do_action('woocommerce_shop_loop');

                echo '<div class="col-lg-4 col-md-6 mb-4">';
                wc_get_template_part('content', 'product');
                echo '</div>';
            }

            woocommerce_product_loop_end();

            /**
             * Hook: woocommerce_after_shop_loop.
             */
            do_action('woocommerce_after_shop_loop');
            ?>

            <!-- Pagination -->
            <div class="woocommerce-pagination-wrapper mt-5">
                <?php
                /**
                 * Hook: woocommerce_after_shop_loop.
                 */
                do_action('woocommerce_after_shop_loop');
                ?>
            </div>

        <?php else : ?>
            
            <!-- No Products Found -->
            <div class="woocommerce-no-products-found text-center py-5">
                <div class="card">
                    <div class="card-body p-5">
                        <i class="bi bi-search display-1 text-muted mb-3"></i>
                        <h3 class="card-title"><?php esc_html_e('No products found', 'festa-ceylon-wp'); ?></h3>
                        <p class="card-text text-muted mb-4">
                            <?php esc_html_e('Sorry, no products were found matching your criteria. Try adjusting your search or browse our categories.', 'festa-ceylon-wp'); ?>
                        </p>
                        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn-primary">
                            <?php esc_html_e('Browse All Products', 'festa-ceylon-wp'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <?php
            /**
             * Hook: woocommerce_no_products_found.
             */
            do_action('woocommerce_no_products_found');
            ?>

        <?php endif; ?>
    </div>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
?>