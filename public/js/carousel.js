// Prevent multiple initialization
if (window.larinsCarouselInitialized) {
    console.warn('LarinsCarousel already initialized, skipping...');
} else {
    window.larinsCarouselInitialized = true;

    class LarinsCarousel {
        constructor() {
            this.currentSlide = 0;
            this.slides = document.querySelectorAll('.carousel-slide');
            this.dots = document.querySelectorAll('.nav-dot');
            this.playPauseBtn = document.getElementById('playPauseBtn');
            this.playPauseIcon = document.getElementById('playPauseIcon');
            this.prevBtn = document.querySelector('.nav-arrow.prev');
            this.nextBtn = document.querySelector('.nav-arrow.next');
            this.carouselStatus = document.getElementById('carouselStatus');
            this.carouselContainer = document.querySelector('.carousel-container');

            this.isPlaying = true;
            this.autoPlayInterval = null;
            this.autoPlayDelay = 5800; // 5.8 seconds
            this.touchStartX = 0;
            this.touchEndX = 0;

            this.slideLabels = [
                'Luxurious Hair Rituals',
                'Glow From Within',
                'Signature Scents',
                'Elevate Every Moment',
                'Discover Your Luxury'
            ];

            this.init();
        }

        init() {
            this.setupEventListeners();
            this.startAutoPlay();
            this.updateAria();
        }

        setupEventListeners() {
            // Dot navigation
            this.dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    this.goToSlide(index);
                    this.resetAutoPlay();
                });
            });

            // Arrow navigation
            this.prevBtn?.addEventListener('click', () => {
                this.prevSlide();
                this.resetAutoPlay();
            });

            this.nextBtn?.addEventListener('click', () => {
                this.nextSlide();
                this.resetAutoPlay();
            });

            // Play/pause
            this.playPauseBtn?.addEventListener('click', () => {
                this.togglePlayPause();
            });

            // Touch events for mobile
            this.carouselContainer?.addEventListener('touchstart', (e) => {
                this.touchStartX = e.changedTouches[0].screenX;
            });

            this.carouselContainer?.addEventListener('touchend', (e) => {
                this.touchEndX = e.changedTouches[0].screenX;
                this.handleSwipe();
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    this.prevSlide();
                    this.resetAutoPlay();
                } else if (e.key === 'ArrowRight') {
                    this.nextSlide();
                    this.resetAutoPlay();
                } else if (e.key === ' ') {
                    e.preventDefault();
                    this.togglePlayPause();
                }
            });
        }

        goToSlide(index) {
            if (index < 0 || index >= this.slides.length) return;

            // Update slides
            this.slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });

            // Update dots
            this.dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });

            this.currentSlide = index;
            this.updateAria();
            this.updateStatus();
        }

        nextSlide() {
            const nextIndex = (this.currentSlide + 1) % this.slides.length;
            this.goToSlide(nextIndex);
        }

        prevSlide() {
            const prevIndex = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
            this.goToSlide(prevIndex);
        }

        startAutoPlay() {
            if (this.autoPlayInterval) return;

            this.autoPlayInterval = setInterval(() => {
                if (this.isPlaying) {
                    this.nextSlide();
                }
            }, this.autoPlayDelay);
        }

        stopAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
        }

        resetAutoPlay() {
            this.stopAutoPlay();
            this.startAutoPlay();
        }

        togglePlayPause() {
            this.isPlaying = !this.isPlaying;

            if (this.playPauseIcon) {
                this.playPauseIcon.setAttribute('data-lucide', this.isPlaying ? 'pause' : 'play');
                if (window.lucide) lucide.createIcons();
            }

            if (this.playPauseBtn) {
                this.playPauseBtn.setAttribute('aria-label', this.isPlaying ? 'Pause carousel' : 'Play carousel');
            }
        }

        handleSwipe() {
            const swipeThreshold = 50;
            const diff = this.touchStartX - this.touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    this.nextSlide();
                } else {
                    this.prevSlide();
                }
                this.resetAutoPlay();
            }
        }

        updateAria() {
            this.slides.forEach((slide, index) => {
                const isActive = index === this.currentSlide;
                slide.setAttribute('aria-hidden', !isActive);
                slide.setAttribute('aria-current', isActive ? 'true' : 'false');
            });

            this.dots.forEach((dot, index) => {
                dot.setAttribute('aria-current', index === this.currentSlide ? 'true' : 'false');
            });
        }

        updateStatus() {
            if (this.carouselStatus) {
                const current = this.currentSlide + 1;
                const total = this.slides.length;
                const label = this.slideLabels[this.currentSlide] || `Slide ${current}`;
                this.carouselStatus.textContent = `${label} (${current} of ${total})`;
            }
        }
    }

    // Initialize carousel when DOM is ready
    document.addEventListener('DOMContentLoaded', () => {
        // Only initialize if carousel elements exist
        if (document.querySelector('.carousel-container')) {
            new LarinsCarousel();
        }
    });
}
