(function () {
  const row = document.getElementById('roomsRow');
  if (!row) return;

  function openCard(card) {
    if (!card) return;

    // Close any previously open card
    const prev = row.querySelector('.card.is-open');
    if (prev && prev !== card) prev.classList.remove('is-open');

    row.classList.add('has-open');
    card.classList.add('is-open');

    const cta = card.querySelector('.cta');
    if (cta) cta.setAttribute('aria-expanded', 'true');
  }

  function closeOpenCard() {
    const open = row.querySelector('.card.is-open');
    if (!open) return;

    open.classList.remove('is-open');
    row.classList.remove('has-open');

    const cta = open.querySelector('.cta');
    if (cta) {
      cta.setAttribute('aria-expanded', 'false');
      cta.focus();
    }
  }

  // Event delegation for open/close
  row.addEventListener('click', function (e) {
    const el = e.target.closest('[data-action]');
    if (!el) return;

    console.log('Action clicked:', el);

    const action = el.getAttribute('data-action');
    if (action === 'open') {
      e.preventDefault();
      const card = el.closest('.card');
      openCard(card);
    } else if (action === 'close') {
      e.preventDefault();
      if (row.classList.contains('has-open')) closeOpenCard();
    }
  });

  // Close on Escape key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && row.classList.contains('has-open')) {
      closeOpenCard();
    }
  });
})();
