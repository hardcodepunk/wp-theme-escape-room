<?php
/**
 * Rooms row section (markup only)
 *
 * Hover handled in CSS; click-to-open/close handled in JS.
 *
 * @package Escape_Room
 */

if (! defined('ABSPATH')) {
    exit;
}
?>

<section class="relative h-screen w-full">
  <div class="rooms-row divide-x divide-white" id="roomsRow">
    <?php
      $rooms = [
        [ 'title' => 'Alice in Wonderland', 'img' => 'room.png', 'desc' => 'Description' ],
        [ 'title' => 'Room Two',            'img' => 'room.png', 'desc' => 'Description' ],
        [ 'title' => 'Room Three',          'img' => 'room.png', 'desc' => 'Description' ],
        [ 'title' => 'Room Four',           'img' => 'room.png', 'desc' => 'Description' ],
      ];

foreach ($rooms as $i => $room) : ?>
        <div class="card group" data-room="<?php echo esc_attr($i); ?>">
          <img
            src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/' . $room['img']); ?>"
            alt="<?php echo esc_attr($room['title']); ?>"
            class="bg-img absolute inset-0 w-full h-full object-cover"
            loading="lazy"
            decoding="async"
          />

          <div class="shade absolute inset-0" data-action="close" aria-hidden="true"></div>

          <!-- Top-center close (shown only when open via CSS) -->
          <button type="button" class="close-btn top-center" data-action="close" aria-label="Close room">
            ✕ <span class="sr-only">Close</span>
          </button>

          <!-- Content -->
          <div class="inner absolute inset-0 flex flex-col items-center justify-end text-center text-white space-y-4 px-6 pb-12">
            <h3 class="text-2xl font-bold uppercase"><?php echo esc_html($room['title']); ?></h3>
            <?php if (! empty($room['desc'])) : ?>
              <p class="text-sm opacity-80"><?php echo esc_html($room['desc']); ?></p>
            <?php endif; ?>

            <button
              type="button"
              class="cta relative group inline-block w-[160px] mt-4"
              data-action="open"
              aria-expanded="false"
              aria-label="<?php echo esc_attr('Enter ' . $room['title']); ?>"
            >
              <svg class="block w-full h-auto text-white" viewBox="0 0 420 260" fill="none" stroke="currentColor" stroke-width="1" stroke-linejoin="round" vector-effect="non-scaling-stroke" preserveAspectRatio="xMidYMid meet" aria-hidden="true">
                <polygon points="40,40 260,140 260,240 40,140" />
                <polyline points="120,0 340,100 340,200" />
                <line x1="40" y1="40" x2="120" y2="0" />
                <line x1="260" y1="140" x2="340" y2="100" />
                <line x1="260" y1="240" x2="340" y2="200" />
              </svg>
              <span class="absolute inset-0 flex items-center justify-center pointer-events-none translate-x-[-14%] translate-y-[4%]">
                <span class="inline-block [transform:skew(1deg,25deg)] text-white font-light tracking-[0.30em] text-[10px] uppercase">Enter</span>
              </span>
            </button>
          </div>
        </div>
    <?php endforeach; ?>
  </div>

  <!-- Nav arrows (only visible when a card is open) -->
  <div class="room-nav pointer-events-none">
    <button type="button" class="nav-btn prev pointer-events-auto" data-action="prev" aria-label="Previous room">‹</button>
    <button type="button" class="nav-btn next pointer-events-auto" data-action="next" aria-label="Next room">›</button>
  </div>
</section>

