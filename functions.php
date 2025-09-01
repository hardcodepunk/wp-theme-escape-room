<?php

/**
 * Escape Room functions and definitions
 *
 * @package Escape_Room
 */

if (! defined('ESCAPE_ROOM_VERSION')) {
    define('ESCAPE_ROOM_VERSION', '1.0.0');
}

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

function escape_room_content_width()
{
    $GLOBALS['content_width'] = apply_filters('escape_room_content_width', 640);
}
add_action('after_setup_theme', 'escape_room_content_width', 0);

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
 * Styles & scripts
 *
 * NOTE: Tailwind output is expected at /assets/css/app.css
 * Make sure your build writes there.
 */
function escape_room_scripts()
{

    // 1) Legacy theme stylesheet (load first)
    $theme_css_handle = 'escape-room-style';
    $theme_css_path   = get_stylesheet_directory() . '/style.css';
    wp_enqueue_style(
        $theme_css_handle,
        get_stylesheet_uri(),
        [],
        file_exists($theme_css_path) ? filemtime($theme_css_path) : ESCAPE_ROOM_VERSION
    );
    wp_style_add_data($theme_css_handle, 'rtl', 'replace');

    // 2) Tailwind build (load AFTER legacy so utilities win)
    $tw_rel  = '/assets/css/app.css';
    $tw_abs  = get_template_directory() . $tw_rel;
    if (file_exists($tw_abs)) {
        wp_enqueue_style(
            'escape-room-tailwind',
            get_template_directory_uri() . $tw_rel,
            [ $theme_css_handle ],                       // ensure order
            filemtime($tw_abs)
        );
    }

    // JS
    wp_enqueue_script(
        'escape-room-navigation',
        get_template_directory_uri() . '/js/navigation.js',
        [],
        ESCAPE_ROOM_VERSION,
        true
    );

    wp_enqueue_script(
        'escape-room-app',
        get_template_directory_uri() . '/js/app.js',
        [],
        ESCAPE_ROOM_VERSION,
        true
    );

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
