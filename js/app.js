document.addEventListener('scroll', () => {
  const hdr = document.querySelector('[data-header]');
  if (!hdr) return;

  if (window.scrollY > 10) {
    hdr.classList.add('bg-black/70', 'backdrop-blur', 'is-scrolled');
  } else {
    hdr.classList.remove('bg-black/70', 'backdrop-blur', 'is-scrolled');
  }
});
