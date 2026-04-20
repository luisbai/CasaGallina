import $ from 'jquery';

class Navigation {
    constructor() {
        this.language = $('#language').val() || 'es';
        this.desktopOffset = 100;
        this.mobileOffset = 280;
        this.init();
    }

    init() {
        $(document).ready(() => {
            // Handle clicks on elements with data-scroll
            $(document).on('click', '[data-scroll]', (e) => this.handleScrollClick(e));

            // Handle hash on page load
            if (window.location.hash) {
                setTimeout(() => {
                    this.scrollToHash(window.location.hash);
                }, 500); // Small delay to ensure layout is ready
            }
        });
    }

    handleScrollClick(e) {
        const $link = $(e.currentTarget);
        const href = $link.attr('href');
        
        // Extract hash and base path
        const hashIndex = href.indexOf('#');
        if (hashIndex === -1) return; // Not a hash link

        const basePath = href.substring(0, hashIndex);
        const hash = href.substring(hashIndex);

        // Check if we are on the same page
        const currentPath = window.location.pathname;
        const normalizedBasePath = basePath === '/' ? '' : basePath.replace(/\/$/, '');
        const normalizedCurrentPath = currentPath === '/' ? '' : currentPath.replace(/\/$/, '');

        // Also handle the case where basePath is empty or matches current language prefix
        const isSamePage = normalizedBasePath === '' || 
                           normalizedBasePath === normalizedCurrentPath ||
                           (this.language === 'en' && normalizedBasePath === '/en' && normalizedCurrentPath === '/en');

        if (isSamePage && $(hash).length > 0) {
            e.preventDefault();
            
            // Close mobile menu if open
            if ($('.navbar-collapse').hasClass('show')) {
                $('.navbar-collapse').collapse('hide');
            }

            this.scrollToHash(hash, true);
        } else {
            // Let default behavior happen (redirect to the other page with hash)
            // The init() handler will pick up the hash on the new page
        }
    }

    scrollToHash(hash, updateHash = false) {
        const $target = $(hash);
        if (!$target.length) return;

        const offset = $(window).width() < 768 ? this.mobileOffset : this.desktopOffset;
        const targetScrollTop = $target.offset().top - offset;

        $('html, body').stop().animate({
            scrollTop: targetScrollTop
        }, 800, 'swing', () => {
            if (updateHash) {
                // Update URL without jumping
                if (history.pushState) {
                    history.pushState(null, null, hash);
                } else {
                    window.location.hash = hash;
                }
            }
        });
    }
}

export default new Navigation();
