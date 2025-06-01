// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Fixed navbar functionality - with null check
    const header = document.querySelector('header');
    
    function fixedNavbar() {
        if (header) {
            header.classList.toggle('scroll', window.pageYOffset > 0);
        }
    }
    
    if (header) {
        fixedNavbar();
        window.addEventListener('scroll', fixedNavbar);
    }

    // Menu button functionality - with null check
    const menu = document.querySelector('#menu-btn');
    const userBtn = document.querySelector('#user-btn');

    if (menu) {
        menu.addEventListener('click', function() {
            const nav = document.querySelector('.navbar');
            if (nav) {
                nav.classList.toggle('active');
            }
        });
    }

    if (userBtn) {
        userBtn.addEventListener('click', function() {
            const userBox = document.querySelector('.user-box');
            if (userBox) {
                userBox.classList.toggle('active');
            }
        });
    }

    /*-- Home page slider --*/
    const leftArrow = document.querySelector('.left-arrow .bxs-left-arrow');
    const rightArrow = document.querySelector('.right-arrow .bxs-right-arrow');
    const slider = document.querySelector('.slider');

    // Only initialize slider if elements exist
    if (slider && leftArrow && rightArrow) {
        let timerId;

        function scrollRight() {
            if (slider.scrollWidth - slider.clientWidth === slider.scrollLeft) {
                slider.scrollTo({
                    left: 0,
                    behavior: "smooth"
                });
            } else {
                slider.scrollBy({
                    left: window.innerWidth,
                    behavior: "smooth"
                });
            }
        }

        function scrollLeft() {
            slider.scrollBy({
                left: -window.innerWidth,
                behavior: "smooth"
            });
        }

        function resetTimer() {
            if (timerId) {
                clearInterval(timerId);
            }
            timerId = setInterval(scrollRight, 7000);
        }

        // Initialize timer
        resetTimer();

        // Event listeners for arrows
        leftArrow.addEventListener('click', function() {
            scrollLeft();
            resetTimer();
        });

        rightArrow.addEventListener('click', function() {
            scrollRight();
            resetTimer();
        });
    }

    /*-- Testimonial slider --*/
    const testimonialSlides = document.querySelectorAll('.testimonial-item');
    
    // Only initialize if testimonial slides exist
    if (testimonialSlides.length > 0) {
        let currentIndex = 0;

        // Initialize - make sure only first slide is active
        testimonialSlides.forEach((slide, index) => {
            if (index === 0) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });

        // Global functions for testimonial navigation
        window.nextSlide = function() {
            testimonialSlides[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % testimonialSlides.length;
            testimonialSlides[currentIndex].classList.add('active');
        };

        window.prevSlide = function() {
            testimonialSlides[currentIndex].classList.remove('active');
            currentIndex = (currentIndex - 1 + testimonialSlides.length) % testimonialSlides.length;
            testimonialSlides[currentIndex].classList.add('active');
        };

        // Optional: Auto-advance testimonials every 6 seconds
        setInterval(function() {
            if (typeof window.nextSlide === 'function') {
                window.nextSlide();
            }
        }, 6000);
    }

    /*-- Product slider (if exists) --*/
    const productSlider = document.querySelector('.products .slider');
    const productLeftArrow = document.querySelector('.products .left-arrow');
    const productRightArrow = document.querySelector('.products .right-arrow');

    if (productSlider && productLeftArrow && productRightArrow) {
        productLeftArrow.addEventListener('click', function() {
            productSlider.scrollBy({
                left: -300,
                behavior: 'smooth'
            });
        });

        productRightArrow.addEventListener('click', function() {
            productSlider.scrollBy({
                left: 300,
                behavior: 'smooth'
            });
        });
    }
});

// Utility function to safely add event listeners
function safeAddEventListener(selector, event, callback) {
    const element = document.querySelector(selector);
    if (element) {
        element.addEventListener(event, callback);
    }
}