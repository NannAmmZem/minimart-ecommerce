// Ultra Modern Portfolio JavaScript for Mini Mart

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Navbar background change on scroll
const navbar = document.querySelector('.navbar');
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Scroll reveal animation
const revealElements = document.querySelectorAll('section, .feature-card, .highlight, .screenshot-card, .tech-category, .contact-item, .db-table');

const revealOnScroll = () => {
    revealElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;

        if (elementTop < window.innerHeight - elementVisible) {
            element.classList.add('reveal', 'active');
        }
    });
};

window.addEventListener('scroll', revealOnScroll);
revealOnScroll(); // Initial check

// Animated counter for stats
const animateCounter = (element, target) => {
    let current = 0;
    const increment = target / 100;
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 20);
};

// Trigger counter animation when stats come into view
const stats = document.querySelectorAll('.stat-number');
const statsSection = document.querySelector('.hero-stats');
let statsAnimated = false;

const animateStats = () => {
    if (!statsAnimated && statsSection) {
        const rect = statsSection.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            stats.forEach(stat => {
                const text = stat.textContent;
                if (text.includes('K')) {
                    const value = parseInt(text.replace('K+', ''));
                    animateCounter(stat, value);
                    stat.textContent = value + 'K+';
                } else if (text.includes('%')) {
                    animateCounter(stat, parseInt(text));
                    stat.textContent = '100%';
                } else {
                    animateCounter(stat, parseInt(text));
                }
            });
            statsAnimated = true;
        }
    }
};

window.addEventListener('scroll', animateStats);
animateStats();

// Cursor trail effect (optional - modern interaction)
const cursor = document.createElement('div');
cursor.className = 'cursor-trail';
cursor.style.cssText = `
    position: fixed;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: radial-gradient(circle, var(--primary), transparent);
    pointer-events: none;
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.3s;
`;
document.body.appendChild(cursor);

document.addEventListener('mousemove', (e) => {
    cursor.style.left = e.clientX + 'px';
    cursor.style.top = e.clientY + 'px';
    cursor.style.opacity = '0.6';
});

// Parallax effect on hero section
const hero = document.querySelector('.hero');
window.addEventListener('scroll', () => {
    if (hero) {
        const scrolled = window.pageYOffset;
        hero.style.transform = `translateY(${scrolled * 0.5}px)`;
    }
});

// Interactive hover effect on cards
const cards = document.querySelectorAll('.feature-card, .screenshot-card, .highlight, .contact-item');
cards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        const rotateX = (y - centerY) / 20;
        const rotateY = (centerX - x) / 20;

        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px)`;
    });

    card.addEventListener('mouseleave', () => {
        card.style.transform = '';
    });
});

// Typing effect for hero subtitle
const subtitle = document.querySelector('.hero-subtitle');
if (subtitle) {
    const text = subtitle.textContent;
    subtitle.textContent = '';
    let i = 0;

    const typeWriter = () => {
        if (i < text.length) {
            subtitle.textContent += text.charAt(i);
            i++;
            setTimeout(typeWriter, 50);
        }
    };

    setTimeout(typeWriter, 1000);
}

// Glitch effect on title (subtle)
const title = document.querySelector('.hero-title');
if (title) {
    setInterval(() => {
        title.style.textShadow = `
            ${Math.random() * 2}px ${Math.random() * 2}px 0 var(--primary),
            ${Math.random() * -2}px ${Math.random() * -2}px 0 var(--accent)
        `;
        setTimeout(() => {
            title.style.textShadow = '';
        }, 50);
    }, 3000);
}

// Floating animation for icons
const icons = document.querySelectorAll('.feature-icon, .contact-icon, .highlight-icon, .placeholder-icon');
icons.forEach((icon, index) => {
    icon.style.animation = `float 3s ease-in-out infinite`;
    icon.style.animationDelay = `${index * 0.2}s`;
});

// Button ripple effect
const buttons = document.querySelectorAll('.btn, .contact-btn, .tech-tag');
buttons.forEach(button => {
    button.addEventListener('click', function (e) {
        const ripple = document.createElement('span');
        ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            width: 100px;
            height: 100px;
            margin-left: -50px;
            margin-top: -50px;
            animation: ripple 0.6s;
            pointer-events: none;
        `;
        ripple.style.left = e.clientX - this.offsetLeft + 'px';
        ripple.style.top = e.clientY - this.offsetTop + 'px';

        this.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);
    });
});

// Add ripple animation
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        from {
            opacity: 1;
            transform: scale(0);
        }
        to {
            opacity: 0;
            transform: scale(4);
        }
    }
`;
document.head.appendChild(style);

// Intersection Observer for advanced animations
const observerOptions = {
    threshold: 0.15,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeInUp 1s ease forwards';
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe all animated elements
document.querySelectorAll('.feature-card, .highlight, .tech-category, .db-table, .contact-item').forEach(el => {
    observer.observe(el);
});

// Dynamic background particles effect
function createParticle() {
    const particle = document.createElement('div');
    particle.style.cssText = `
        position: fixed;
        width: 3px;
        height: 3px;
        background: var(--primary);
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
        opacity: 0;
        animation: particleFloat 15s linear;
    `;

    particle.style.left = Math.random() * window.innerWidth + 'px';
    particle.style.top = window.innerHeight + 'px';

    document.body.appendChild(particle);

    setTimeout(() => particle.remove(), 15000);
}

// Add particle float animation
const particleStyle = document.createElement('style');
particleStyle.textContent = `
    @keyframes particleFloat {
        0% {
            transform: translateY(0) translateX(0);
            opacity: 0;
        }
        10% {
            opacity: 1;
        }
        90% {
            opacity: 1;
        }
        100% {
            transform: translateY(-${window.innerHeight}px) translateX(${Math.random() * 200 - 100}px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(particleStyle);

// Create particles periodically
setInterval(createParticle, 300);

// Console message with style
console.log('%c🛒 Mini Mart E-Commerce Platform', 'color: #00f2fe; font-size: 28px; font-weight: bold; text-shadow: 0 0 10px #00f2fe;');
console.log('%cBuilt with Laravel 12.x by NannAmmZem', 'color: #4facfe; font-size: 16px; font-weight: 600;');
console.log('%cView the code: https://github.com/NannAmmZem/minimart-ecommerce', 'color: #f093fb; font-size: 14px;');
console.log('%c✨ Modern Dark Theme with Advanced Animations', 'color: #a855f7; font-size: 12px; font-style: italic;');

// Easter egg: Konami code
let konamiCode = [];
const konamiPattern = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];

document.addEventListener('keydown', (e) => {
    konamiCode.push(e.key);
    konamiCode = konamiCode.slice(-10);

    if (JSON.stringify(konamiCode) === JSON.stringify(konamiPattern)) {
        document.body.style.animation = 'rainbow 2s infinite';
        setTimeout(() => {
            document.body.style.animation = '';
        }, 5000);
        console.log('%c🎉 Konami Code Activated!', 'color: #f093fb; font-size: 24px; font-weight: bold;');
    }
});

// Add rainbow animation
const rainbowStyle = document.createElement('style');
rainbowStyle.textContent = `
    @keyframes rainbow {
        0% { filter: hue-rotate(0deg); }
        100% { filter: hue-rotate(360deg); }
    }
`;
document.head.appendChild(rainbowStyle);

// Loading complete
window.addEventListener('load', () => {
    console.log('%c⚡ All animations loaded successfully!', 'color: #00f2fe; font-size: 14px; font-weight: bold;');
});
