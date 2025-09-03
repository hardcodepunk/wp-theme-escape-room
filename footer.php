<?php
/**
 * Footer
 * @package Escape_Room
 */
?>

<footer id="colophon" class="site-footer bg-black">
  <div class="px-6 md:px-10 py-6 flex items-center justify-between">
    <!-- Logo -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center group" aria-label="<?php bloginfo('name'); ?>">
      <img
        src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo.svg'); ?>"
        alt="<?php echo esc_attr(get_bloginfo('name') . ' logo'); ?>"
        class="h-12 md:h-16 w-auto opacity-80 group-hover:opacity-100 transition"
        loading="lazy"
        decoding="async"
      />
    </a>

    <!-- Contact + socials -->
    <div class="flex items-center gap-3 sm:gap-4">
      <span class="hidden sm:inline-block text-white/80">Contact</span>

      <!-- IG 1 -->
      <a
        href="<?php echo esc_url(get_theme_mod('instagram_url', '#')); ?>"
        class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-white/60 hover:border-white transition"
        aria-label="Instagram"
        target="_blank" rel="noreferrer"
      >
        <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/90" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="3" y="3" width="18" height="18" rx="4"></rect>
          <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
          <line x1="17.5" y1="6.5" x2="17.5" y2="6.5"></line>
        </svg>
      </a>
    </div>
  </div>

  <?php wp_footer(); ?>
</footer>
</body>
</html>
