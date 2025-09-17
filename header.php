<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'festa-ceylon-wp'); ?></a>

    <header id="masthead" class="site-header">
        <nav class="navbar navbar-expand-lg navbar-light sticky-top">
            <div class="container">
                <!-- Logo/Brand -->
                <a class="navbar-brand d-flex align-items-center" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <div class="brand-logo me-2">
                            <div class="logo-placeholder bg-primary rounded" style="width: 32px; height: 32px;"></div>
                        </div>
                        <span class="brand-text fw-bold fs-5"><?php bloginfo('name'); ?></span>
                    <?php endif; ?>
                </a>

                <!-- Mobile Menu Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'festa-ceylon-wp'); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="navbar-nav mx-auto">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_class'     => 'navbar-nav',
                            'container'      => false,
                            'depth'          => 2,
                            'walker'         => new class extends Walker_Nav_Menu {
                                function start_lvl(&$output, $depth = 0, $args = null) {
                                    $output .= '<ul class="dropdown-menu">';
                                }
                                
                                function end_lvl(&$output, $depth = 0, $args = null) {
                                    $output .= '</ul>';
                                }
                                
                                function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                                    $classes = empty($item->classes) ? array() : (array) $item->classes;
                                    $classes[] = 'nav-item';
                                    
                                    if (in_array('menu-item-has-children', $classes)) {
                                        $classes[] = 'dropdown';
                                    }
                                    
                                    $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
                                    $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
                                    
                                    $output .= '<li' . $class_names . '>';
                                    
                                    $link_classes = array('nav-link');
                                    if (in_array('menu-item-has-children', $classes)) {
                                        $link_classes[] = 'dropdown-toggle';
                                    }
                                    
                                    $link_class = ' class="' . implode(' ', $link_classes) . '"';
                                    
                                    $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
                                    $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
                                    $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
                                    $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
                                    
                                    if (in_array('menu-item-has-children', $classes)) {
                                        $attributes .= ' data-bs-toggle="dropdown" aria-expanded="false"';
                                    }
                                    
                                    $item_output = '<a' . $link_class . $attributes . '>';
                                    $item_output .= apply_filters('the_title', $item->title, $item->ID);
                                    $item_output .= '</a>';
                                    
                                    $output .= $item_output;
                                }
                                
                                function end_el(&$output, $item, $depth = 0, $args = null) {
                                    $output .= '</li>';
                                }
                            }
                        ));
                        ?>
                    </div>

                    <!-- Header Actions -->
                    <div class="navbar-nav ms-auto">
                        <div class="nav-item d-flex align-items-center gap-2">
                            <!-- Search Button -->
                            <button class="btn btn-outline-primary btn-sm d-none d-sm-inline-flex" type="button" data-bs-toggle="modal" data-bs-target="#searchModal">
                                <i class="bi bi-search"></i>
                            </button>

                            <!-- Wishlist -->
                            <?php if (class_exists('WooCommerce')) : ?>
                                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="btn btn-outline-primary btn-sm position-relative">
                                    <i class="bi bi-heart"></i>
                                    <span class="wishlist-count badge bg-primary rounded-pill position-absolute top-0 start-100 translate-middle" style="font-size: 0.6rem;">0</span>
                                </a>

                                <!-- Cart -->
                                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="btn btn-outline-primary btn-sm position-relative">
                                    <i class="bi bi-bag"></i>
                                    <span class="cart-count badge bg-primary rounded-pill position-absolute top-0 start-100 translate-middle" style="font-size: 0.6rem;"><?php echo festa_ceylon_cart_count(); ?></span>
                                </a>

                                <!-- Account -->
                                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="btn btn-outline-primary btn-sm d-none d-sm-inline-flex">
                                    <i class="bi bi-person"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="searchModalLabel"><?php esc_html_e('Search Products', 'festa-ceylon-wp'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'festa-ceylon-wp'); ?>"></button>
                </div>
                <div class="modal-body">
                    <?php if (class_exists('WooCommerce')) : ?>
                        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="woocommerce-product-search">
                            <div class="input-group">
                                <input type="search" class="form-control form-control-lg" placeholder="<?php esc_attr_e('Search products...', 'festa-ceylon-wp'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                                <input type="hidden" name="post_type" value="product" />
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    <?php else : ?>
                        <?php get_search_form(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div id="content" class="site-content">