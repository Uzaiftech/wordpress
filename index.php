<?php
/**
 * The main template file
 *
 * @package Festa_Ceylon_WP
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <?php if (have_posts()) : ?>
                    
                    <header class="page-header mb-5">
                        <?php if (is_home() && !is_front_page()) : ?>
                            <h1 class="page-title display-5 fw-bold"><?php single_post_title(); ?></h1>
                        <?php elseif (is_search()) : ?>
                            <h1 class="page-title display-5 fw-bold">
                                <?php
                                printf(
                                    esc_html__('Search Results for: %s', 'festa-ceylon-wp'),
                                    '<span class="text-primary">' . get_search_query() . '</span>'
                                );
                                ?>
                            </h1>
                        <?php elseif (is_archive()) : ?>
                            <h1 class="page-title display-5 fw-bold"><?php the_archive_title(); ?></h1>
                            <?php if (get_the_archive_description()) : ?>
                                <div class="archive-description lead text-muted mt-3">
                                    <?php echo wp_kses_post(get_the_archive_description()); ?>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <h1 class="page-title display-5 fw-bold"><?php esc_html_e('Latest Posts', 'festa-ceylon-wp'); ?></h1>
                        <?php endif; ?>
                    </header><!-- .page-header -->

                    <div class="posts-container">
                        <?php
                        while (have_posts()) :
                            the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('card mb-4 hover-lift'); ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="card-img-top-wrapper position-relative overflow-hidden" style="height: 250px;">
                                        <?php the_post_thumbnail('large', array('class' => 'card-img-top w-100 h-100 object-fit-cover')); ?>
                                        <div class="post-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-25 d-flex align-items-end p-3">
                                            <div class="post-meta text-white">
                                                <small>
                                                    <i class="bi bi-calendar me-1"></i>
                                                    <?php echo get_the_date(); ?>
                                                    <span class="mx-2">•</span>
                                                    <i class="bi bi-person me-1"></i>
                                                    <?php the_author(); ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <header class="entry-header mb-3">
                                        <?php
                                        if (is_singular()) :
                                            the_title('<h1 class="entry-title card-title h3 fw-bold">', '</h1>');
                                        else :
                                            the_title('<h2 class="entry-title card-title h4 fw-bold"><a href="' . esc_url(get_permalink()) . '" class="text-decoration-none">', '</a></h2>');
                                        endif;
                                        ?>
                                        
                                        <?php if (!has_post_thumbnail()) : ?>
                                            <div class="entry-meta text-muted small mb-2">
                                                <i class="bi bi-calendar me-1"></i>
                                                <?php echo get_the_date(); ?>
                                                <span class="mx-2">•</span>
                                                <i class="bi bi-person me-1"></i>
                                                <?php the_author(); ?>
                                                <?php if (get_the_category_list()) : ?>
                                                    <span class="mx-2">•</span>
                                                    <i class="bi bi-folder me-1"></i>
                                                    <?php the_category(', '); ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </header><!-- .entry-header -->

                                    <div class="entry-content">
                                        <?php
                                        if (is_singular()) :
                                            the_content();
                                        else :
                                            the_excerpt();
                                        endif;
                                        ?>
                                    </div><!-- .entry-content -->

                                    <?php if (!is_singular()) : ?>
                                        <div class="entry-footer mt-3">
                                            <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-outline-primary btn-sm">
                                                <?php esc_html_e('Read More', 'festa-ceylon-wp'); ?>
                                                <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </article><!-- #post-<?php the_ID(); ?> -->
                            <?php
                        endwhile;
                        ?>
                    </div>

                    <?php festa_ceylon_pagination(); ?>

                <?php else : ?>

                    <div class="no-results text-center py-5">
                        <div class="card">
                            <div class="card-body p-5">
                                <h2 class="card-title h3 mb-3"><?php esc_html_e('Nothing here', 'festa-ceylon-wp'); ?></h2>
                                <?php if (is_search()) : ?>
                                    <p class="card-text text-muted mb-4">
                                        <?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'festa-ceylon-wp'); ?>
                                    </p>
                                    <?php get_search_form(); ?>
                                <?php else : ?>
                                    <p class="card-text text-muted mb-4">
                                        <?php esc_html_e('It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'festa-ceylon-wp'); ?>
                                    </p>
                                    <?php get_search_form(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>
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