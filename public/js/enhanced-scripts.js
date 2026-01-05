/**
 * Celebrate FEST NOW - JavaScript 增强功能
 * 包含：返回顶部、图片懒加载、导航栏滚动效果等
 */

(function($) {
    'use strict';
    
    // DOM Ready
    $(document).ready(function() {
        
        // ============================================
        // 返回顶部按钮
        // ============================================
        initBackToTop();
        
        // ============================================
        // 导航栏滚动效果
        // ============================================
        initNavbarScroll();
        
        // ============================================
        // 图片懒加载
        // ============================================
        initLazyLoad();
        
        // ============================================
        // 平滑滚动
        // ============================================
        initSmoothScroll();
        
        // ============================================
        // 卡片动画观察器
        // ============================================
        initAnimationObserver();
        
        // ============================================
        // 表单验证（如需要）
        // ============================================
        // initFormValidation();
        
        // ============================================
        // 社交分享（如需要）
        // ============================================
        // initSocialShare();
    });
    
    /**
     * 返回顶部按钮
     */
    function initBackToTop() {
        // 创建返回顶部按钮
        if ($('.back-to-top').length === 0) {
            $('body').append('<button class="back-to-top" aria-label="Back to top"><i class="fas fa-arrow-up"></i></button>');
        }
        
        var $backToTop = $('.back-to-top');
        
        // 监听滚动
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $backToTop.addClass('show');
            } else {
                $backToTop.removeClass('show');
            }
        });
        
        // 点击返回顶部
        $backToTop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 600);
        });
    }
    
    /**
     * 导航栏滚动效果
     */
    function initNavbarScroll() {
        var $navbar = $('.navbar');
        var lastScrollTop = 0;
        
        $(window).scroll(function() {
            var scrollTop = $(this).scrollTop();
            
            // 添加阴影效果
            if (scrollTop > 50) {
                $navbar.addClass('navbar-scrolled');
            } else {
                $navbar.removeClass('navbar-scrolled');
            }
            
            // 可选：向下滚动时隐藏导航栏
            /*
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                $navbar.css('top', '-100px');
            } else {
                $navbar.css('top', '0');
            }
            */
            
            lastScrollTop = scrollTop;
        });
    }
    
    /**
     * 图片懒加载
     */
    function initLazyLoad() {
        // 使用Intersection Observer API
        if ('IntersectionObserver' in window) {
            var imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var image = entry.target;
                        var src = image.getAttribute('data-src');
                        
                        if (src) {
                            image.src = src;
                            image.classList.remove('lazy');
                            image.classList.add('loaded');
                            imageObserver.unobserve(image);
                        }
                    }
                });
            }, {
                rootMargin: '50px 0px',
                threshold: 0.01
            });
            
            // 观察所有带 data-src 的图片
            document.querySelectorAll('img[data-src]').forEach(function(img) {
                img.classList.add('lazy');
                imageObserver.observe(img);
            });
        } else {
            // 降级处理：直接加载所有图片
            $('img[data-src]').each(function() {
                $(this).attr('src', $(this).attr('data-src'));
            });
        }
    }
    
    /**
     * 平滑滚动
     */
    function initSmoothScroll() {
        // 为锚点链接添加平滑滚动
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 80
                }, 600);
            }
        });
    }
    
    /**
     * 卡片动画观察器
     */
    function initAnimationObserver() {
        if ('IntersectionObserver' in window) {
            var animationObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                        animationObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });
            
            // 观察所有卡片
            document.querySelectorAll('.blog-card').forEach(function(card) {
                animationObserver.observe(card);
            });
        }
    }
    
    /**
     * 表单验证（示例）
     */
    function initFormValidation() {
        $('form').on('submit', function(e) {
            var $form = $(this);
            var isValid = true;
            
            // 清除之前的错误
            $form.find('.error').removeClass('error');
            $form.find('.error-message').remove();
            
            // 验证必填字段
            $form.find('[required]').each(function() {
                var $field = $(this);
                var value = $field.val().trim();
                
                if (value === '') {
                    isValid = false;
                    $field.addClass('error');
                    $field.after('<span class="error-message">This field is required</span>');
                }
            });
            
            // 验证邮箱
            $form.find('input[type="email"]').each(function() {
                var $field = $(this);
                var value = $field.val().trim();
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (value !== '' && !emailRegex.test(value)) {
                    isValid = false;
                    $field.addClass('error');
                    $field.after('<span class="error-message">Please enter a valid email</span>');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                // 滚动到第一个错误
                var firstError = $form.find('.error').first();
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    }
    
    /**
     * 社交分享（示例）
     */
    function initSocialShare() {
        $('.social-share-btn').on('click', function(e) {
            e.preventDefault();
            
            var $btn = $(this);
            var network = $btn.data('network');
            var url = encodeURIComponent(window.location.href);
            var title = encodeURIComponent(document.title);
            
            var shareUrl = '';
            
            switch(network) {
                case 'facebook':
                    shareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
                    break;
                case 'twitter':
                    shareUrl = 'https://twitter.com/intent/tweet?url=' + url + '&text=' + title;
                    break;
                case 'linkedin':
                    shareUrl = 'https://www.linkedin.com/shareArticle?mini=true&url=' + url + '&title=' + title;
                    break;
                case 'pinterest':
                    var image = encodeURIComponent($('meta[property="og:image"]').attr('content') || '');
                    shareUrl = 'https://pinterest.com/pin/create/button/?url=' + url + '&media=' + image + '&description=' + title;
                    break;
            }
            
            if (shareUrl) {
                window.open(shareUrl, 'share', 'width=600,height=400');
            }
        });
    }
    
    /**
     * 移动端菜单增强
     */
    function initMobileMenu() {
        var $navbarToggler = $('.navbar-toggler');
        var $navbarCollapse = $('.navbar-collapse');
        
        // 点击菜单外部关闭菜单
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.navbar').length) {
                $navbarCollapse.removeClass('show');
            }
        });
        
        // 点击菜单项关闭菜单
        $('.navbar-nav .nav-link').on('click', function() {
            $navbarCollapse.removeClass('show');
        });
    }
    
    /**
     * 图片错误处理
     */
    function initImageErrorHandling() {
        $('img').on('error', function() {
            var $img = $(this);
            
            // 如果图片加载失败，显示占位符
            if (!$img.hasClass('error-handled')) {
                $img.addClass('error-handled');
                
                // 可以设置一个默认图片
                // $img.attr('src', '/images/placeholder.jpg');
                
                // 或者隐藏图片
                $img.css('opacity', '0.3');
            }
        });
    }
    
    /**
     * 复制链接功能
     */
    function initCopyLink() {
        $('.copy-link').on('click', function(e) {
            e.preventDefault();
            
            var url = window.location.href;
            
            // 创建临时输入框
            var $temp = $('<input>');
            $('body').append($temp);
            $temp.val(url).select();
            document.execCommand('copy');
            $temp.remove();
            
            // 显示提示
            showToast('Link copied to clipboard!');
        });
    }
    
    /**
     * Toast 提示
     */
    function showToast(message, duration) {
        duration = duration || 3000;
        
        var $toast = $('<div class="toast-message">' + message + '</div>');
        $toast.css({
            position: 'fixed',
            bottom: '20px',
            right: '20px',
            backgroundColor: 'var(--primary-purple)',
            color: 'white',
            padding: '1rem 1.5rem',
            borderRadius: '8px',
            boxShadow: '0 4px 12px rgba(0,0,0,0.2)',
            zIndex: 9999,
            animation: 'slideInRight 0.3s ease-out'
        });
        
        $('body').append($toast);
        
        setTimeout(function() {
            $toast.fadeOut(300, function() {
                $(this).remove();
            });
        }, duration);
    }
    
    /**
     * 加载进度条
     */
    function showLoadingBar() {
        if ($('.loading-bar').length === 0) {
            $('body').prepend('<div class="loading-bar"></div>');
        }
    }
    
    function hideLoadingBar() {
        $('.loading-bar').remove();
    }
    
    // 暴露全局方法
    window.celebrateFest = {
        showToast: showToast,
        showLoadingBar: showLoadingBar,
        hideLoadingBar: hideLoadingBar
    };
    
    // 页面加载完成
    $(window).on('load', function() {
        // 移除加载动画类
        $('body').addClass('loaded');
    });
    
})(jQuery);

/**
 * 使用示例：
 * 
 * 1. 显示Toast提示：
 *    celebrateFest.showToast('Success!', 3000);
 * 
 * 2. 显示加载进度条：
 *    celebrateFest.showLoadingBar();
 *    celebrateFest.hideLoadingBar();
 * 
 * 3. 图片懒加载：
 *    <img data-src="image.jpg" alt="Image">
 * 
 * 4. 社交分享按钮：
 *    <a href="#" class="social-share-btn facebook" data-network="facebook">
 *        <i class="fab fa-facebook-f"></i>
 *    </a>
 */
