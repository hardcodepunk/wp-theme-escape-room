<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class('bg-black text-white antialiased'); ?>>
<?php wp_body_open(); ?>

<header data-header class="fixed top-0 inset-x-0 z-50 transition-colors">
  <!-- 3-column grid keeps logo dead-center no matter left/right width -->
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-16 grid grid-cols-3 items-center">
    
    <!-- Left: language / social (optional) -->
    <div class="hidden md:flex items-center gap-4 text-xs uppercase tracking-wide opacity-80">
      <a href="#" class="hover:opacity-100">EN</a><span>•</span>
      <a href="#" class="hover:opacity-100">FR</a><span>•</span>
      <a href="#" class="hover:opacity-100">NL</a>
      <span class="mx-3 opacity-40">|</span>
      <a href="#" aria-label="Instagram" class="hover:opacity-100">IG</a>
    </div>

    <!-- Center: cube logo -->
	<div class="flex justify-center">
	<a href="<?php echo esc_url( home_url('/') ); ?>" class="block">
		<img
		src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.svg' ); ?>"
		alt="<?php esc_attr_e('Logo', 'escape-room'); ?>"
		class="logo-img transition-all duration-300 ease-in-out h-20 md:h-28"
		/>
	</a>
	</div>

    <!-- Right: primary menu -->
    <nav class="flex justify-end">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'flex items-center gap-8 text-sm font-semibold tracking-wide uppercase',
        'fallback_cb'    => false,
      ]);
      ?>
    </nav>

  </div>
</header>

<div id="page" class="site">
  <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'escape-room'); ?></a>
