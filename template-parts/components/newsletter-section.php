<?php
/**
 * Newsletter Section Component
 *
 * @package Festa_Ceylon_WP
 */
?>

<section class="newsletter-section py-5 bg-primary text-white position-relative overflow-hidden">
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="newsletter-content">
                    <h2 class="display-6 fw-bold mb-3">
                        <?php esc_html_e('Stay Updated with Our Latest Collections', 'festa-ceylon-wp'); ?>
                    </h2>
                    <p class="lead mb-4 opacity-90">
                        <?php esc_html_e('Subscribe to our newsletter and be the first to know about new arrivals, exclusive offers, and textile trends.', 'festa-ceylon-wp'); ?>
                    </p>
                    
                    <form class="newsletter-form row g-3 justify-content-center" id="newsletter-form" method="post" action="">
                        <?php wp_nonce_field('festa_ceylon_newsletter', 'newsletter_nonce'); ?>
                        <div class="col-md-6">
                            <div class="input-group input-group-lg">
                                <input type="email" 
                                       class="form-control" 
                                       name="newsletter_email"
                                       placeholder="<?php esc_attr_e('Enter your email address', 'festa-ceylon-wp'); ?>" 
                                       required>
                                <button class="btn btn-light text-primary fw-semibold" type="submit">
                                    <?php esc_html_e('Subscribe', 'festa-ceylon-wp'); ?>
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-12">
                            <small class="opacity-75">
                                <?php esc_html_e('By subscribing, you agree to our Privacy Policy and consent to receive updates from our company.', 'festa-ceylon-wp'); ?>
                            </small>
                        </div>
                    </form>
                    
                    <!-- Newsletter Success/Error Messages -->
                    <div id="newsletter-message" class="mt-3" style="display: none;"></div>
                    
                    <!-- Social Proof -->
                    <div class="social-proof mt-5">
                        <div class="row g-4 text-center">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="h2 fw-bold mb-1">5000+</h3>
                                    <p class="mb-0 opacity-75"><?php esc_html_e('Happy Subscribers', 'festa-ceylon-wp'); ?></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="h2 fw-bold mb-1">50+</h3>
                                    <p class="mb-0 opacity-75"><?php esc_html_e('Premium Fabrics', 'festa-ceylon-wp'); ?></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="h2 fw-bold mb-1">10+</h3>
                                    <p class="mb-0 opacity-75"><?php esc_html_e('Years Experience', 'festa-ceylon-wp'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Background Decorative Elements -->
    <div class="position-absolute top-0 start-0 opacity-10">
        <svg width="300" height="300" viewBox="0 0 300 300" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="150" cy="150" r="150" fill="currentColor"/>
        </svg>
    </div>
    <div class="position-absolute bottom-0 end-0 opacity-10">
        <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="100" r="100" fill="currentColor"/>
        </svg>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.getElementById('newsletter-form');
    const messageDiv = document.getElementById('newsletter-message');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'festa_ceylon_newsletter_signup');
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i><?php esc_html_e("Subscribing...", "festa-ceylon-wp"); ?>';
            submitBtn.disabled = true;
            
            fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                messageDiv.style.display = 'block';
                
                if (data.success) {
                    messageDiv.innerHTML = '<div class="alert alert-success">' + data.data.message + '</div>';
                    newsletterForm.reset();
                } else {
                    messageDiv.innerHTML = '<div class="alert alert-danger">' + data.data.message + '</div>';
                }
            })
            .catch(error => {
                messageDiv.style.display = 'block';
                messageDiv.innerHTML = '<div class="alert alert-danger"><?php esc_html_e("An error occurred. Please try again.", "festa-ceylon-wp"); ?></div>';
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});
</script>

<style>
.newsletter-section {
    background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-secondary) 100%);
}

.newsletter-form .form-control {
    border: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.newsletter-form .form-control:focus {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    border-color: transparent;
}

.newsletter-form .btn {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.newsletter-form .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.stat-item {
    transition: transform 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-5px);
}

@media (max-width: 768px) {
    .newsletter-section .display-6 {
        font-size: 2rem;
    }
    
    .newsletter-form .input-group {
        flex-direction: column;
    }
    
    .newsletter-form .btn {
        border-radius: 0.5rem !important;
        margin-top: 0.5rem;
    }
}
</style>