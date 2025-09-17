/**
 * Festa Ceylon WP - Main JavaScript
 * 
 * @package Festa_Ceylon_WP
 */

(function($) {
    'use strict';

    // DOM Ready
    $(document).ready(function() {
        initializeTheme();
    });

    // Window Load
    $(window).on('load', function() {
        handlePageLoad();
    });

    /**
     * Initialize theme functionality
     */
    function initializeTheme() {
        initBackToTop();
        initSmoothScrolling();
        initProductCards();
        initWishlist();
        initAjaxAddToCart();
        initSearchFunctionality();
        initNewsletterForm();
        initImageLazyLoading();
        initAnimations();
        initAccessibility();
    }

    /**
     * Handle page load events
     */
    function handlePageLoad() {
        // Hide loading states
        $('.loading').removeClass('loading');
        
        // Initialize tooltips
        if (typeof bootstrap !== 'undefined') {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    /**
     * Back to top button functionality
     */
    function initBackToTop() {
        var backToTopBtn = $('#btn-back-to-top');
        
        if (backToTopBtn.length) {
            $(window).scroll(function() {
                if ($(window).scrollTop() > 300) {
                    backToTopBtn.fadeIn();
                } else {
                    backToTopBtn.fadeOut();
                }
            });

            backToTopBtn.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, 600);
            });
        }
    }

    /**
     * Smooth scrolling for anchor links
     */
    function initSmoothScrolling() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 600);
                }
            }
        });
    }

    /**
     * Product card interactions
     */
    function initProductCards() {
        // Product card hover effects
        $('.product-card').on('mouseenter', function() {
            $(this).addClass('hover-active');
        }).on('mouseleave', function() {
            $(this).removeClass('hover-active');
        });

        // Product image error handling
        $('.product-card img').on('error', function() {
            $(this).attr('src', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtc2l6ZT0iMTgiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIiBmaWxsPSIjOTk5Ij5JbWFnZSBub3QgZm91bmQ8L3RleHQ+PC9zdmc+');
        });
    }

    /**
     * Wishlist functionality
     */
    function initWishlist() {
        $(document).on('click', '.wishlist-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $btn = $(this);
            var productId = $btn.data('product-id');
            var isActive = $btn.hasClass('active');
            
            // Toggle visual state immediately
            $btn.toggleClass('active');
            
            // AJAX request to handle wishlist
            $.ajax({
                url: festa_ceylon_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'festa_ceylon_toggle_wishlist',
                    product_id: productId,
                    nonce: festa_ceylon_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showNotification(response.data.message, 'success');
                        updateWishlistCount(response.data.count);
                    } else {
                        // Revert visual state on error
                        $btn.toggleClass('active');
                        showNotification(response.data.message, 'error');
                    }
                },
                error: function() {
                    // Revert visual state on error
                    $btn.toggleClass('active');
                    showNotification('An error occurred. Please try again.', 'error');
                }
            });
        });
    }

    /**
     * AJAX Add to Cart functionality
     */
    function initAjaxAddToCart() {
        $(document).on('click', '.add-to-cart-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $btn = $(this);
            var productId = $btn.data('product-id');
            var quantity = $btn.closest('.product-card').find('.quantity input').val() || 1;
            var originalText = $btn.html();
            
            // Show loading state
            $btn.html('<i class="bi bi-hourglass-split me-2"></i>Adding...');
            $btn.prop('disabled', true);
            
            $.ajax({
                url: festa_ceylon_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'festa_ceylon_add_to_cart',
                    product_id: productId,
                    quantity: quantity,
                    nonce: festa_ceylon_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showNotification(response.data.message, 'success');
                        updateCartCount(response.data.cart_count);
                        
                        // Update button text temporarily
                        $btn.html('<i class="bi bi-check me-2"></i>Added!');
                        setTimeout(function() {
                            $btn.html(originalText);
                            $btn.prop('disabled', false);
                        }, 2000);
                    } else {
                        showNotification(response.data.message, 'error');
                        $btn.html(originalText);
                        $btn.prop('disabled', false);
                    }
                },
                error: function() {
                    showNotification('An error occurred. Please try again.', 'error');
                    $btn.html(originalText);
                    $btn.prop('disabled', false);
                }
            });
        });
    }

    /**
     * Search functionality
     */
    function initSearchFunctionality() {
        var searchTimeout;
        
        $('.product-search input').on('input', function() {
            var query = $(this).val();
            
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                if (query.length >= 3) {
                    performProductSearch(query);
                }
            }, 300);
        });
    }

    /**
     * Perform product search
     */
    function performProductSearch(query) {
        $.ajax({
            url: festa_ceylon_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'festa_ceylon_product_search',
                query: query,
                nonce: festa_ceylon_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    displaySearchResults(response.data.products);
                }
            }
        });
    }

    /**
     * Newsletter form handling
     */
    function initNewsletterForm() {
        $('#newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var $btn = $form.find('button[type="submit"]');
            var $message = $('#newsletter-message');
            var originalText = $btn.html();
            
            // Show loading state
            $btn.html('<i class="bi bi-hourglass-split me-2"></i>Subscribing...');
            $btn.prop('disabled', true);
            
            $.ajax({
                url: festa_ceylon_ajax.ajax_url,
                type: 'POST',
                data: $form.serialize() + '&action=festa_ceylon_newsletter_signup',
                success: function(response) {
                    $message.show();
                    
                    if (response.success) {
                        $message.html('<div class="alert alert-success">' + response.data.message + '</div>');
                        $form[0].reset();
                    } else {
                        $message.html('<div class="alert alert-danger">' + response.data.message + '</div>');
                    }
                },
                error: function() {
                    $message.show();
                    $message.html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                },
                complete: function() {
                    $btn.html(originalText);
                    $btn.prop('disabled', false);
                }
            });
        });
    }

    /**
     * Image lazy loading
     */
    function initImageLazyLoading() {
        if ('IntersectionObserver' in window) {
            var imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Initialize animations
     */
    function initAnimations() {
        // Fade in elements on scroll
        if ('IntersectionObserver' in window) {
            var animationObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in-up');
                        animationObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.animate-on-scroll').forEach(function(el) {
                animationObserver.observe(el);
            });
        }
    }

    /**
     * Accessibility enhancements
     */
    function initAccessibility() {
        // Skip link functionality
        $('.skip-link').on('click', function(e) {
            var target = $($(this).attr('href'));
            if (target.length) {
                target.focus();
            }
        });

        // Keyboard navigation for product cards
        $('.product-card').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).find('a').first()[0].click();
            }
        });

        // ARIA labels for dynamic content
        updateAriaLabels();
    }

    /**
     * Update ARIA labels
     */
    function updateAriaLabels() {
        $('.cart-count').each(function() {
            var count = $(this).text();
            $(this).attr('aria-label', count + ' items in cart');
        });

        $('.wishlist-count').each(function() {
            var count = $(this).text();
            $(this).attr('aria-label', count + ' items in wishlist');
        });
    }

    /**
     * Update cart count
     */
    function updateCartCount(count) {
        $('.cart-count').text(count).attr('aria-label', count + ' items in cart');
        
        if (count > 0) {
            $('.cart-count').show().addClass('pulse');
            setTimeout(function() {
                $('.cart-count').removeClass('pulse');
            }, 1000);
        } else {
            $('.cart-count').hide();
        }
    }

    /**
     * Update wishlist count
     */
    function updateWishlistCount(count) {
        $('.wishlist-count').text(count).attr('aria-label', count + ' items in wishlist');
        
        if (count > 0) {
            $('.wishlist-count').show().addClass('pulse');
            setTimeout(function() {
                $('.wishlist-count').removeClass('pulse');
            }, 1000);
        } else {
            $('.wishlist-count').hide();
        }
    }

    /**
     * Show notification
     */
    function showNotification(message, type) {
        var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        var icon = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle';
        
        var notification = $('<div class="alert ' + alertClass + ' alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
            '<i class="bi ' + icon + ' me-2"></i>' + message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
            '</div>');
        
        $('body').append(notification);
        
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            notification.alert('close');
        }, 5000);
    }

    /**
     * Handle form validation
     */
    function validateForm($form) {
        var isValid = true;
        
        $form.find('[required]').each(function() {
            var $field = $(this);
            var value = $field.val().trim();
            
            if (!value) {
                $field.addClass('is-invalid');
                isValid = false;
            } else {
                $field.removeClass('is-invalid').addClass('is-valid');
            }
        });
        
        return isValid;
    }

    /**
     * Debounce function
     */
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    /**
     * Throttle function
     */
    function throttle(func, limit) {
        var inThrottle;
        return function() {
            var args = arguments;
            var context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(function() {
                    inThrottle = false;
                }, limit);
            }
        };
    }

    // Expose functions globally if needed
    window.festaTheme = {
        showNotification: showNotification,
        updateCartCount: updateCartCount,
        updateWishlistCount: updateWishlistCount,
        validateForm: validateForm
    };

})(jQuery);