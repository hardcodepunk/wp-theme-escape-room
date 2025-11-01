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
    $rooms_q = new WP_Query([
      'post_type'      => 'room',
      'posts_per_page' => -1,
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
    ]);

if ($rooms_q->have_posts()) :
    $i = 0;

    while ($rooms_q->have_posts()) :
        $rooms_q->the_post();

        $post_id = get_the_ID();
        $title   = get_the_title() ?: __('Room', 'escape-room');

        $img_url = get_the_post_thumbnail_url($post_id, 'full');

        $desc = get_post_meta($post_id, 'room_description', true);
        $long = get_post_meta($post_id, 'room_long_description', true);
        ?>
        <div class="card group" data-room="<?php echo esc_attr($i); ?>">
          <img
            src="<?php echo esc_url($img_url); ?>"
            alt="<?php echo esc_attr($title); ?>"
            class="bg-img absolute inset-0 w-full h-full object-cover"
            loading="lazy" decoding="async"
          />

          <div class="shade absolute inset-0" data-action="close" aria-hidden="true"></div>

          <div class="inner absolute inset-0 flex flex-col items-center justify-end text-center text-white space-y-4 px-6 pb-12 max-w-[300px] mx-auto">
            <h3 class="text-2xl font-bold uppercase"><?php echo esc_html($title); ?></h3>

            <?php if (! empty($desc)) : ?>
              <p class="room-short-description text-sm opacity-80"><?php echo esc_html(wp_strip_all_tags($desc)); ?></p>
            <?php endif; ?>

            <button type="button"
  class="cta room-toggle-btn relative group inline-block w-[160px] mt-4"
  data-action="open" aria-expanded="false"
  aria-label="<?php echo esc_attr(sprintf(__('Enter %s', 'escape-room'), $title)); ?>">

  <svg class="block w-full h-auto text-white"
       viewBox="0 0 420 260" preserveAspectRatio="xMidYMid meet"
       aria-hidden="true">

    <g fill="#000" stroke="none">
      <polygon points="40,40 260,140 260,240 40,140"/>
      <polygon points="120,0 340,100 260,140 40,40"/>
      <polygon points="260,140 340,100 340,200 260,240"/>
    </g>

    <g fill="none" stroke="currentColor" stroke-width="1" stroke-linejoin="round" vector-effect="non-scaling-stroke">
      <polygon points="40,40 260,140 260,240 40,140" />
      <polyline points="120,0 340,100 340,200" />
      <line x1="40" y1="40" x2="120" y2="0" />
      <line x1="260" y1="140" x2="340" y2="100" />
      <line x1="260" y1="240" x2="340" y2="200" />
    </g>
  </svg>

  <span class="absolute inset-0 flex items-center justify-center pointer-events-none translate-x-[-14%] translate-y-[4%]">
    <span class="cta-label inline-block [transform:skew(1deg,25deg)] text-white tracking-[0.30em] text-[10px] uppercase">
      Enter
    </span>
  </span>
</button>

          </div>

          <div class="open-content">
            <div class="content-wrap">
              <div class="mx-auto max-w-5xl px-6 md:px-8 pt-36 md:pt-44 pb-10 space-y-10">

                <section aria-label="<?php echo esc_attr($title . ' gallery'); ?>" class="space-y-6">
                  <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                   <?php for ($g = 0; $g < 6; $g++) : ?>
                    <figure class="overflow-hidden">
                      <img
                        src="<?php echo esc_url($img_url); ?>"
                        alt="<?php echo esc_attr($title . ' photo ' . ($g + 1)); ?>"
                        class="room-gallery-img w-full h-40 md:h-48 object-cover transition-transform duration-500 ease-out hover:scale-[1.03]"
                        data-action="open-gallery"
                        data-gindex="<?php echo esc_attr($g); ?>"
                        loading="lazy" decoding="async"
                      />
                    </figure>
                  <?php endfor; ?>
                  </div>
                </section>

                <?php if (! empty($long)) : ?>
                  <section class="max-w-4xl mx-auto px-6 md:px-8 pt-2 text-white/90 space-y-4 text-base leading-relaxed">
                    <?php echo wp_kses_post(wpautop($long)); ?>
                  </section>
                <?php endif; ?>

                <section class="space-y-3 text-sm md:text-base opacity-90 text-center">
                  <p>Players: 2–6 &nbsp;•&nbsp; Duration: 60 minutes &nbsp;•&nbsp; Difficulty: Medium</p>
                  <p>Book your slot, arrive early for a short briefing, then dive into an immersive puzzle experience with optional hints.</p>
                </section>

                 <a
                  href="#"
                  class="cta relative group block w-[160px] mt-10 mx-auto"
                  aria-label="<?php echo esc_attr('Book now'); ?>"
                >
                  <svg class="block w-full h-auto text-white" viewBox="0 0 420 260" fill="none" stroke="currentColor" stroke-width="1" stroke-linejoin="round" vector-effect="non-scaling-stroke" preserveAspectRatio="xMidYMid meet" aria-hidden="true">
                    <polygon points="40,40 260,140 260,240 40,140" />
                    <polyline points="120,0 340,100 340,200" />
                    <line x1="40" y1="40" x2="120" y2="0" />
                    <line x1="260" y1="140" x2="340" y2="100" />
                    <line x1="260" y1="240" x2="340" y2="200" />
                  </svg>
                  <span class="absolute inset-0 flex items-center justify-center pointer-events-none translate-x-[-14%] translate-y-[4%]">
                    <span class="cta-label inline-block [transform:skew(1deg,25deg)] text-white tracking-[0.30em] text-[10px] uppercase">
                      Book now
                    </span>
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <?php
        $i++;
    endwhile;
    wp_reset_postdata();
else :
    echo '<p class="p-6 text-center opacity-70">' . esc_html__('No rooms yet. Add some in the admin.', 'escape-room') . '</p>';
endif;
?>
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
  <!-- Fullscreen Gallery Overlay -->
<div class="gallery-overlay" aria-hidden="true">
  <button type="button" class="gallery-close" aria-label="Close gallery">
    <span class="sr-only">Close</span>
    &times;
  </button>

  <button type="button" class="gallery-nav prev" aria-label="Previous image">
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

  <figure class="gallery-stage">
    <img class="gallery-img" src="" alt="" />
    <figcaption class="gallery-caption"></figcaption>
  </figure>

  <button type="button" class="gallery-nav next" aria-label="Next image">
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
