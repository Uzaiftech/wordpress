<?php
/**
 * The template for displaying all pages
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
                            <div class="card-img-top-wrapper position-relative overflow-hidden" style="height: 300px;">
                                <?php the_post_thumbnail('large', array('class' => 'card-img-top w-100 h-100 object-fit-cover')); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body p-4">
                            <header class="entry-header mb-4">
                                <?php the_title('<h1 class="entry-title display-6 fw-bold">', '</h1>'); ?>
                            </header><!-- .entry-header -->

                            <div class="entry-content">
                                <?php
                                the_content();

                                wp_link_pages(
                                    array(
                                        'before' => '<div class="page-links mt-4"><span class="page-links-title">' . esc_html__('Pages:', 'festa-ceylon-wp') . '</span>',
                                        'after'  => '</div>',
                                    )
                                );
                                ?>
                            </div><!-- .entry-content -->

                            <?php if (get_edit_post_link()) : ?>
                                <footer class="entry-footer mt-4 pt-4 border-top">
                                    <?php
                                    edit_post_link(
                                        sprintf(
                                            wp_kses(
                                                __('Edit <span class="screen-reader-text">"%s"</span>', 'festa-ceylon-wp'),
                                                array(
                                                    'span' => array(
                                                        'class' => array(),
                                                    ),
                                                )
                                            ),
                                            wp_kses_post(get_the_title())
                                        ),
                                        '<span class="edit-link btn btn-outline-secondary btn-sm">',
                                        '</span>'
                                    );
                                    ?>
                                </footer><!-- .entry-footer -->
                            <?php endif; ?>
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