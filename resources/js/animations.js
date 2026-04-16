/**
 * Animations — Scroll triggers, cursor glow, section reveals
 */

export function initAnimations() {
    initScrollAnimations();
    initCursorGlow();
    initNavScrollEffect();
    initMobileMenu();
    initParallax();
}

// Intersection Observer for section animations
function initScrollAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-visible');
                // Stagger children if they exist
                const children = entry.target.querySelectorAll('.section-animate');
                children.forEach((child, i) => {
                    setTimeout(() => {
                        child.classList.add('animate-visible');
                    }, i * 100);
                });
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    document.querySelectorAll('.section-animate').forEach(el => {
        observer.observe(el);
    });
}

// Cursor glow trail
function initCursorGlow() {
    const glow = document.getElementById('cursor-glow');
    if (!glow) return;

    let mouseX = 0, mouseY = 0;
    let glowX = 0, glowY = 0;

    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        glow.style.opacity = '1';
    });

    document.addEventListener('mouseleave', () => {
        glow.style.opacity = '0';
    });

    function updateGlow() {
        glowX += (mouseX - glowX) * 0.1;
        glowY += (mouseY - glowY) * 0.1;

        glow.style.left = `${glowX - 160}px`;
        glow.style.top = `${glowY - 160}px`;

        requestAnimationFrame(updateGlow);
    }
    updateGlow();
}

// Nav background on scroll — maroon theme
function initNavScrollEffect() {
    const nav = document.getElementById('main-nav');
    if (!nav) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            nav.classList.add('nav-maroon-scroll');
            nav.classList.add('shadow-lg');
        } else {
            nav.classList.remove('nav-maroon-scroll');
            nav.classList.remove('shadow-lg');
        }
    });
}

// Mobile menu toggle
function initMobileMenu() {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (!btn || !menu) return;

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });

    // Close on link click
    menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            menu.classList.add('hidden');
        });
    });
}

// Parallax scroll effect
function initParallax() {
    const parallaxBgs = document.querySelectorAll('.parallax-bg');
    const parallaxRows = document.querySelectorAll('.experience-parallax-row');

    if (parallaxBgs.length === 0 && parallaxRows.length === 0) return;

    let ticking = false;
    let lastScrollY = window.scrollY;

    function updateParallax() {
        const scrollY = window.scrollY;
        const windowHeight = window.innerHeight;

        // Parallax background layers
        parallaxBgs.forEach(bg => {
            const speed = parseFloat(bg.dataset.parallaxSpeed) || 0.1;
            const section = bg.closest('section');
            if (!section) return;

            const rect = section.getBoundingClientRect();
            // Only apply when section is in or near viewport
            if (rect.bottom < -200 || rect.top > windowHeight + 200) return;

            const sectionCenter = rect.top + rect.height / 2;
            const offset = (sectionCenter - windowHeight / 2) * speed;
            bg.style.transform = `translateY(${offset}px)`;
        });

        // Parallax rows — subtle shift based on scroll position
        parallaxRows.forEach(row => {
            const speed = parseFloat(row.dataset.parallaxSpeed) || 0.03;
            const rect = row.getBoundingClientRect();

            // Only apply when row is in viewport
            if (rect.bottom < -100 || rect.top > windowHeight + 100) return;

            const rowCenter = rect.top + rect.height / 2;
            const offset = (rowCenter - windowHeight / 2) * speed;

            // Preserve existing transforms (from slide-in animation) by only adding parallax on visible rows
            if (row.classList.contains('animate-visible')) {
                row.style.transform = `translateY(${offset}px)`;
            }
        });

        ticking = false;
    }

    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }, { passive: true });

    // Initial call
    updateParallax();
}
