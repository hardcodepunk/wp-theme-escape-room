<?php
/**
 * Reviews section
 *
 * @package Escape_Room
 */

if (! defined('ABSPATH')) {
    exit;
}

/** Allow overrides via $args when using get_template_part( ..., ..., $args ) */
$heading = isset($args['heading']) ? (string) $args['heading'] : __('What players say', 'escape-room');
$more_url = isset($args['more_url']) ? (string) $args['more_url'] : '#';
$reviews = isset($args['reviews']) && is_array($args['reviews']) ? $args['reviews'] : [
  [
    'name'   => 'Alex J.',
    'source' => 'Google',
    'date'   => 'Aug 2025',
    'rating' => 5,
    'text'   => 'Incredible puzzles and ambience. We barely made it out and loved every second.',
  ],
  [
    'name'   => 'Maya R.',
    'source' => 'Tripadvisor',
    'date'   => 'Jul 2025',
    'rating' => 5,
    'text'   => 'Super friendly staff, clever riddles, and gorgeous set design. Highly recommend!',
  ],
  [
    'name'   => 'Luca P.',
    'source' => 'Google',
    'date'   => 'Jun 2025',
    'rating' => 4,
    'text'   => 'Great flow and a couple of surprising twists. Perfect group activity in Brussels.',
  ],
  [
    'name'   => 'Sophie D.',
    'source' => 'Facebook',
    'date'   => 'May 2025',
    'rating' => 5,
    'text'   => 'Best escape room we’ve done—immersive from the first clue to the final lock!',
  ],
];
?>

<section class="bg-black text-white" aria-labelledby="reviews-heading">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
    <div class="mb-10 flex items-end justify-between gap-6">
      <h2 id="reviews-heading" class="text-2xl md:text-3xl font-light uppercase tracking-widest">
        <?php echo esc_html($heading); ?>
      </h2>
      <?php if ($more_url) : ?>
        <a href="<?php echo esc_url($more_url); ?>"
           class="hidden md:inline-block text-sm uppercase tracking-wider opacity-70 hover:opacity-100">
          <?php esc_html_e('Read more reviews →', 'escape-room'); ?>
        </a>
      <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
      <?php foreach ($reviews as $r) :
          $name   = isset($r['name']) ? (string) $r['name'] : '';
          $source = isset($r['source']) ? (string) $r['source'] : '';
          $date   = isset($r['date']) ? (string) $r['date'] : '';
          $text   = isset($r['text']) ? (string) $r['text'] : '';
          $rating = isset($r['rating']) ? (int) $r['rating'] : 0;
          $initial = $name !== '' ? strtoupper(mb_substr($name, 0, 1)) : '?';
          ?>
        <article class="group relative rounded-2xl border border-white/15 bg-white/5 p-6 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:bg-white/[0.08]">
          <div class="mb-4 flex items-center gap-2" aria-label="<?php echo esc_attr($rating); ?> <?php esc_attr_e('out of 5 stars', 'escape-room'); ?>">
            <?php for ($i = 1; $i <= 5; $i++) : ?>
              <svg class="h-5 w-5 <?php echo $i <= $rating ? 'opacity-100' : 'opacity-30'; ?>"
                   viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M10 2.5l2.472 4.997 5.51.803-3.99 3.89.942 5.49L10 14.97 5.066 17.68l.942-5.49L2.02 8.3l5.51-.803L10 2.5z"/>
              </svg>
            <?php endfor; ?>
            <span class="sr-only"><?php echo esc_html($rating); ?> <?php esc_html_e('out of 5 stars', 'escape-room'); ?></span>
          </div>

          <p class="text-sm leading-relaxed opacity-90">“<?php echo esc_html($text); ?>”</p>

          <footer class="mt-6 flex items-center justify-between text-xs opacity-80">
            <div class="flex items-center gap-2">
              <div class="grid h-6 w-6 place-items-center rounded-full border border-white/20 text-[10px]">
                <?php echo esc_html($initial); ?>
              </div>
              <span><?php echo esc_html($name); ?></span>
            </div>
            <div class="text-right">
              <?php if ($source) : ?>
                <span class="block"><?php echo esc_html($source); ?></span>
              <?php endif; ?>
              <?php if ($date) :
                  $dt_attr = esc_attr(date('Y-m', strtotime($date . ' 1')));
                  ?>
                <time datetime="<?php echo $dt_attr; ?>"><?php echo esc_html($date); ?></time>
              <?php endif; ?>
            </div>
          </footer>

          <div class="pointer-events-none absolute inset-0 rounded-2xl ring-1 ring-inset ring-white/10 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if ($more_url) : ?>
      <div class="mt-8 md:hidden">
        <a href="<?php echo esc_url($more_url); ?>" class="inline-block text-sm uppercase tracking-wider opacity-70 hover:opacity-100">
          <?php esc_html_e('Read more reviews →', 'escape-room'); ?>
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>
