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
    if (openIndex === -1) {
      nav.classList.remove('is-visible');
      [prevBtn, nextBtn].forEach((b) => {
        if (!b) return;
        b.hidden = true;
        b.disabled = true;
        b.setAttribute('aria-disabled', 'true');
      });
      return;
    }
    nav.classList.add('is-visible');

    const atStart = openIndex <= 0;
    const atEnd = openIndex >= lastIdx;

    if (prevBtn) {
      prevBtn.hidden = atStart;
      prevBtn.disabled = atStart;
      prevBtn.setAttribute('aria-disabled', String(atStart));
    }
    if (nextBtn) {
      nextBtn.hidden = atEnd;
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
    if (openIndex === idx && row.classList.contains('has-open')) return; // already open

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

  // — Keyboard
  document.addEventListener('keydown', (e) => {
    if (!row.classList.contains('has-open')) return;
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

  // — Touch swipe to navigate
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
      if (dy > SWIPE_MAX_Y && dx < SWIPE_MIN_X) {
        // vertical scroll — cancel swipe
        swiping = false;
      }
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

      if (dx <= -SWIPE_MIN_X)
        cycle(1); // swipe left -> next
      else if (dx >= SWIPE_MIN_X) cycle(-1); // swipe right -> prev
    },
    { passive: true }
  );

  // — Init
  resetAllCtas();
  updateNav();

  // Safety: if something else toggles body lock, ensure we clean up on unload
  window.addEventListener('beforeunload', () => lockBody(false));
})();
