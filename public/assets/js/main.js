// TJKT SMK Fadris - Public Page JavaScript

document.addEventListener('DOMContentLoaded', () => {

  // ===== NAVBAR SCROLL =====
  const navbar = document.getElementById('navbar');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  }, { passive: true });

  // ===== MOBILE MENU =====
  const toggle = document.getElementById('navbarToggle');
  const mobileMenu = document.getElementById('mobileMenu');
  toggle?.addEventListener('click', () => {
    const isOpen = mobileMenu.classList.toggle('open');
    toggle.setAttribute('aria-expanded', isOpen);
  });

  // Close mobile menu on link click
  mobileMenu?.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      mobileMenu.classList.remove('open');
      toggle?.setAttribute('aria-expanded', 'false');
    });
  });

  // ===== INTERSECTION OBSERVER for animations =====
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        const delay = entry.target.style.animationDelay || '0s';
        setTimeout(() => {
          entry.target.classList.add('visible');
        }, parseFloat(delay) * 1000);
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  document.querySelectorAll('.animate-on-scroll').forEach(el => {
    observer.observe(el);
  });

  // ===== SMOOTH SCROLL for anchor links =====
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', (e) => {
      const target = document.querySelector(anchor.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const offset = 80;
        const top = target.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });

  // ===== ACTIVE NAV LINK on scroll =====
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.navbar-nav a');

  window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(section => {
      const sectionTop = section.offsetTop - 100;
      if (window.scrollY >= sectionTop) {
        current = section.getAttribute('id');
      }
    });

    navLinks.forEach(link => {
      link.style.color = '';
      link.style.background = '';
      if (link.getAttribute('href') === `#${current}`) {
        link.style.color = 'var(--primary)';
        link.style.background = 'rgba(14, 165, 233, 0.1)';
      }
    });
  }, { passive: true });

  // ===== COUNTER ANIMATION =====
  const counters = document.querySelectorAll('.stat-number');
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const text = el.textContent;
        const num = parseFloat(text.replace(/[^0-9.]/g, ''));
        const suffix = text.replace(/[0-9.]/g, '');
        if (num && !isNaN(num)) {
          let start = 0;
          const duration = 1500;
          const step = (timestamp) => {
            if (!start) start = timestamp;
            const progress = Math.min((timestamp - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = (num === Math.floor(num)
              ? Math.floor(eased * num)
              : (eased * num).toFixed(1)) + suffix;
            if (progress < 1) requestAnimationFrame(step);
          };
          requestAnimationFrame(step);
        }
        counterObserver.unobserve(el);
      }
    });
  }, { threshold: 0.5 });

  counters.forEach(counter => counterObserver.observe(counter));

  // ===== MOUSE PARALLAX EFFECT =====
  const heroSection = document.getElementById('hero');
  const parallaxEls = document.querySelectorAll('[data-parallax]');

  if (heroSection && parallaxEls.length && window.innerWidth > 768) {
    let mouseX = 0, mouseY = 0;
    let curX = 0, curY = 0;
    let rafId = null;

    heroSection.addEventListener('mousemove', (e) => {
      const rect = heroSection.getBoundingClientRect();
      // Normalize mouse position from center: -1 to 1
      mouseX = ((e.clientX - rect.left) / rect.width  - 0.5) * 2;
      mouseY = ((e.clientY - rect.top)  / rect.height - 0.5) * 2;

      if (!rafId) {
        rafId = requestAnimationFrame(animateParallax);
      }
    });

    heroSection.addEventListener('mouseleave', () => {
      // Smoothly reset to center on mouse leave
      mouseX = 0;
      mouseY = 0;
      if (!rafId) {
        rafId = requestAnimationFrame(animateParallax);
      }
    });

    function animateParallax() {
      // Smooth lerp toward target
      curX += (mouseX - curX) * 0.08;
      curY += (mouseY - curY) * 0.08;

      parallaxEls.forEach(el => {
        const speed = parseFloat(el.dataset.parallax) || 0.05;
        const moveX = curX * speed * 80;
        const moveY = curY * speed * 60;
        el.style.transform = `translate(${moveX}px, ${moveY}px)`;
      });

      // Keep animating while not yet settled
      const settled = Math.abs(curX - mouseX) < 0.001 && Math.abs(curY - mouseY) < 0.001;
      if (!settled) {
        rafId = requestAnimationFrame(animateParallax);
      } else {
        rafId = null;
      }
    }
  }

  // ===== TYPEWRITER EFFECT =====
  const typewriterEl = document.getElementById('hero-typewriter');
  if (typewriterEl) {
    const fullText = typewriterEl.dataset.text || typewriterEl.textContent;
    typewriterEl.textContent = '';
    typewriterEl.style.borderRight = '3px solid rgba(255,255,255,0.8)';
    typewriterEl.style.animation = 'none';

    let charIndex = 0;
    const typeSpeed = 50; // ms per character
    const startDelay = 400; // wait before typing begins

    // Blinking cursor animation
    typewriterEl.style.animation = 'cursorBlink 0.8s step-end infinite';

    function typeChar() {
      if (charIndex < fullText.length) {
        typewriterEl.textContent += fullText[charIndex];
        charIndex++;
        setTimeout(typeChar, typeSpeed);
      } else {
        // Stop cursor blink after a pause
        setTimeout(() => {
          typewriterEl.style.borderRight = 'none';
          typewriterEl.style.animation = 'fadeInUp 0.8s ease 0.2s both';
        }, 2000);
      }
    }

    setTimeout(typeChar, startDelay);
  }

});
