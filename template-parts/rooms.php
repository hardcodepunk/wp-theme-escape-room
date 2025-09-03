<?php
/**
 * Rooms row section
 *
 * Hover to expand a room to 1/3 width, others shrink and hide inner content.
 *
 * @package Escape_Room
 */

if (! defined('ABSPATH')) {
    exit;
}
?>

<style>
  /* Layout + transitions */
  .rooms-row { display:flex; height:100%; width:100%; }
  .rooms-row .card {
    position:relative;
    flex: 1 1 0%;
    overflow:hidden;
    transition:
      flex-grow 300ms ease,
      transform 500ms ease;
  }
  /* Default image motion on hover */
  .rooms-row .card:hover img {
    transform: scale(1.05);
  }

  /* On container hover: everyone shrinks to ratio 2 */
  .rooms-row:hover .card { flex-grow: 2; }
  /* Hovered one expands to ratio 3 -> 3 / (3 + 2 + 2 + 2) = 1/3 */
  .rooms-row:hover .card:hover { flex-grow: 3; }

  /* Hide inner content for non-hovered cards when row is hovered */
  .rooms-row:hover .card:not(:hover) .inner {
    opacity: 0;
    visibility: hidden;
    transform: translateY(6px);
  }

  /* Smooth content transitions */
  .rooms-row .inner {
    transition:
      opacity 200ms ease,
      transform 200ms ease,
      visibility 0s linear 200ms; /* delay visibility change until fade completes */
  }

  /* Keep images/overlay always visible */
  .rooms-row .bg-img { transition: transform 500ms ease; }
  .rooms-row .shade { background: rgba(0,0,0,0.5); }

  /* Reduce motion respect */
  @media (prefers-reduced-motion: reduce) {
    .rooms-row .card, .rooms-row .inner, .rooms-row .bg-img { transition: none !important; }
  }
</style>

<section class="relative h-screen w-full">
  <div class="rooms-row divide-x divide-white">

    <?php
    $rooms = [
      [ 'title' => 'Alice in Wonderland', 'img' => 'room.png' ],
      [ 'title' => 'Room Two',            'img' => 'room.png' ],
      [ 'title' => 'Room Three',          'img' => 'room.png' ],
      [ 'title' => 'Room Four',           'img' => 'room.png' ],
    ];

foreach ($rooms as $room) : ?>
      <div class="card group">
        <!-- Image -->
        <img
          src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/' . $room['img']); ?>"
          alt="<?php echo esc_attr($room['title']); ?>"
          class="bg-img absolute inset-0 w-full h-full object-cover"
          loading="lazy"
          decoding="async"
        />

        <!-- Dark overlay -->
        <div class="shade absolute inset-0"></div>

        <!-- Centered content (this will hide on non-hovered cards) -->
        <div class="inner absolute inset-0 flex flex-col items-center justify-end text-center text-white space-y-4 px-6 pb-12">
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
