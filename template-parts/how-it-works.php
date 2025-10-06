<?php
/**
 * How It Works section
 *
 * @package Escape_Room
 */

if (! defined('ABSPATH')) {
    exit;
}
?>

<section id="how-it-works" class="relative w-full bg-black text-white">
  <div class="mx-auto max-w-7xl px-6 py-16 md:py-24">
    <header class="mb-12 md:mb-16 text-center">
      <h2 class="text-3xl md:text-5xl font-thin tracking-wide uppercase">How it works</h2>
      <p class="mt-4 text-sm md:text-base opacity-80">Simple steps from booking to breaking free.</p>
    </header>

    <ol class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 md:gap-12 items-start">
      <li>
        <h3 class="text-xl md:text-2xl font-light">Book your room online</h3>
        <p class="mt-3 text-sm opacity-80">
          Pick a theme, select your time slot and pay securely to confirm your reservation.
        </p>
      </li>

      <li>
        <h3 class="text-xl md:text-2xl font-light">Arrive 10 minutes early</h3>
        <p class="mt-3 text-sm opacity-80">
          Meet your game master, store belongings, and get a quick safety and rules briefing.
        </p>
      </li>

      <li>
        <h3 class="text-xl md:text-2xl font-light">60 minutes to escape</h3>
        <p class="mt-3 text-sm opacity-80">
          Search for clues, solve puzzles, and unlock mechanisms. Hints are available if you get stuck.
        </p>
      </li>

      <li>
        <h3 class="text-xl md:text-2xl font-light">Debrief &amp; victory photo</h3>
        <p class="mt-3 text-sm opacity-80">
          Celebrate your time and take a team photo to remember it.
        </p>
      </li>
    </ol>

    <a
  href="#"
  data-scroll-target="#how-it-works"
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
    <span class="cta-label inline-block [transform:skew(1deg,25deg)] text-white font-light tracking-[0.30em] text-[10px] uppercase">
      Book now
    </span>
  </span>
</a>
  </div>
</section>

<?php
// Basic HowTo schema for SEO
$howto = [
  '@context' => 'https://schema.org',
  '@type'    => 'HowTo',
  'name'     => 'How an escape room works',
  'description' => 'Steps to book and play an escape room at Let Me Out in Brussels.',
  'step' => [
    ['@type' => 'HowToStep', 'name' => 'Book your room online', 'text' => 'Choose a room, select a time, and pay securely to confirm.'],
    ['@type' => 'HowToStep', 'name' => 'Arrive 10 minutes early', 'text' => 'Meet your game master and get a short briefing.'],
    ['@type' => 'HowToStep', 'name' => '60 minutes to escape', 'text' => 'Solve puzzles and unlock mechanisms with optional hints.'],
    ['@type' => 'HowToStep', 'name' => 'Debrief & photo', 'text' => 'Celebrate, review alternative paths, and take a team photo.'],
  ],
];
?>
<script type="application/ld+json">
<?php echo wp_json_encode($howto, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>
</script>
