<?php get_header(); ?>

<main id="primary" class="site-main">
  <section
    class="relative h-screen bg-cover bg-center"
    style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/hero.png')"
  >
    <!-- Dark overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>

    <!-- Hero content -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white space-y-12">
      <div>
        <h1 class="leading-tight flex flex-col items-center font-thin uppercase text-8xl">Let me out</h1>
        <p class="mt-4 text-lg text uppercase font-thin">Escape from our puzzle rooms in the heart of Brussels.</p>
      </div>
    </div>

    <!-- Cube button pinned inside section -->
    <a
      href="#booking"
      class="absolute z-20 left-1/2 -translate-x-1/2 bottom-[4%] group inline-block w-[290px]"
      aria-label="Let me in"
    >
      <svg
        class="block w-full h-auto text-white ml-4"
        viewBox="0 0 420 260"
        fill="none"
        stroke="currentColor"
        stroke-width="1"
        stroke-linejoin="round"
        vector-effect="non-scaling-stroke"
        preserveAspectRatio="xMidYMid meet"
      >
        <!-- FRONT -->
        <polygon points="40,40 260,140 260,240 40,140" />

        <!-- BACK (only top + right sides) -->
        <polyline points="120,0 340,100 340,200" />

        <!-- CONNECTORS -->
        <line x1="40" y1="40" x2="120" y2="0" />
        <line x1="260" y1="140" x2="340" y2="100" />
        <line x1="260" y1="240" x2="340" y2="200" />
      </svg>

      <!-- Text overlay -->
      <span
        class="absolute inset-0 translate-x-[-8%] translate-y-[4%] flex items-center justify-center pointer-events-none"
      >
        <span class="inline-block [transform:skew(1deg,25deg)] text-white font-light tracking-[0.30em] text-[12px]">
          LET ME IN
        </span>
      </span>
    </a>
  </section>
</main>

<?php get_footer(); ?>
