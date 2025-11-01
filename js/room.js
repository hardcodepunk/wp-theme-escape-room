(function () {
  const row = document.getElementById('roomsRow');
  if (!row) return;

  const cards = Array.from(row.querySelectorAll('.card'));
  const nav = document.querySelector('.room-nav');
  const prevBtn = nav?.querySelector('[data-action="prev"]');
  const nextBtn = nav?.querySelector('[data-action="next"]');
  const lastIdx = cards.length - 1;

  let openIndex = -1;
  let scrollYBeforeLock = 0;

  // — Utilities
  function setDividers(enabled) {
    row.classList.toggle('divide-white', enabled);
    row.classList.toggle('divide-transparent', !enabled);
  }

  function setCta(card, mode /* 'enter'|'leave' */) {
    const cta = card.querySelector('.cta');
    const label = card.querySelector('.cta .cta-label');
    if (!cta || !label) return;

    if (mode === 'leave') {
      cta.dataset.action = 'close';
      cta.setAttribute('aria-expanded', 'true');
      cta.setAttribute(
        'aria-label',
        'Leave ' + (card.querySelector('h3')?.textContent?.trim() || 'room')
      );
      label.textContent = 'Leave';
    } else {
      cta.dataset.action = 'open';
      cta.setAttribute('aria-expanded', 'false');
      cta.setAttribute(
        'aria-label',
        'Enter ' + (card.querySelector('h3')?.textContent?.trim() || 'room')
      );
      label.textContent = 'Enter';
    }
  }

  function resetAllCtas() {
    cards.forEach((c) => setCta(c, 'enter'));
  }

  function updateNav() {
    if (!nav) return;

    const isOpen = openIndex !== -1;
    nav.style.display = isOpen ? 'block' : 'none';

    const disableAll = (btn) => {
      if (!btn) return;
      btn.disabled = true;
      btn.setAttribute('aria-disabled', 'true');
    };

    if (!isOpen) {
      disableAll(prevBtn);
      disableAll(nextBtn);
      return;
    }

    const atStart = openIndex <= 0;
    const atEnd = openIndex >= lastIdx;

    if (prevBtn) {
      prevBtn.disabled = atStart;
      prevBtn.setAttribute('aria-disabled', String(atStart));
    }
    if (nextBtn) {
      nextBtn.disabled = atEnd;
      nextBtn.setAttribute('aria-disabled', String(atEnd));
    }
  }

  // Scroll lock without jump
  function lockBody(lock) {
    if (lock) {
      scrollYBeforeLock = window.scrollY || document.documentElement.scrollTop || 0;
      document.body.style.position = 'fixed';
      document.body.style.top = `-${scrollYBeforeLock}px`;
      document.body.style.left = '0';
      document.body.style.right = '0';
      document.body.classList.add('modal-open');
      document.documentElement.classList.add('modal-open');
    } else {
      document.body.style.position = '';
      document.body.style.top = '';
      document.body.style.left = '';
      document.body.style.right = '';
      document.body.classList.remove('modal-open');
      document.documentElement.classList.remove('modal-open');
      window.scrollTo(0, scrollYBeforeLock);
    }
  }

  // — Open / Close
  function openCardByIndex(idx) {
    if (idx < 0 || idx > lastIdx) return;
    if (openIndex === idx && row.classList.contains('has-open')) return;

    const card = cards[idx];
    const prev = row.querySelector('.card.is-open');

    if (prev && prev !== card) {
      prev.classList.remove('is-open');
      setCta(prev, 'enter');
    }

    row.classList.add('has-open');
    setDividers(false);

    card.classList.add('is-open');
    setCta(card, 'leave');
    openIndex = idx;

    lockBody(true);
    updateNav();
  }

  function closeOpenCard() {
    const open = row.querySelector('.card.is-open');
    if (!open) return;

    open.classList.remove('is-open');
    setCta(open, 'enter');

    row.classList.remove('has-open');
    setDividers(true);
    openIndex = -1;

    const cta = open.querySelector('.cta');
    if (cta) cta.focus();

    lockBody(false);
    updateNav();
  }

  function cycle(delta) {
    if (openIndex === -1) return;
    const target = Math.min(lastIdx, Math.max(0, openIndex + delta));
    if (target !== openIndex) openCardByIndex(target);
  }

  // — Click handling
  row.addEventListener('click', (e) => {
    const actionEl = e.target.closest('[data-action]');
    if (actionEl) {
      const action = actionEl.getAttribute('data-action');
      if (action === 'open') {
        e.preventDefault();
        const card = actionEl.closest('.card');
        openCardByIndex(cards.indexOf(card));
      } else if (action === 'close') {
        e.preventDefault();
        if (row.classList.contains('has-open')) closeOpenCard();
      }
      return;
    }

    // Only treat bare card clicks as "open" (ignore inner links/buttons)
    if (e.target.closest('button, a')) return;

    // Shade click should only close if it's the open card's shade
    const shade = e.target.closest('.shade');
    if (shade) {
      if (
        row.classList.contains('has-open') &&
        shade.closest('.card')?.classList.contains('is-open')
      ) {
        e.preventDefault();
        closeOpenCard();
      }
      return;
    }

    const card = e.target.closest('.card');
    if (card) {
      e.preventDefault();
      openCardByIndex(cards.indexOf(card));
    }
  });

  // — Nav buttons
  if (prevBtn) prevBtn.addEventListener('click', () => cycle(-1));
  if (nextBtn) nextBtn.addEventListener('click', () => cycle(1));

  // — Keyboard (room popup)
  document.addEventListener('keydown', (e) => {
    if (!row.classList.contains('has-open')) return;
    if (gallery.overlay && gallery.overlay.classList.contains('is-visible')) return; // gallery takes priority
    if (e.key === 'Escape') {
      e.preventDefault();
      closeOpenCard();
    } else if (e.key === 'ArrowLeft') {
      e.preventDefault();
      cycle(-1);
    } else if (e.key === 'ArrowRight') {
      e.preventDefault();
      cycle(1);
    }
  });

  // — Touch swipe to navigate (room popup)
  let touchStartX = 0,
    touchStartY = 0,
    swiping = false;
  const SWIPE_MIN_X = 40,
    SWIPE_MAX_Y = 30;

  row.addEventListener(
    'touchstart',
    (e) => {
      if (!row.classList.contains('has-open')) return;
      const t = e.changedTouches[0];
      touchStartX = t.clientX;
      touchStartY = t.clientY;
      swiping = true;
    },
    { passive: true }
  );

  row.addEventListener(
    'touchmove',
    (e) => {
      if (!swiping) return;
      const t = e.changedTouches[0];
      const dx = Math.abs(t.clientX - touchStartX);
      const dy = Math.abs(t.clientY - touchStartY);
      if (dy > SWIPE_MAX_Y && dx < SWIPE_MIN_X) swiping = false;
    },
    { passive: true }
  );

  row.addEventListener(
    'touchend',
    (e) => {
      if (!swiping) return;
      swiping = false;
      if (!row.classList.contains('has-open')) return;

      const t = e.changedTouches[0];
      const dx = t.clientX - touchStartX;
      const dy = Math.abs(t.clientY - touchStartY);
      if (dy > SWIPE_MAX_Y) return;

      if (dx <= -SWIPE_MIN_X) cycle(1);
      else if (dx >= SWIPE_MIN_X) cycle(-1);
    },
    { passive: true }
  );

  // ===== Gallery state
  const gallery = {
    overlay: document.querySelector('.gallery-overlay'),
    img: null,
    caption: null,
    prev: null,
    next: null,
    close: null,
    images: [], // array of {src, alt}
    index: 0,
  };

  if (gallery.overlay) {
    gallery.overlay.setAttribute('role', 'dialog');
    gallery.overlay.setAttribute('aria-modal', 'true');
    gallery.overlay.setAttribute('aria-hidden', 'true');

    gallery.img = gallery.overlay.querySelector('.gallery-img');
    gallery.caption = gallery.overlay.querySelector('.gallery-caption');
    gallery.prev = gallery.overlay.querySelector('.gallery-nav.prev');
    gallery.next = gallery.overlay.querySelector('.gallery-nav.next');
    gallery.close = gallery.overlay.querySelector('.gallery-close');

    if (gallery.img) gallery.img.setAttribute('draggable', 'false');
  }

  function renderGalleryFrame() {
    const item = gallery.images[gallery.index];
    if (!item) return;
    gallery.img.setAttribute('src', item.src);
    gallery.img.setAttribute('alt', item.alt);
    gallery.caption.textContent = item.alt;
  }

  function updateGalleryNav() {
    const atStart = gallery.index <= 0;
    const atEnd = gallery.index >= gallery.images.length - 1;
    if (gallery.prev) {
      gallery.prev.disabled = atStart;
      gallery.prev.setAttribute('aria-disabled', String(atStart));
    }
    if (gallery.next) {
      gallery.next.disabled = atEnd;
      gallery.next.setAttribute('aria-disabled', String(atEnd));
    }
  }

  function preload(idx) {
    const it = gallery.images[idx];
    if (!it) return;
    const im = new Image();
    im.src = it.src;
  }

  function openGalleryFromCard(card, startIndex) {
    if (!gallery.overlay) return;

    // collect images from the *open* card's gallery
    const thumbs = Array.from(card.querySelectorAll('.room-gallery-img'));
    gallery.images = thumbs.map((el) => ({
      src: el.getAttribute('src'),
      alt: el.getAttribute('alt') || '',
    }));

    if (!gallery.images.length) return;

    gallery.index = Math.max(0, Math.min(startIndex || 0, gallery.images.length - 1));
    renderGalleryFrame();
    updateGalleryNav();
    preload(gallery.index + 1);
    preload(gallery.index - 1);

    gallery.overlay.classList.add('is-visible');
    gallery.overlay.setAttribute('aria-hidden', 'false');
  }

  function closeGallery() {
    if (!gallery.overlay) return;
    gallery.overlay.classList.remove('is-visible');
    gallery.overlay.setAttribute('aria-hidden', 'true');
    gallery.images = [];
    gallery.index = 0;
  }

  function galleryCycle(delta) {
    if (!gallery.images.length) return;
    const nextIdx = Math.min(gallery.images.length - 1, Math.max(0, gallery.index + delta));
    if (nextIdx !== gallery.index) {
      gallery.index = nextIdx;
      renderGalleryFrame();
      updateGalleryNav();
      preload(gallery.index + 1);
      preload(gallery.index - 1);
    }
  }

  // Clicks inside rows: open gallery if clicking a gallery img while room is open
  row.addEventListener('click', (e) => {
    if (!row.classList.contains('has-open')) return;
    const openCard = row.querySelector('.card.is-open');
    if (!openCard) return;

    const opener = e.target.closest('[data-action="open-gallery"]');
    if (opener) {
      e.preventDefault();
      const idx = parseInt(opener.getAttribute('data-gindex') || '0', 10);
      openGalleryFromCard(openCard, idx);
    }
  });

  // Gallery controls
  if (gallery.prev) gallery.prev.addEventListener('click', () => galleryCycle(-1));
  if (gallery.next) gallery.next.addEventListener('click', () => galleryCycle(1));
  if (gallery.close) gallery.close.addEventListener('click', closeGallery);

  // Close by background click
  if (gallery.overlay) {
    gallery.overlay.addEventListener('click', (e) => {
      // avoid closing when clicking image or arrows
      if (e.target.closest('.gallery-stage, .gallery-nav')) return;
      closeGallery();
    });
  }

  // Keyboard for gallery (when visible)
  document.addEventListener('keydown', (e) => {
    if (!gallery.overlay || !gallery.overlay.classList.contains('is-visible')) return;
    if (e.key === 'Escape') {
      e.preventDefault();
      closeGallery();
    } else if (e.key === 'ArrowLeft') {
      e.preventDefault();
      galleryCycle(-1);
    } else if (e.key === 'ArrowRight') {
      e.preventDefault();
      galleryCycle(1);
    }
  });

  // Touch swipe for gallery
  let gStartX = 0,
    gStartY = 0,
    gSwiping = false;
  const G_SWIPE_MIN_X = 40,
    G_SWIPE_MAX_Y = 30;

  if (gallery.overlay) {
    gallery.overlay.addEventListener(
      'touchstart',
      (e) => {
        if (!gallery.overlay.classList.contains('is-visible')) return;
        const t = e.changedTouches[0];
        gStartX = t.clientX;
        gStartY = t.clientY;
        gSwiping = true;
      },
      { passive: true }
    );

    gallery.overlay.addEventListener(
      'touchmove',
      (e) => {
        if (!gSwiping) return;
        const t = e.changedTouches[0];
        const dx = Math.abs(t.clientX - gStartX);
        const dy = Math.abs(t.clientY - gStartY);
        if (dy > G_SWIPE_MAX_Y && dx < G_SWIPE_MIN_X) gSwiping = false;
      },
      { passive: true }
    );

    gallery.overlay.addEventListener(
      'touchend',
      (e) => {
        if (!gSwiping) return;
        gSwiping = false;
        if (!gallery.overlay.classList.contains('is-visible')) return;

        const t = e.changedTouches[0];
        const dx = t.clientX - gStartX;
        const dy = Math.abs(t.clientY - gStartY);
        if (dy > G_SWIPE_MAX_Y) return;

        if (dx <= -G_SWIPE_MIN_X)
          galleryCycle(1); // left swipe -> next
        else if (dx >= G_SWIPE_MIN_X) galleryCycle(-1); // right swipe -> prev
      },
      { passive: true }
    );
  }

  // When closing the room popup, also ensure gallery is closed (safe wrap)
  if (typeof closeOpenCard === 'function') {
    const origCloseOpenCard = closeOpenCard;
    closeOpenCard = function () {
      if (gallery.overlay && gallery.overlay.classList.contains('is-visible')) {
        closeGallery();
      }
      origCloseOpenCard();
    };
  }

  // — Init
  resetAllCtas();
  updateNav();

  // Safety: if something else toggles body lock, ensure we clean up on unload
  window.addEventListener('beforeunload', () => lockBody(false));
})();
