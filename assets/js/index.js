/**
 * Meyrin CTT - Kirby Theme
 * Main JavaScript file
 */

document.addEventListener('DOMContentLoaded', () => {
  // Initialize all components
  initHeadingAnchors();
  initMobileMenu();
  initSmoothScroll();
  initLazyLoad();
});

/**
 * Add URL-friendly anchors to headings.
 */
function initHeadingAnchors() {
  const usedIds = new Set(
    Array.from(document.querySelectorAll('[id]'))
      .map(element => element.id)
      .filter(Boolean)
  );
  const headings = document.querySelectorAll('main h1, main h2, main h3, main h4, main h5, main h6');

  headings.forEach(heading => {
    if (heading.closest('a, button, [data-no-heading-anchor]')) return;

    if (!heading.id) {
      const baseSlug = slugify(heading.textContent);
      if (!baseSlug) return;

      let slug = baseSlug;
      let index = 2;

      while (usedIds.has(slug)) {
        slug = `${baseSlug}-${index}`;
        index += 1;
      }

      heading.id = slug;
      usedIds.add(slug);
    }

    addHeadingAnchor(heading);
  });

  if (window.location.hash) {
    scrollToHash(window.location.hash, 'auto');
    window.setTimeout(() => scrollToHash(window.location.hash, 'auto'), 100);
  }
}

/**
 * Add a visible-on-hover permalink to a heading.
 */
function addHeadingAnchor(heading) {
  if (!heading.id || heading.querySelector('.heading-anchor')) return;

  const anchor = document.createElement('a');
  anchor.className = 'heading-anchor';
  anchor.href = `#${encodeURIComponent(heading.id)}`;
  anchor.setAttribute('aria-label', `Lien vers ${heading.textContent.trim()}`);
  anchor.title = 'Copier le lien de cette section';
  anchor.textContent = '#';

  anchor.addEventListener('click', async event => {
    const absoluteUrl = `${window.location.origin}${window.location.pathname}#${heading.id}`;

    if (navigator.clipboard && window.isSecureContext) {
      event.preventDefault();
      history.pushState(null, '', anchor.getAttribute('href'));
      scrollToHash(anchor.getAttribute('href'));

      try {
        await navigator.clipboard.writeText(absoluteUrl);
        anchor.dataset.copied = 'true';
        window.setTimeout(() => {
          delete anchor.dataset.copied;
        }, 1200);
      } catch (error) {
        window.location.hash = heading.id;
      }
    }
  });

  heading.appendChild(anchor);
}

/**
 * Scroll to a hash target after generated anchors are ready.
 */
function scrollToHash(hash, behavior = 'smooth') {
  const target = getAnchorTarget(hash);
  if (!target) return false;

  target.scrollIntoView({
    behavior,
    block: 'start'
  });

  return true;
}

/**
 * Resolve a hash to an element id or configured alias.
 */
function getAnchorTarget(hash) {
  const id = decodeURIComponent(hash.replace(/^#/, ''));
  if (!id) return null;

  const directTarget = document.getElementById(id);
  if (directTarget) return directTarget;

  return Array.from(document.querySelectorAll('[data-anchor-aliases]')).find(element => {
    const aliases = element.dataset.anchorAliases
      .split(',')
      .map(alias => alias.trim())
      .filter(Boolean);

    return aliases.includes(id);
  }) || null;
}

/**
 * Convert visible heading text to a stable URL fragment.
 */
function slugify(value) {
  return value
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/&/g, ' et ')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-+|-+$/g, '');
}

/**
 * Mobile menu toggle
 */
function initMobileMenu() {
  const toggle = document.querySelector('.mobile-menu-toggle');
  const nav = document.querySelector('.main-nav');

  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', !isExpanded);
      nav.classList.toggle('hidden');
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!toggle.contains(e.target) && !nav.contains(e.target)) {
        toggle.setAttribute('aria-expanded', 'false');
        nav.classList.add('hidden');
      }
    });

    // Close menu on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        toggle.setAttribute('aria-expanded', 'false');
        nav.classList.add('hidden');
      }
    });
  }
}

/**
 * Smooth scrolling for anchor links
 */
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const targetId = this.getAttribute('href');
      if (targetId === '#') return;

      if (getAnchorTarget(targetId)) {
        e.preventDefault();
        scrollToHash(targetId);
      }
    });
  });
}

/**
 * Lazy loading for images
 */
function initLazyLoad() {
  // Native lazy loading is supported in modern browsers
  // This adds a fallback for older browsers
  if ('loading' in HTMLImageElement.prototype) {
    // Browser supports native lazy loading
    document.querySelectorAll('img[loading="lazy"]').forEach(img => {
      if (img.dataset.src) {
        img.src = img.dataset.src;
      }
    });
  } else {
    // Fallback using Intersection Observer
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    
    if ('IntersectionObserver' in window) {
      const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            if (img.dataset.src) {
              img.src = img.dataset.src;
            }
            observer.unobserve(img);
          }
        });
      });

      lazyImages.forEach(img => imageObserver.observe(img));
    } else {
      // Fallback for browsers without IntersectionObserver
      lazyImages.forEach(img => {
        if (img.dataset.src) {
          img.src = img.dataset.src;
        }
      });
    }
  }
}

/**
 * Utility: Debounce function
 */
function debounce(func, wait = 100) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

/**
 * Utility: Throttle function
 */
function throttle(func, limit = 100) {
  let inThrottle;
  return function executedFunction(...args) {
    if (!inThrottle) {
      func(...args);
      inThrottle = true;
      setTimeout(() => inThrottle = false, limit);
    }
  };
}
