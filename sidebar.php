<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Festa_Ceylon_WP
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar">
    <div class="sidebar-content">
        <?php dynamic_sidebar('sidebar-1'); ?>
        
        <?php if (!is_active_sidebar('sidebar-1')) : ?>
            <!-- Default sidebar content if no widgets are added -->
            <div class="widget card mb-4">
                <div class="card-body">
                    <h5 class="widget-title card-title"><?php esc_html_e('About Us', 'festa-ceylon-wp'); ?></h5>
                    <p class="card-text text-muted">
                        <?php esc_html_e('Welcome to our textile studio. We specialize in premium fabrics and handcrafted textile products.', 'festa-ceylon-wp'); ?>
                    </p>
                </div>
            </div>
            
            <?php if (class_exists('WooCommerce')) : ?>
                <div class="widget card mb-4">
                    <div class="card-body">
                        <h5 class="widget-title card-title"><?php esc_html_e('Product Categories', 'festa-ceylon-wp'); ?></h5>
                        <ul class="list-unstyled">
                            <?php
                            $product_categories = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'number' => 5,
                            ));
                            
                            if (!empty($product_categories) && !is_wp_error($product_categories)) :
                                foreach ($product_categories as $category) :
                                    ?>
                                    <li class="mb-2">
                                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="text-decoration-none">
                                            <?php echo esc_html($category->name); ?>
                                            <span class="badge bg-secondary ms-2"><?php echo esc_html($category->count); ?></span>
                                        </a>
                                    </li>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="widget card mb-4">
                <div class="card-body">
                    <h5 class="widget-title card-title"><?php esc_html_e('Recent Posts', 'festa-ceylon-wp'); ?></h5>
                    <?php
                    $recent_posts = wp_get_recent_posts(array(
                        'numberposts' => 5,
                        'post_status' => 'publish'
                    ));
                    
                    if (!empty($recent_posts)) :
                        ?>
                        <ul class="list-unstyled">
                            <?php foreach ($recent_posts as $post) : ?>
                                <li class="mb-3">
                                    <a href="<?php echo esc_url(get_permalink($post['ID'])); ?>" class="text-decoration-none">
                                        <h6 class="mb-1"><?php echo esc_html($post['post_title']); ?></h6>
                                    </a>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>
                                        <?php echo get_the_date('', $post['ID']); ?>
                                    </small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
            
            <div class="widget card mb-4">
                <div class="card-body">
                    <h5 class="widget-title card-title"><?php esc_html_e('Archives', 'festa-ceylon-wp'); ?></h5>
                    <ul class="list-unstyled">
                        <?php wp_get_archives(array('type' => 'monthly', 'limit' => 6)); ?>
                    </ul>
                </div>
            </div>
            
            <div class="widget card mb-4">
                <div class="card-body">
                    <h5 class="widget-title card-title"><?php esc_html_e('Contact Info', 'festa-ceylon-wp'); ?></h5>
                    <div class="contact-info">
                        <p class="mb-2">
                            <i class="bi bi-envelope me-2 text-primary"></i>
                            <small><?php echo esc_html(get_theme_mod('festa_ceylon_email', 'hello@textilestudio.com')); ?></small>
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-telephone me-2 text-primary"></i>
                            <small><?php echo esc_html(get_theme_mod('festa_ceylon_phone', '+1 (555) 123-4567')); ?></small>
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-geo-alt me-2 text-primary"></i>
                            <small><?php echo esc_html(get_theme_mod('festa_ceylon_address', '123 Fabric Street, Design District')); ?></small>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</aside><!-- #secondary -->