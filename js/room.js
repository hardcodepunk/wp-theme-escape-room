(function () {
  const row = document.getElementById('roomsRow');
  if (!row) return;

  const cards = Array.from(row.querySelectorAll('.card'));
  const nav = document.querySelector('.room-nav');
  const prevBtn = nav?.querySelector('[data-action="prev"]');
  const nextBtn = nav?.querySelector('[data-action="next"]');
  const lastIdx = cards.length - 1;

  let openIndex = -1; // -1 = none open

  function setDividers(enabled) {
    row.classList.toggle('divide-white', enabled);
    row.classList.toggle('divide-transparent', !enabled);
  }

  // --- CTA helpers ---
  function setCtaToLeave(card) {
    const cta = card.querySelector('.cta');
    const label = card.querySelector('.cta .cta-label');
    if (!cta || !label) return;
    cta.dataset.action = 'close';
    cta.setAttribute('aria-expanded', 'true');
    label.textContent = 'Leave';
  }

  function setCtaToEnter(card) {
    const cta = card.querySelector('.cta');
    const label = card.querySelector('.cta .cta-label');
    if (!cta || !label) return;
    cta.dataset.action = 'open';
    cta.setAttribute('aria-expanded', 'false');
    label.textContent = 'Enter';
  }

  function resetAllCtas() {
    cards.forEach(setCtaToEnter);
  }

  function updateNav() {
    if (!nav) return;

    if (openIndex === -1) {
      nav.classList.remove('is-visible');
      if (prevBtn) {
        prevBtn.hidden = true;
        prevBtn.disabled = true;
        prevBtn.setAttribute('aria-disabled', 'true');
      }
      if (nextBtn) {
        nextBtn.hidden = true;
        nextBtn.disabled = true;
        nextBtn.setAttribute('aria-disabled', 'true');
      }
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

  function openCardByIndex(idx) {
    if (idx < 0 || idx > lastIdx) return;

    const card = cards[idx];
    const prev = row.querySelector('.card.is-open');

    // close previous and restore its CTA
    if (prev && prev !== card) {
      prev.classList.remove('is-open');
      setCtaToEnter(prev);
    }

    row.classList.add('has-open');
    setDividers(false);

    card.classList.add('is-open');
    setCtaToLeave(card);
    openIndex = idx;

    updateNav();
  }

  function closeOpenCard() {
    const open = row.querySelector('.card.is-open');
    if (!open) return;

    open.classList.remove('is-open');
    setCtaToEnter(open);

    row.classList.remove('has-open');
    setDividers(true);
    openIndex = -1;

    const cta = open.querySelector('.cta');
    if (cta) cta.focus();

    updateNav();
  }

  function cycle(delta) {
    if (openIndex === -1) return;
    const target = Math.min(lastIdx, Math.max(0, openIndex + delta)); // clamp
    if (target !== openIndex) openCardByIndex(target);
  }

  // === Click handling ===
  // Full-card click opens; CTA toggles; shade closes; nav cycles
  row.addEventListener('click', (e) => {
    const actionEl = e.target.closest('[data-action]');
    if (actionEl) {
      const action = actionEl.getAttribute('data-action');
      if (action === 'open') {
        e.preventDefault();
        const card = actionEl.closest('.card');
        const idx = cards.indexOf(card);
        openCardByIndex(idx);
      } else if (action === 'close') {
        e.preventDefault();
        if (row.classList.contains('has-open')) closeOpenCard();
      }
      return;
    }

    // if click wasn't on an actionable, treat clicking the card as open
    if (e.target.closest('button, a')) return;
    const card = e.target.closest('.card');
    if (card) {
      e.preventDefault();
      const idx = cards.indexOf(card);
      openCardByIndex(idx);
    }
  });

  // Nav arrows
  if (prevBtn) prevBtn.addEventListener('click', () => cycle(-1));
  if (nextBtn) nextBtn.addEventListener('click', () => cycle(1));

  // Keyboard: Esc close; ←/→ cycle
  document.addEventListener('keydown', (e) => {
    if (!row.classList.contains('has-open')) return;
    if (e.key === 'Escape') closeOpenCard();
    else if (e.key === 'ArrowLeft') cycle(-1);
    else if (e.key === 'ArrowRight') cycle(1);
  });

  // Initial state
  resetAllCtas();
  updateNav();
})();
