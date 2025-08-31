<?php
/**
 * Rooms grid section
 *
 * Displays the 4 room cards with image, title, and cube CTA.
 *
 * @package Escape_Room
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<section class="relative bg-black py-20">
  <div class="container mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

    <?php
    $rooms = [
      [ 'title' => 'Alice in Wonderland', 'img' => 'room-1.jpg' ],
      [ 'title' => 'Room Two',            'img' => 'room-2.jpg' ],
      [ 'title' => 'Room Three',          'img' => 'room-3.jpg' ],
      [ 'title' => 'Room Four',           'img' => 'room-4.jpg' ],
    ];

    foreach ( $rooms as $room ) : ?>
      <div class="relative group overflow-hidden">
        <img
          src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/' . $room['img'] ); ?>"
          alt="<?php echo esc_attr( $room['title'] ); ?>"
          class="w-full h-[400px] object-cover transition-transform duration-500 group-hover:scale-105"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

        <div class="absolute bottom-0 p-6 text-white w-full flex flex-col items-start">
          <h3 class="text-xl font-bold uppercase"><?php echo esc_html( $room['title'] ); ?></h3>
          <p class="mt-2 text-sm opacity-80">Description</p>

          <!-- Cube CTA (same as hero, scaled for card) -->
          <a
            href="#booking"
            class="relative mt-6 group inline-block w-[160px]"
            aria-label="<?php echo esc_attr( 'Enter ' . $room['title'] ); ?>"
          >
            <svg
              class="block w-full h-auto text-white"
              viewBox="0 0 420 260"
              fill="none" stroke="currentColor" stroke-width="1"
              stroke-linejoin="round" vector-effect="non-scaling-stroke"
              preserveAspectRatio="xMidYMid meet" aria-hidden="true"
            >
              <polygon points="40,40 260,140 260,240 40,140" />
              <polyline points="120,0 340,100 340,200" />
              <line x1="40" y1="40" x2="120" y2="0" />
              <line x1="260" y1="140" x2="340" y2="100" />
              <line x1="260" y1="240" x2="340" y2="200" />
            </svg>
            <span class="absolute inset-0 flex items-center justify-center pointer-events-none">
              <span class="inline-block [transform:skew(1deg,25deg)] translate-x-[-8%] translate-y-[4%]
                           text-white font-light tracking-[0.30em] text-[10px] uppercase">
                Enter
              </span>
            </span>
          </a>
        </div>
      </div>
    <?php endforeach; ?>

  </div>
</section>
