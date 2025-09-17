<?php
/**
 * Hero Section Component
 *
 * @package Festa_Ceylon_WP
 */

$hero_title = get_theme_mod('festa_ceylon_hero_title', 'Premium Fabrics & Textile Artistry');
$hero_description = get_theme_mod('festa_ceylon_hero_description', 'Discover our curated collection of luxury fabrics sold by the meter and exquisite ready-made textile products crafted with precision.');
$hero_button_text = get_theme_mod('festa_ceylon_hero_button_text', 'Shop Collection');
$hero_button_url = get_theme_mod('festa_ceylon_hero_button_url', '/shop');
?>

<section class="hero-section gradient-bg position-relative overflow-hidden">
    <div class="container py-5">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="hero-content fade-in">
                    <h1 class="hero-title display-3 fw-bold mb-4">
                        <?php 
                        $title_parts = explode('&', $hero_title);
                        if (count($title_parts) > 1) {
                            echo esc_html(trim($title_parts[0])) . ' &<br>';
                            echo '<span class="hero-highlight text-primary">' . esc_html(trim($title_parts[1])) . '</span>';
                        } else {
                            echo esc_html($hero_title);
                        }
                        ?>
                    </h1>
                    <p class="hero-description lead text-muted mb-4 pe-lg-5">
                        <?php echo esc_html($hero_description); ?>
                    </p>
                    <div class="hero-actions d-flex flex-column flex-sm-row gap-3">
                        <a href="<?php echo esc_url($hero_button_url); ?>" class="btn btn-primary btn-lg hover-lift">
                            <?php echo esc_html($hero_button_text); ?>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <?php if (class_exists('WooCommerce')) : ?>
                            <a href="<?php echo esc_url(home_url('/fabrics')); ?>" class="btn btn-outline-primary btn-lg hover-lift">
                                <?php esc_html_e('View Fabrics by Meter', 'festa-ceylon-wp'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 order-1 order-lg-2 mb-5 mb-lg-0">
                <div class="hero-image position-relative">
                    <div class="image-container position-relative">
                        <?php
                        $hero_image = get_theme_mod('festa_ceylon_hero_image');
                        if ($hero_image) {
                            echo '<img src="' . esc_url($hero_image) . '" alt="' . esc_attr($hero_title) . '" class="img-fluid rounded-3 shadow-lg hover-lift">';
                        } else {
                            // Default placeholder
                            echo '<div class="placeholder-image bg-card rounded-3 shadow-lg d-flex align-items-center justify-content-center" style="height: 500px;">';
                            echo '<div class="text-center text-muted">';
                            echo '<i class="bi bi-image display-1 mb-3"></i>';
                            echo '<p class="mb-0">' . esc_html__('Hero Image Placeholder', 'festa-ceylon-wp') . '</p>';
                            echo '<small>' . esc_html__('Add image in Customizer', 'festa-ceylon-wp') . '</small>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                        
                        <!-- Decorative Elements -->
                        <div class="position-absolute top-0 start-0 translate-middle">
                            <div class="bg-primary rounded-circle opacity-25" style="width: 100px; height: 100px; filter: blur(20px);"></div>
                        </div>
                        <div class="position-absolute bottom-0 end-0 translate-middle">
                            <div class="bg-secondary rounded-circle opacity-25" style="width: 80px; height: 80px; filter: blur(15px);"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Background Decorative Elements -->
    <div class="position-absolute top-0 end-0 opacity-10">
        <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="100" r="100" fill="currentColor"/>
        </svg>
    </div>
    <div class="position-absolute bottom-0 start-0 opacity-5">
        <svg width="150" height="150" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="75" cy="75" r="75" fill="currentColor"/>
        </svg>
    </div>
</section>

<style>
.min-vh-75 {
    min-height: 75vh;
}

.hero-section .fade-in {
    animation: fadeInUp 1s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.hero-section .hero-image img,
.hero-section .placeholder-image {
    transition: transform 0.3s ease;
}

.hero-section .hero-image:hover img,
.hero-section .hero-image:hover .placeholder-image {
    transform: translateY(-10px);
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem !important;
    }
    
    .hero-section {
        padding: 3rem 0 !important;
    }
    
    .min-vh-75 {
        min-height: auto;
    }
}
</style>