<?php
/**
 * Footer
 * @package Escape_Room
 */
?>

<footer id="colophon" class="site-footer bg-black text-white">
  <div class="mx-auto max-w-7xl px-6 sm:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-16 text-center">

      <div class="space-y-3">
        <h2 class="text-2xl font-thin uppercase tracking-wider">Let Me Out Brussels</h2>
        <address class="not-italic space-y-1">
          <p class="font-light">Place de la Liberté – 3 – Vrijheidsplaats</p>
          <p class="font-light">1000 Brussels</p>
          <p class="font-light">Belgique</p>
        </address>
        <div class="pt-4 space-y-1">
          <p class="uppercase tracking-wide font-light">Sleutelbeen SPRL</p>
          <p class="font-light">VAT: BE 630 977 575</p>
          <p class="font-light">RPR RPM Bruxelles</p>
        </div>
      </div>

      <div class="space-y-5">
        <h3 class="text-xl font-thin uppercase tracking-wider">Office</h3>
        <div class="space-y-2 text-base">
          <p class="font-light">
            <span class="opacity-70">e-mail:</span>
            <a href="mailto:contact@letmeout.be" class="underline decoration-white/40 hover:decoration-white">
              contact@letmeout.be
            </a>
          </p>
          <p class="font-light">
            <span class="opacity-70">tel:</span>
            <a href="tel:+32483719596" class="underline decoration-white/40 hover:decoration-white">
              +32 483 71 95 96
            </a>
          </p>
        </div>

        <div class="flex items-center justify-center gap-6 pt-2">
          <a href="<?php echo esc_url(get_theme_mod('facebook_url', '#')); ?>" aria-label="Facebook" class="opacity-90 hover:opacity-100">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
              <circle cx="12" cy="12" r="10" />
              <path d="M14 8h-2a2 2 0 0 0-2 2v2H8v3h2v5h3v-5h2.3l.7-3H13v-1a1 1 0 0 1 1-1h2V8z"/>
            </svg>
          </a>
          <a href="<?php echo esc_url(get_theme_mod('instagram_url', '#')); ?>" aria-label="Instagram" class="opacity-90 hover:opacity-100">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
              <rect x="4" y="4" width="16" height="16" rx="4" />
              <circle cx="12" cy="12" r="3.5" />
              <circle cx="17" cy="7" r="1" />
            </svg>
          </a>
          <a href="<?php echo esc_url(get_theme_mod('google_url', '#')); ?>" aria-label="Google" class="opacity-90 hover:opacity-100">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
              <circle cx="12" cy="12" r="10" />
              <path d="M12 7a5 5 0 1 0 4.9 6h-4.9v-2h7" />
            </svg>
          </a>
          <a href="<?php echo esc_url(get_theme_mod('tripadvisor_url', '#')); ?>" aria-label="Tripadvisor" class="opacity-90 hover:opacity-100">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
              <path d="M3 10c2-2 6-2 9-2s7 0 9 2" />
              <circle cx="8.5" cy="13.5" r="2.5" />
              <circle cx="15.5" cy="13.5" r="2.5" />
              <path d="M6 13.5l-2 3 3-1" />
              <path d="M18 13.5l2 3-3-1" />
            </svg>
          </a>
        </div>
      </div>

      <div class="space-y-5">
        <div class="space-y-2">
          <h3 class="text-xl font-thin uppercase tracking-wider">Company</h3>
          <a href="<?php echo esc_url(home_url('/terms')); ?>" class="inline-block underline decoration-white/40 hover:decoration-white font-light">
            terms &amp; conditions
          </a>
        </div>
      </div>
    </div>

    <div class="mt-12 border-t border-white/10"></div>

    <div class="mt-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs md:text-sm opacity-70">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center group" aria-label="<?php bloginfo('name'); ?>">
        <img
          src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo.svg'); ?>"
          alt="<?php echo esc_attr(get_bloginfo('name') . ' logo'); ?>"
          class="h-8 md:h-10 w-auto opacity-80 group-hover:opacity-100 transition"
          loading="lazy"
          decoding="async"
        />
      </a>
      <p class="font-light text-center md:text-right w-full md:w-auto">
        &copy; <?php echo date('Y'); ?> Let Me Out Brussels — All rights reserved.
      </p>
    </div>
  </div>

  <?php wp_footer(); ?>
</footer>
</body>
</html>
