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
  initInscriptionForm();
  initScheduleCalendar();
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
 * Fillable inscription form language switching and print flow.
 */
function initInscriptionForm() {
  const form = document.querySelector('[data-inscription-form]');
  if (!form) return;

  const langButtons = form.querySelectorAll('[data-inscription-lang]');
  const printButtons = form.querySelectorAll('[data-inscription-print]');
  const blankPrintButtons = form.querySelectorAll('[data-inscription-print-empty]');
  const dateInputs = form.querySelectorAll('[data-date-input]');
  let currentLang = 'fr';

  const setLanguage = (lang) => {
    currentLang = lang;
    form.dataset.lang = lang;
    document.documentElement.dataset.inscriptionLang = lang;

    form.querySelectorAll('[data-lang-fr][data-lang-en]').forEach(element => {
      const value = element.dataset[`lang${lang.charAt(0).toUpperCase()}${lang.slice(1)}`];
      if (typeof value !== 'undefined') {
        if (element.hasAttribute('data-lang-rich')) {
          element.innerHTML = value;
        } else {
          element.textContent = value;
        }
      }
    });

    dateInputs.forEach(input => {
      const suffix = lang.charAt(0).toUpperCase() + lang.slice(1);
      input.placeholder = input.dataset[`placeholder${suffix}`] || input.placeholder;
      input.title = input.dataset[`title${suffix}`] || input.title;
    });

    langButtons.forEach(button => {
      const isActive = button.dataset.inscriptionLang === lang;
      button.classList.toggle('is-active', isActive);
      button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
    });
  };

  const validateDateInput = (input) => {
    if (!input.value) {
      input.setCustomValidity('');
      return true;
    }

    const match = input.value.match(/^(\d{2})\.(\d{2})\.(\d{4})$/);
    const invalidMessage = currentLang === 'en'
      ? 'Please use the format dd.mm.yyyy.'
      : 'Veuillez utiliser le format jj.mm.aaaa.';

    if (!match) {
      input.setCustomValidity(invalidMessage);
      return false;
    }

    const day = Number(match[1]);
    const month = Number(match[2]);
    const year = Number(match[3]);
    const date = new Date(year, month - 1, day);
    const isValidDate = date.getFullYear() === year
      && date.getMonth() === month - 1
      && date.getDate() === day;

    input.setCustomValidity(isValidDate ? '' : invalidMessage);
    return isValidDate;
  };

  const validateDates = () => {
    let allValid = true;
    dateInputs.forEach(input => {
      if (!validateDateInput(input)) {
        allValid = false;
      }
    });
    return allValid;
  };

  const sanitizeFilenamePart = (value) => {
    return value
      .trim()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .replace(/[^a-zA-Z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '');
  };

  const titleCaseFilenamePart = (value) => {
    return value
      .split('-')
      .filter(Boolean)
      .map(part => part.charAt(0).toUpperCase() + part.slice(1).toLowerCase())
      .join('-');
  };

  const buildPrintTitle = (isBlank = false) => {
    if (isBlank) return 'Demande-adhesion-Meyrin-CTT-vierge';

    const familyName = sanitizeFilenamePart(form.querySelector('[name="family_name"]')?.value || '');
    const firstName = sanitizeFilenamePart(form.querySelector('[name="first_name"]')?.value || '');

    if (familyName && firstName) {
      return `${familyName.toUpperCase()}.${titleCaseFilenamePart(firstName)}`;
    }

    if (familyName) return familyName.toUpperCase();
    if (firstName) return titleCaseFilenamePart(firstName);
    return 'Demande-adhesion-Meyrin-CTT';
  };

  const printWithSuggestedTitle = (title) => {
    const previousTitle = document.title;

    const restoreTitle = () => {
      document.title = previousTitle;
      window.removeEventListener('afterprint', restoreTitle);
    };

    document.title = title;
    window.addEventListener('afterprint', restoreTitle);
    window.setTimeout(restoreTitle, 1000);
    window.print();
  };

  langButtons.forEach(button => {
    button.addEventListener('click', () => {
      setLanguage(button.dataset.inscriptionLang || 'fr');
    });
  });

  printButtons.forEach(printButton => {
    printButton.addEventListener('click', () => {
      validateDates();
      if (!form.reportValidity()) {
        const firstInvalid = form.querySelector(':invalid');
        if (firstInvalid) {
          firstInvalid.focus({ preventScroll: true });
          firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return;
      }

      form.dataset.printLang = currentLang;
      printWithSuggestedTitle(buildPrintTitle());
    });
  });

  blankPrintButtons.forEach(printButton => {
    printButton.addEventListener('click', () => {
      const controls = Array.from(form.querySelectorAll('input, textarea, select'));
      const previousValues = controls.map(control => ({
        control,
        checked: control.checked,
        placeholder: control.getAttribute('placeholder'),
        selectedIndex: control.selectedIndex,
        value: control.value
      }));

      controls.forEach(control => {
        // Some mobile print engines render placeholder text even when
        // ::placeholder is transparent. Removing the attribute makes the
        // blank print state independent of that browser-specific behavior.
        control.removeAttribute('placeholder');

        if (control.type === 'radio' || control.type === 'checkbox') {
          control.checked = false;
        } else if (control.tagName === 'SELECT') {
          control.selectedIndex = -1;
        } else {
          control.value = '';
        }
      });

      const restoreValues = () => {
        previousValues.forEach(({ control, checked, placeholder, selectedIndex, value }) => {
          control.checked = checked;
          if (placeholder === null) {
            control.removeAttribute('placeholder');
          } else {
            control.setAttribute('placeholder', placeholder);
          }
          if (control.tagName === 'SELECT') {
            control.selectedIndex = selectedIndex;
          }
          control.value = value;
        });
        form.classList.remove('is-printing-blank');
        window.removeEventListener('afterprint', restoreValues);
      };

      form.classList.add('is-printing-blank');
      window.addEventListener('afterprint', restoreValues);
      form.dataset.printLang = currentLang;
      printWithSuggestedTitle(buildPrintTitle(true));
    });
  });

  dateInputs.forEach(input => {
    input.addEventListener('input', () => {
      const digits = input.value.replace(/\D/g, '').slice(0, 8);
      const parts = [
        digits.slice(0, 2),
        digits.slice(2, 4),
        digits.slice(4, 8)
      ].filter(Boolean);

      input.value = parts.join('.');
      validateDateInput(input);
    });

    input.addEventListener('blur', () => {
      validateDateInput(input);
    });
  });

  setLanguage(currentLang);
}

/**
 * Build the responsive weekly schedule and its accessible event dialog.
 */
function initScheduleCalendar() {
  const calendarElement = document.querySelector('[data-schedule-calendar]');
  if (!calendarElement) return;

  const statusElement = document.querySelector('[data-schedule-status]');
  const dialog = document.querySelector('[data-schedule-dialog]');
  const mobileQuery = window.matchMedia('(max-width: 767px)');
  const hideWeekends = calendarElement.dataset.hideWeekends === 'true';
  const configuredSlotMinHeight = Number.parseInt(calendarElement.dataset.slotMinHeight, 10);
  const slotMinHeight = Number.isFinite(configuredSlotMinHeight)
    ? Math.min(60, Math.max(24, configuredSlotMinHeight))
    : 40;

  if (typeof FullCalendar === 'undefined') {
    if (statusElement) {
      statusElement.textContent = 'Le calendrier ne peut pas être chargé pour le moment. Les détails des créneaux sont disponibles ci-dessous.';
      statusElement.classList.add('is-error');
    }
    return;
  }

  const setDialogText = (selector, value, hideWhenEmpty = false) => {
    if (!dialog) return;
    const element = dialog.querySelector(selector);
    if (!element) return;

    element.textContent = value || '';
    element.hidden = hideWhenEmpty && !value;
  };

  const setDialogHtml = (selector, html, fallbackText = '') => {
    if (!dialog) return;
    const element = dialog.querySelector(selector);
    if (!element) return;

    if (html) {
      element.innerHTML = html;
    } else {
      element.textContent = fallbackText || '';
    }

    element.hidden = !html && !fallbackText;
  };

  const formatEventRange = event => {
    if (!event.start) return '';

    const date = new Intl.DateTimeFormat('fr-CH', {
      weekday: 'long',
      day: 'numeric',
      month: 'long'
    }).format(event.start);
    const timeFormatter = new Intl.DateTimeFormat('fr-CH', {
      hour: '2-digit',
      minute: '2-digit',
      hour12: false
    });
    const startTime = timeFormatter.format(event.start).replace(':', 'h');
    const endTime = event.end ? timeFormatter.format(event.end).replace(':', 'h') : '';

    return `${date.charAt(0).toUpperCase()}${date.slice(1)} · ${startTime}${endTime ? `–${endTime}` : ''}`;
  };

  const openEventDialog = event => {
    if (!dialog) return;

    setDialogText('[data-schedule-dialog-category]', event.extendedProps.category, true);
    setDialogText('[data-schedule-dialog-title]', event.title);
    setDialogText('[data-schedule-dialog-time]', formatEventRange(event));
    setDialogText(
      '[data-schedule-dialog-trainer]',
      event.extendedProps.trainer ? `Entraîneur·e : ${event.extendedProps.trainer}` : '',
      true
    );
    setDialogHtml(
      '[data-schedule-dialog-description]',
      event.extendedProps.descriptionHtml,
      event.extendedProps.description
    );

    dialog.dataset.color = event.extendedProps.color || 'blue';
    if (typeof dialog.showModal === 'function') {
      dialog.showModal();
    } else {
      dialog.setAttribute('open', '');
    }
  };

  const calendar = new FullCalendar.Calendar(calendarElement, {
    locale: 'fr',
    firstDay: 1,
    weekends: !hideWeekends,
    initialDate: calendarElement.dataset.initialDate,
    initialView: mobileQuery.matches ? 'listWeek' : 'timeGridWeek',
    events: {
      url: calendarElement.dataset.eventsUrl,
      failure: () => {
        if (statusElement) {
          statusElement.textContent = 'Impossible de charger les créneaux. Vous pouvez consulter leur détail ci-dessous.';
          statusElement.classList.add('is-error');
          statusElement.hidden = false;
        }
      }
    },
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'timeGridWeek,timeGridDay,listWeek'
    },
    buttonText: {
      today: "Aujourd'hui",
      week: 'Semaine',
      day: 'Jour',
      list: 'Liste'
    },
    views: {
      timeGridWeek: { buttonText: 'Semaine' },
      timeGridDay: { buttonText: 'Jour' },
      listWeek: { buttonText: 'Liste' }
    },
    allDaySlot: false,
    slotMinTime: calendarElement.dataset.slotMin || '09:00:00',
    slotMaxTime: calendarElement.dataset.slotMax || '22:30:00',
    slotDuration: calendarElement.dataset.slotDuration || '00:30:00',
    slotMinHeight,
    slotLabelInterval: '01:00:00',
    slotLabelFormat: {
      hour: '2-digit',
      minute: '2-digit',
      hour12: false
    },
    eventTimeFormat: {
      hour: '2-digit',
      minute: '2-digit',
      hour12: false
    },
    dayHeaderFormat: {
      weekday: 'short',
      day: 'numeric',
      month: 'numeric'
    },
    nowIndicator: true,
    navLinks: true,
    navLinkDayClick: 'timeGridDay',
    expandRows: true,
    height: 'auto',
    eventMinHeight: 44,
    eventShortHeight: 44,
    slotEventOverlap: false,
    loading: isLoading => {
      calendarElement.setAttribute('aria-busy', isLoading ? 'true' : 'false');
      if (!statusElement || statusElement.classList.contains('is-error')) return;
      statusElement.textContent = isLoading ? 'Chargement du planning…' : 'Planning chargé.';
      statusElement.hidden = !isLoading;
    },
    eventDidMount: info => {
      const label = `${info.event.title}, ${formatEventRange(info.event)}. Sélectionner pour plus d'informations.`;
      info.el.setAttribute('aria-label', label);
      info.el.setAttribute('title', label);
      info.el.setAttribute('tabindex', '0');
      info.el.setAttribute('role', 'button');
      info.el.addEventListener('keydown', event => {
        if (event.key !== 'Enter' && event.key !== ' ') return;
        event.preventDefault();
        openEventDialog(info.event);
      });
    },
    eventClick: info => {
      info.jsEvent.preventDefault();
      openEventDialog(info.event);
    }
  });

  calendar.render();

  let wasMobile = mobileQuery.matches;
  const syncResponsiveView = () => {
    const isMobile = mobileQuery.matches;
    if (isMobile === wasMobile) return;

    const currentView = calendar.view.type;
    if (isMobile && currentView === 'timeGridWeek') {
      calendar.changeView('listWeek');
    } else if (!isMobile && currentView === 'listWeek') {
      calendar.changeView('timeGridWeek');
    }

    wasMobile = isMobile;
    calendar.updateSize();
  };

  if ('ResizeObserver' in window) {
    const resizeObserver = new ResizeObserver(debounce(syncResponsiveView, 100));
    resizeObserver.observe(calendarElement.parentElement || calendarElement);
  } else {
    window.addEventListener('resize', debounce(syncResponsiveView, 100));
  }

  if (dialog) {
    dialog.querySelector('[data-schedule-dialog-close]')?.addEventListener('click', () => dialog.close());
    dialog.addEventListener('click', event => {
      if (event.target === dialog) dialog.close();
    });
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
