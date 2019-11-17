<?php

namespace Substrakt\SEO;

/**
 * Creates a new instance of the SEO plugin.
 * @return void
 */
function init(): void
{
    require_once SEO_PLUGIN_PATH . 'views/meta-tags.php';
}
add_action('wp_head', '\Substrakt\SEO\init');

/**
 * Removes the Basetheme action to set up title-tag support.
 * @return void
 */
function removeTitleTag(): void
{
    remove_theme_support('title-tag');
}
add_action('after_setup_theme', '\Substrakt\SEO\removeTitleTag', 999);
