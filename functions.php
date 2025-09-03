<?php

/**
 * Escape Room functions and definitions
 *
 * @package Escape_Room
 */

if (! defined('ESCAPE_ROOM_VERSION')) {
    define('ESCAPE_ROOM_VERSION', '1.0.0');
}

/**
 * Theme setup
 */
function escape_room_setup()
{
    load_theme_textdomain('escape-room', get_template_directory() . '/languages');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus([
        'primary' => esc_html__('Primary Menu', 'escape-room'),
    ]);

    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    add_theme_support(
        'custom-background',
        apply_filters(
            'escape_room_custom_background_args',
            [ 'default-color' => 'ffffff', 'default-image' => '' ]
        )
    );

    add_theme_support('customize-selective-refresh-widgets');

    add_theme_support('custom-logo', [
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ]);
}
add_action('after_setup_theme', 'escape_room_setup');

/**
 * Content width
 */
function escape_room_content_width()
{
    $GLOBALS['content_width'] = apply_filters('escape_room_content_width', 640);
}
add_action('after_setup_theme', 'escape_room_content_width', 0);

/**
 * Widgets
 */
function escape_room_widgets_init()
{
    register_sidebar([
        'name'          => esc_html__('Sidebar', 'escape-room'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'escape-room'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);
}
add_action('widgets_init', 'escape_room_widgets_init');

/**
 * Should we enqueue Rooms-specific JS?
 * Default: front page. Override via filter if needed.
 */
function escape_room_should_enqueue_rooms(): bool
{
    $should = is_front_page();

    return (bool) apply_filters('escape_room_should_enqueue_rooms', $should);
}

/**
 * Enqueue styles & scripts
 *
 * - Uses filemtime() for cache-busting (you’ll see ?ver=TIMESTAMP).
 * - Tailwind output expected at /assets/css/main.css.
 * - JS files live in /js (app.js, navigation.js, room.js).
 */
function escape_room_scripts()
{
    // Use stylesheet_* to support child themes too.
    $theme_dir = get_stylesheet_directory();
    $theme_uri = get_stylesheet_directory_uri();

    // Helper for versioning
    $ver = static function (string $abs, string $fallback = ESCAPE_ROOM_VERSION) {
        return file_exists($abs) ? filemtime($abs) : $fallback;
    };

    /** ---- CSS ---- */
    // Base theme stylesheet
    $style_abs = $theme_dir . '/style.css';
    wp_enqueue_style(
        'escape-room-style',
        get_stylesheet_uri(),
        [],
        $ver($style_abs)
    );
    wp_style_add_data('escape-room-style', 'rtl', 'replace');

    // Tailwind build (main.css)
    $tw_rel = '/assets/css/main.css';
    $tw_abs = $theme_dir . $tw_rel;

    if (file_exists($tw_abs)) {
        wp_enqueue_style(
            'escape-room-tailwind',
            $theme_uri . $tw_rel,
            [ 'escape-room-style' ],
            $ver($tw_abs)
        );
    }

    /** ---- JS ---- */
    // navigation.js
    $nav_rel = '/js/navigation.js';
    $nav_abs = $theme_dir . $nav_rel;

    if (file_exists($nav_abs)) {
        wp_enqueue_script(
            'escape-room-navigation',
            $theme_uri . $nav_rel,
            [],
            $ver($nav_abs),
            true
        );
    }

    // app.js
    $app_rel = '/js/app.js';
    $app_abs = $theme_dir . $app_rel;

    if (file_exists($app_abs)) {
        wp_enqueue_script(
            'escape-room-app',
            $theme_uri . $app_rel,
            [],
            $ver($app_abs),
            true
        );
    }

    // room.js (click-to-open for Rooms section)
    $rooms_rel = '/js/room.js'; // change if your file is named differently
    $rooms_abs = $theme_dir . $rooms_rel;

    if (file_exists($rooms_abs) && escape_room_should_enqueue_rooms()) {
        wp_enqueue_script(
            'escape-room-rooms',
            $theme_uri . $rooms_rel,
            [],
            $ver($rooms_abs),
            true
        );
    }

    // WP threaded comments
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'escape_room_scripts');

/** Partials */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';

if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}
