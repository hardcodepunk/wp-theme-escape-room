(function () {
  const row = document.getElementById('roomsRow');
  if (!row) return;

  const cards = Array.from(row.querySelectorAll('.card'));
  const nav = document.querySelector('.room-nav');
  const prevBtn = nav?.querySelector('[data-action="prev"]');
  const nextBtn = nav?.querySelector('[data-action="next"]');

  let openIndex = -1; // -1 means none open

  function setDividers(enabled) {
    // Tailwind trick: swap divide color
    row.classList.toggle('divide-white', enabled);
    row.classList.toggle('divide-transparent', !enabled);
  }

  function openCardByIndex(idx) {
    if (idx < 0 || idx >= cards.length) return;
    const card = cards[idx];

    // Close previous
    const prev = row.querySelector('.card.is-open');
    if (prev && prev !== card) prev.classList.remove('is-open');

    row.classList.add('has-open');
    setDividers(false); // hide white divider lines when open
    card.classList.add('is-open');
    openIndex = idx;

    const cta = card.querySelector('.cta');
    if (cta) cta.setAttribute('aria-expanded', 'true');

    // show nav arrows
    if (nav) nav.classList.add('is-visible');
  }

  function closeOpenCard() {
    const open = row.querySelector('.card.is-open');
    if (!open) return;

    open.classList.remove('is-open');
    row.classList.remove('has-open');
    setDividers(true); // restore dividers
    openIndex = -1;

    const cta = open.querySelector('.cta');
    if (cta) {
      cta.setAttribute('aria-expanded', 'false');
      cta.focus();
    }

    if (nav) nav.classList.remove('is-visible');
  }

  function cycle(delta) {
    if (openIndex === -1) return;
    const next = (openIndex + delta + cards.length) % cards.length;
    openCardByIndex(next);
  }

  // Click handling
  row.addEventListener('click', function (e) {
    const el = e.target.closest('[data-action]');
    if (!el) return;

    const action = el.getAttribute('data-action');
    if (action === 'open') {
      e.preventDefault();
      const card = el.closest('.card');
      const idx = cards.indexOf(card);
      openCardByIndex(idx);
    } else if (action === 'close') {
      e.preventDefault();
      if (row.classList.contains('has-open')) closeOpenCard();
    }
  });

  // Nav arrows
  if (prevBtn) prevBtn.addEventListener('click', () => cycle(-1));
  if (nextBtn) nextBtn.addEventListener('click', () => cycle(1));

  // Keyboard: Esc closes; ←/→ cycle when open
  document.addEventListener('keydown', function (e) {
    if (!row.classList.contains('has-open')) return;
    if (e.key === 'Escape') closeOpenCard();
    else if (e.key === 'ArrowLeft') cycle(-1);
    else if (e.key === 'ArrowRight') cycle(1);
  });
})();
