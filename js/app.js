(function () {
  const ready = (fn) =>
    document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', fn) : fn();

  ready(() => {
    const header = document.querySelector('[data-header]');
    if (!header) return;

    const chunks = Array.from(header.querySelectorAll('[data-chunk]'));

    let lastY = window.scrollY;
    let accUp = 0,
      accDown = 0;
    let lastToggle = 0;

    const SHOW_THRESHOLD = 30; // px up before showing
    const HIDE_THRESHOLD = 12; // px down before hiding
    const COOLDOWN_MS = 200;

    const atTop = () => window.scrollY <= 8;

    function showHeader() {
      for (const el of chunks) {
        el.classList.remove('opacity-0', '-translate-y-3', 'pointer-events-none');
        el.classList.add('opacity-100', 'translate-y-0');
      }
      // no background changes
    }

    function hideHeader() {
      for (const el of chunks) {
        el.classList.add('opacity-0', '-translate-y-3', 'pointer-events-none');
        el.classList.remove('opacity-100', 'translate-y-0');
      }
      // no background changes
    }

    // Start visible at top
    showHeader();

    let ticking = false;
    function onScroll() {
      const y = window.scrollY;
      const dy = y - lastY;

      if (dy > 0) {
        accDown += dy;
        accUp = 0;
      } else if (dy < 0) {
        accUp += -dy;
        accDown = 0;
      }

      const now = performance.now();
      const cooled = now - lastToggle > COOLDOWN_MS;

      if (atTop()) {
        showHeader();
        accUp = accDown = 0;
        lastToggle = now;
      } else if (dy < 0 && accUp >= SHOW_THRESHOLD && cooled) {
        showHeader();
        accUp = accDown = 0;
        lastToggle = now;
      } else if (dy > 0 && accDown >= HIDE_THRESHOLD && cooled) {
        hideHeader();
        accUp = accDown = 0;
        lastToggle = now;
      }

      lastY = y;
      ticking = false;
    }

    window.addEventListener(
      'scroll',
      () => {
        if (!ticking) {
          ticking = true;
          requestAnimationFrame(onScroll);
        }
      },
      { passive: true }
    );
  });
})();
