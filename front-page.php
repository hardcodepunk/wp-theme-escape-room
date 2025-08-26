<?php get_header(); ?>

<main id="primary" class="site-main">
  <!-- Hero -->
  <section class="relative h-screen bg-cover bg-center" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/hero.png');">
  <div class="absolute inset-0 bg-black bg-opacity-40"></div>
  <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white">
    <h1 class="text-6xl font-bold tracking-widest leading-tight">LET<br>ME<br>OUT</h1>
    <p class="mt-4 text-lg">Escape from our puzzle rooms in the heart of Brussels.</p>
    <a href="#booking" class="mt-8 inline-block bg-black text-white px-6 py-3 rounded-md font-bold hover:bg-gray-800 transition">
      LET ME IN
    </a>
  </div>
</section>

</main>

<?php get_footer(); ?>
