<?php
/**
 * Rooms row section
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
        [
          'title' => 'Alice in Wonderland',
          'img'   => 'room.png',
          'desc'  => 'Tumble down the rabbit hole and race the clock to escape the Queen of Hearts.',
          'long'  => <<<'TXT'
You are cordially invited for tea by Her Majesty, the Queen of Hearts, in Wonderland. But beware! In this crazy and magic world, clocks are never on time, rabbits are always late and cards seem very menacing. While the cheshire cat shows the wrong way, the mad hatter prepares everything for the next mad tea party. Some of you will be directly invited in Wonderland and others will have to travel through the rabbit hole just like Alice did a very long time ago.

But be careful, anyone who ever went in there, never came out again! So if I was you I wouldn’t stay too long. To take your chances and succeed in this beautiful escape room, you’ll have to discover the secret of the Queen of Hearts and open her treasure within the 60 minutes that are given. If you fail, the door through which you came will disappear and you’ll be stuck in Wonderland forever!
TXT,
        ],
        [ 'title' => 'Room Two',   'img' => 'room.png', 'desc' => 'A classic mystery with mechanical twists and layered riddles.' ],
        [ 'title' => 'Room Three', 'img' => 'room.png', 'desc' => 'High-tech heist: disable security, crack the vault, get out in time.' ],
        [ 'title' => 'Room Four',  'img' => 'room.png', 'desc' => 'Ancient temple adventure packed with tactile puzzles and secrets.' ],
      ];

foreach ($rooms as $i => $room) :
    $title = $room['title'] ?? 'Room';
    $desc  = $room['desc']  ?? '';
    $img   = $room['img']   ?? 'room.png';
    ?>
      <div class="card group" data-room="<?php echo esc_attr($i); ?>">
        <img
          src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/' . $img); ?>"
          alt="<?php echo esc_attr($title); ?>"
          class="bg-img absolute inset-0 w-full h-full object-cover"
          loading="lazy" decoding="async"
        />

        <div class="shade absolute inset-0" data-action="close" aria-hidden="true"></div>

        <div class="inner absolute inset-0 flex flex-col items-center justify-end text-center text-white space-y-4 px-6 pb-12">
          <h3 class="text-2xl font-bold uppercase"><?php echo esc_html($title); ?></h3>
          <?php if ($desc) : ?><p class="text-sm opacity-80"><?php echo esc_html($desc); ?></p><?php endif; ?>
          <button type="button" class="cta relative group inline-block w-[160px] mt-4"
                  data-action="open" aria-expanded="false"
                  aria-label="<?php echo esc_attr('Enter ' . $title); ?>">
            <svg class="block w-full h-auto text-white" viewBox="0 0 420 260" fill="none" stroke="currentColor" stroke-width="1" stroke-linejoin="round" vector-effect="non-scaling-stroke" preserveAspectRatio="xMidYMid meet" aria-hidden="true">
              <polygon points="40,40 260,140 260,240 40,140" />
              <polyline points="120,0 340,100 340,200" />
              <line x1="40" y1="40" x2="120" y2="0" />
              <line x1="260" y1="140" x2="340" y2="100" />
              <line x1="260" y1="240" x2="340" y2="200" />
            </svg>
            <span class="absolute inset-0 flex items-center justify-center pointer-events-none translate-x-[-14%] translate-y-[4%]">
              <span class="cta-label inline-block [transform:skew(1deg,25deg)] text-white font-light tracking-[0.30em] text-[10px] uppercase">Enter</span>
            </span>
          </button>
        </div>

        <!-- FIX: remove `relative` so CSS fixed overlay applies -->
        <div class="open-content">
          <div class="content-wrap">
            <div class="mx-auto max-w-5xl px-6 md:px-8 pt-36 md:pt-44 pb-10 space-y-10">



              <section aria-label="<?php echo esc_attr($title . ' gallery'); ?>" class="space-y-6">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                  <?php for ($g = 0; $g < 6; $g++) : ?>
                    <figure class="overflow-hidden">
                      <img
                        src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/' . $img); ?>"
                        alt="<?php echo esc_attr($title . ' photo ' . ($g + 1)); ?>"
                        class="w-full h-40 md:h-48 object-cover transition-transform duration-500 ease-out hover:scale-[1.03]"
                        loading="lazy" decoding="async"
                      />
                    </figure>
                  <?php endfor; ?>
                </div>
              </section>

              <?php if (!empty($room['long'])) : ?>
                <section class="max-w-4xl mx-auto px-6 md:px-8 pt-2 text-white/90 space-y-4 text-base leading-relaxed">
                  <?php echo wp_kses_post(wpautop($room['long'])); ?>
                </section>
              <?php endif; ?>

              <section class="space-y-3 text-sm md:text-base opacity-90">
                <p>Players: 2–6 &nbsp;•&nbsp; Duration: 60 minutes &nbsp;•&nbsp; Difficulty: Medium</p>
                <p>Book your slot, arrive early for a short briefing, then dive into an immersive puzzle experience with optional hints.</p>
              </section>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="room-nav pointer-events-none">
    <button type="button" class="nav-btn prev pointer-events-auto" data-action="prev" aria-label="<?php esc_attr_e('Previous room', 'escape-room'); ?>">
      <span class="sr-only"><?php esc_html_e('Previous', 'escape-room'); ?></span>
      <svg class="nav-icon" viewBox="0 0 100 100" aria-hidden="true">
        <g transform="rotate(-90 50 50)" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
          <line x1="50" y1="18" x2="30" y2="78"/>
          <line x1="50" y1="18" x2="70" y2="78"/>
          <line x1="50" y1="18" x2="50" y2="82"/>
          <line x1="30" y1="78" x2="50" y2="82"/>
          <line x1="70" y1="78" x2="50" y2="82"/>
        </g>
      </svg>
    </button>

    <button type="button" class="nav-btn next pointer-events-auto" data-action="next" aria-label="<?php esc_attr_e('Next room', 'escape-room'); ?>">
      <span class="sr-only"><?php esc_html_e('Next', 'escape-room'); ?></span>
      <svg class="nav-icon" viewBox="0 0 100 100" aria-hidden="true">
        <g transform="rotate(90 50 50)" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
          <line x1="50" y1="18" x2="30" y2="78"/>
          <line x1="50" y1="18" x2="70" y2="78"/>
          <line x1="50" y1="18" x2="50" y2="82"/>
          <line x1="30" y1="78" x2="50" y2="82"/>
          <line x1="70" y1="78" x2="50" y2="82"/>
        </g>
      </svg>
    </button>
  </div>
</section>
