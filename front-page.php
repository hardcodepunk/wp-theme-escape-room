<?php get_header(); ?>

<main id="primary" class="site-main">
  <!-- Hero -->
  <section class="relative h-screen bg-cover bg-center" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/hero.png');">
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>

    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white space-y-12">
      
      <!-- Heading + tagline -->
      <div>
        <h1 class="text-6xl tracking-widest leading-tight">
          LET<br>ME<br>OUT
        </h1>
        <p class="mt-4 text-lg">Escape from our puzzle rooms in the heart of Brussels.</p>
      </div>

      <!-- Cube button -->
      <a href="#booking"
         class="group relative inline-block w-full max-w-[290px]"
         aria-label="Let me in">

        <svg
          class="block w-full h-auto text-white"
          viewBox="0 0 420 260"
          fill="none"
          stroke="currentColor"
          stroke-width="1"
          stroke-linejoin="round"
          vector-effect="non-scaling-stroke"
          preserveAspectRatio="xMidYMid meet">

          <!-- FRONT -->
          <polygon points="40,40 260,140 260,240 40,140" />

          <!-- BACK (only top + right sides) -->
          <polyline points="120,0 340,100 340,200" />

          <!-- CONNECTORS -->
          <line x1="40"  y1="40"  x2="120" y2="0"   />
          <line x1="260" y1="140" x2="340" y2="100" />
          <line x1="260" y1="240" x2="340" y2="200" />
        </svg>

        <span class="absolute inset-0 flex items-center justify-center
             text-white font-light tracking-[0.30em] text-[12px]
             translate-x-[-10%] translate-y-[8%] [transform:skew(1deg,25deg)]">
          LET ME IN
        </span>
      </a>

    </div>
  </section>
</main>

<?php get_footer(); ?>
