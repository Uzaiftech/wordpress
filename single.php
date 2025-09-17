<?php
/**
 * The template for displaying all single posts
 *
 * @package Festa_Ceylon_WP
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="card-img-top-wrapper position-relative overflow-hidden" style="height: 400px;">
                                <?php the_post_thumbnail('large', array('class' => 'card-img-top w-100 h-100 object-fit-cover')); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body p-4">
                            <header class="entry-header mb-4">
                                <?php the_title('<h1 class="entry-title display-6 fw-bold mb-3">', '</h1>'); ?>
                                
                                <div class="entry-meta text-muted d-flex flex-wrap gap-3 mb-3">
                                    <span>
                                        <i class="bi bi-calendar me-1"></i>
                                        <?php echo get_the_date(); ?>
                                    </span>
                                    <span>
                                        <i class="bi bi-person me-1"></i>
                                        <?php the_author(); ?>
                                    </span>
                                    <?php if (get_the_category_list()) : ?>
                                        <span>
                                            <i class="bi bi-folder me-1"></i>
                                            <?php the_category(', '); ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (get_the_tag_list()) : ?>
                                        <span>
                                            <i class="bi bi-tags me-1"></i>
                                            <?php the_tags('', ', '); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </header><!-- .entry-header -->

                            <div class="entry-content">
                                <?php
                                the_content(
                                    sprintf(
                                        wp_kses(
                                            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'festa-ceylon-wp'),
                                            array(
                                                'span' => array(
                                                    'class' => array(),
                                                ),
                                            )
                                        ),
                                        wp_kses_post(get_the_title())
                                    )
                                );

                                wp_link_pages(
                                    array(
                                        'before' => '<div class="page-links mt-4"><span class="page-links-title">' . esc_html__('Pages:', 'festa-ceylon-wp') . '</span>',
                                        'after'  => '</div>',
                                    )
                                );
                                ?>
                            </div><!-- .entry-content -->

                            <footer class="entry-footer mt-4 pt-4 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="post-navigation-links">
                                        <?php
                                        $prev_post = get_previous_post();
                                        $next_post = get_next_post();
                                        ?>
                                        
                                        <?php if ($prev_post) : ?>
                                            <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="btn btn-outline-primary btn-sm me-2">
                                                <i class="bi bi-arrow-left me-1"></i>
                                                <?php esc_html_e('Previous', 'festa-ceylon-wp'); ?>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if ($next_post) : ?>
                                            <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="btn btn-outline-primary btn-sm">
                                                <?php esc_html_e('Next', 'festa-ceylon-wp'); ?>
                                                <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="social-share">
                                        <span class="text-muted small me-2"><?php esc_html_e('Share:', 'festa-ceylon-wp'); ?></span>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="btn btn-outline-primary btn-sm me-1">
                                            <i class="bi bi-facebook"></i>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="btn btn-outline-primary btn-sm me-1">
                                            <i class="bi bi-twitter"></i>
                                        </a>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-linkedin"></i>
                                        </a>
                                    </div>
                                </div>
                            </footer><!-- .entry-footer -->
                        </div>
                    </article><!-- #post-<?php the_ID(); ?> -->

                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        ?>
                        <div class="comments-section mt-5">
                            <?php comments_template(); ?>
                        </div>
                        <?php
                    endif;
                    ?>

                    <?php
                endwhile; // End of the loop.
                ?>
            </div>

            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</main><!-- #main -->

<?php
get_footer();
?>