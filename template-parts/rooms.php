<?php
/**
 * Rooms grid section
 *
 * Displays the 4 room cards with image, title, and cube CTA.
 *
 * @package Escape_Room
 */

if (! defined('ABSPATH')) {
    exit;
}
?>

<section class="relative h-screen w-full">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 h-full w-full divide-x divide-white">

    <?php
    $rooms = [
      [ 'title' => 'Alice in Wonderland', 'img' => 'room.png' ],
      [ 'title' => 'Room Two',            'img' => 'room.png' ],
      [ 'title' => 'Room Three',          'img' => 'room.png' ],
      [ 'title' => 'Room Four',           'img' => 'room.png' ],
    ];

foreach ($rooms as $room) : ?>
      <div class="relative group h-full overflow-hidden">
        <!-- Image -->
        <img
          src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/' . $room['img']); ?>"
          alt="<?php echo esc_attr($room['title']); ?>"
          class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
          loading="lazy"
          decoding="async"
        />

        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Centered content -->
        <div class="absolute inset-0 flex flex-col items-center justify-end text-center text-white space-y-4 px-6 pb-12">
            <h3 class="text-2xl font-bold uppercase">
                <?php echo esc_html($room['title']); ?>
            </h3>
            <p class="text-sm opacity-80">Description</p>

            <!-- Cube CTA -->
            <a
                href="#booking"
                class="relative group inline-block w-[160px] mt-4"
                aria-label="<?php echo esc_attr('Enter ' . $room['title']); ?>"
            >
                <svg
                class="block w-full h-auto text-white"
                viewBox="0 0 420 260"
                fill="none"
                stroke="currentColor"
                stroke-width="1"
                stroke-linejoin="round"
                vector-effect="non-scaling-stroke"
                preserveAspectRatio="xMidYMid meet"
                aria-hidden="true"
                >
                <polygon points="40,40 260,140 260,240 40,140" />
                <polyline points="120,0 340,100 340,200" />
                <line x1="40" y1="40" x2="120" y2="0" />
                <line x1="260" y1="140" x2="340" y2="100" />
                <line x1="260" y1="240" x2="340" y2="200" />
                </svg>
                <span class="absolute inset-0 flex items-center justify-center pointer-events-none translate-x-[-14%] translate-y-[4%]">
                    <span class="inline-block [transform:skew(1deg,25deg)]
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
