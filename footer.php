    </div><!-- #content -->

    <footer id="colophon" class="site-footer footer mt-5">
        <div class="container py-5">
            <div class="row g-4">
                <!-- Brand Section -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-brand mb-4">
                        <?php if (has_custom_logo()) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            <div class="d-flex align-items-center mb-3">
                                <div class="logo-placeholder bg-primary rounded me-2" style="width: 32px; height: 32px;"></div>
                                <span class="footer-brand-text fw-bold fs-5"><?php bloginfo('name'); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <p class="text-muted small">
                            <?php 
                            $description = get_bloginfo('description');
                            if ($description) {
                                echo esc_html($description);
                            } else {
                                esc_html_e('Premium fabrics and textile artistry for discerning creators. Quality materials, exceptional craftsmanship, timeless designs.', 'festa-ceylon-wp');
                            }
                            ?>
                        </p>
                        
                        <!-- Social Media Links -->
                        <div class="social-links d-flex gap-3">
                            <?php if (get_theme_mod('festa_ceylon_facebook')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('festa_ceylon_facebook')); ?>" class="text-muted" target="_blank" rel="noopener">
                                    <i class="bi bi-facebook fs-5"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('festa_ceylon_instagram')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('festa_ceylon_instagram')); ?>" class="text-muted" target="_blank" rel="noopener">
                                    <i class="bi bi-instagram fs-5"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('festa_ceylon_twitter')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('festa_ceylon_twitter')); ?>" class="text-muted" target="_blank" rel="noopener">
                                    <i class="bi bi-twitter fs-5"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Footer Widget Areas -->
                <div class="col-lg-2 col-md-6">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <?php dynamic_sidebar('footer-1'); ?>
                    <?php else : ?>
                        <h5 class="fw-semibold mb-3"><?php esc_html_e('Shop', 'festa-ceylon-wp'); ?></h5>
                        <ul class="list-unstyled footer-links">
                            <li><a href="<?php echo esc_url(home_url('/shop')); ?>" class="text-muted small"><?php esc_html_e('All Products', 'festa-ceylon-wp'); ?></a></li>
                            <?php if (class_exists('WooCommerce')) : ?>
                                <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="text-muted small"><?php esc_html_e('Fabrics by Meter', 'festa-ceylon-wp'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/ready-made')); ?>" class="text-muted small"><?php esc_html_e('Ready-Made', 'festa-ceylon-wp'); ?></a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo esc_url(home_url('/new')); ?>" class="text-muted small"><?php esc_html_e('New Arrivals', 'festa-ceylon-wp'); ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="col-lg-2 col-md-6">
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <?php dynamic_sidebar('footer-2'); ?>
                    <?php else : ?>
                        <h5 class="fw-semibold mb-3"><?php esc_html_e('Company', 'festa-ceylon-wp'); ?></h5>
                        <ul class="list-unstyled footer-links">
                            <li><a href="<?php echo esc_url(home_url('/about')); ?>" class="text-muted small"><?php esc_html_e('About Us', 'festa-ceylon-wp'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact')); ?>" class="text-muted small"><?php esc_html_e('Contact', 'festa-ceylon-wp'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/careers')); ?>" class="text-muted small"><?php esc_html_e('Careers', 'festa-ceylon-wp'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/press')); ?>" class="text-muted small"><?php esc_html_e('Press', 'festa-ceylon-wp'); ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="col-lg-2 col-md-6">
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <?php dynamic_sidebar('footer-3'); ?>
                    <?php else : ?>
                        <h5 class="fw-semibold mb-3"><?php esc_html_e('Support', 'festa-ceylon-wp'); ?></h5>
                        <ul class="list-unstyled footer-links">
                            <li><a href="<?php echo esc_url(home_url('/shipping')); ?>" class="text-muted small"><?php esc_html_e('Shipping & Returns', 'festa-ceylon-wp'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/size-guide')); ?>" class="text-muted small"><?php esc_html_e('Size Guide', 'festa-ceylon-wp'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/care')); ?>" class="text-muted small"><?php esc_html_e('Care Instructions', 'festa-ceylon-wp'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/faq')); ?>" class="text-muted small"><?php esc_html_e('FAQ', 'festa-ceylon-wp'); ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="col-lg-3 col-md-6">
                    <?php if (is_active_sidebar('footer-4')) : ?>
                        <?php dynamic_sidebar('footer-4'); ?>
                    <?php else : ?>
                        <h5 class="fw-semibold mb-3"><?php esc_html_e('Policies', 'festa-ceylon-wp'); ?></h5>
                        <ul class="list-unstyled footer-links">
                            <li><a href="<?php echo esc_url(home_url('/privacy')); ?>" class="text-muted small"><?php esc_html_e('Privacy Policy', 'festa-ceylon-wp'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/terms')); ?>" class="text-muted small"><?php esc_html_e('Terms of Service', 'festa-ceylon-wp'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/returns')); ?>" class="text-muted small"><?php esc_html_e('Return Policy', 'festa-ceylon-wp'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/cookies')); ?>" class="text-muted small"><?php esc_html_e('Cookie Policy', 'festa-ceylon-wp'); ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="row border-top pt-4 mt-4">
                <div class="col-12">
                    <div class="row g-3 text-muted small">
                        <div class="col-md-4 d-flex align-items-center">
                            <i class="bi bi-envelope me-2"></i>
                            <span><?php echo esc_html(get_theme_mod('festa_ceylon_email', 'hello@textilestudio.com')); ?></span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <i class="bi bi-telephone me-2"></i>
                            <span><?php echo esc_html(get_theme_mod('festa_ceylon_phone', '+1 (555) 123-4567')); ?></span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <i class="bi bi-geo-alt me-2"></i>
                            <span><?php echo esc_html(get_theme_mod('festa_ceylon_address', '123 Fabric Street, Design District')); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="row border-top pt-4 mt-4">
                <div class="col-12 text-center">
                    <p class="text-muted small mb-0">
                        &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'festa-ceylon-wp'); ?>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button type="button" class="btn btn-primary btn-floating btn-lg" id="btn-back-to-top" style="position: fixed; bottom: 20px; right: 20px; display: none; z-index: 1000;">
        <i class="bi bi-arrow-up"></i>
    </button>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>