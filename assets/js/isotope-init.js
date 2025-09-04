// JavaScript source code
// assets/js/isotope-init.js
document.addEventListener('DOMContentLoaded', function () {
    // Wait for images to load (optional but recommended)
    const tourGrid = document.querySelector('.swiper-wrapper');

    // Initialize Isotope AFTER images are loaded to prevent layout issues
    imagesLoaded(tourGrid, function () {
        initIsotope();
    });

    // Alternatively, if you didn't use imagesLoaded, just run initIsotope on DOMContentLoaded
    // initIsotope();

    function initIsotope() {
        // Initialize Isotope
        const iso = new Isotope('.swiper-wrapper', {
            itemSelector: '.swiper-slide',
            layoutMode: 'fitRows', // This works well with grid layouts. Use 'masonry' if you have items of different heights.
            percentPosition: true,
            fitRows: {
                gutter: 30 // Matches the 'spaceBetween' in your Swiper config
            }
        });

        // Bind filter button click events
        const filterSelect = document.getElementById('tour-filter');

        filterSelect.addEventListener('change', function () {
            // Get the filter value from the select element's value
            const filterValue = this.value;
            // Use the value to filter
            iso.arrange({ filter: filterValue });

            // IMPORTANT: You must destroy and re-initialize Swiper after filtering
            // because Swiper won't know about the hidden/shown slides.
            if (typeof featuredToursSwiper !== 'undefined') {
                featuredToursSwiper.destroy(true, true); // Destroy completely
                initSwiper(); // Re-initialize Swiper with the new visible slides
            }
        });
    }

    // Initialize Swiper (assuming your existing script does this)
    // We'll put it in a function so we can call it again after filtering
    let featuredToursSwiper;
    function initSwiper() {
        // Get the config from the JSON script tag
        const swiperConfigScript = document.querySelector('.featured-tours-slider .swiper-config');
        let swiperConfig = {};

        if (swiperConfigScript) {
            try {
                swiperConfig = JSON.parse(swiperConfigScript.textContent);
            } catch (e) {
                console.error('Error parsing Swiper config:', e);
                // Fallback config
                swiperConfig = {
                    loop: true,
                    speed: 600,
                    autoplay: { delay: 5000 },
                    slidesPerView: 1,
                    spaceBetween: 30,
                    pagination: { el: '.swiper-pagination', type: 'bullets', clickable: true },
                    breakpoints: { 768: { slidesPerView: 2 }, 1200: { slidesPerView: 3 } }
                };
            }
        }

        // Initialize Swiper
        featuredToursSwiper = new Swiper('.featured-tours-slider', swiperConfig);
    }

    // Initialize Swiper for the first time
    initSwiper();
});