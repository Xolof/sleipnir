<?php

use Roots\Acorn\Application;

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (! file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

Application::configure()
    ->withProviders([
        App\Providers\ThemeServiceProvider::class,
    ])
    ->boot();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect(['setup', 'filters'])
    ->each(function ($file) {
        if (! locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                /* translators: %s is replaced with the relative file path */
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
            );
        }
    });


/*
|--------------------------------------------------------------------------
| Xolof's custom adaptations
|--------------------------------------------------------------------------
*/

/**
 * Remove Custom CSS section in admin.
 */
add_action("customize_register", function ($wp_customize)
{
	$wp_customize->remove_section("custom_css");
});

/** Remove dashicons */
add_action("wp_print_styles", "liberdev_deregister_styles", 100);

function liberdev_deregister_styles()
{
	if (!is_user_logged_in()) {
		wp_deregister_style("dashicons");
	}
}

/**
 * Make images in blocks lazy load.
 * Source: https://generate.support/topic/adding-lazy-loading-to-images-in-a-gb-query-loop/
 * Add the CSS class add-lazy-load to images that should be lazy loaded.
 */
add_filter("render_block", function ($block_content, $block) {
	if (!is_admin() && !empty($block["attrs"]["className"]) && strpos($block["attrs"]["className"], "add-lazy-load") !== false) {
		$myreplace = "<img";
		$myinsert = "<img loading='lazy' ";
		$block_content = str_replace($myreplace, $myinsert, $block_content);
	}

	return $block_content;
}, 10, 2);

/**
 * Function for adding meta tags.
 *
 * @return void
 */
function sleipnir_add_meta_tags(): void {
    global $post;

    function cleanup_text (string $text): string {
        $text = strip_tags($text);
        $text = strip_shortcodes($text);
        $text = trim($text);
        $text = str_replace("\n", '', $text);
        return $text;
    }

    if ( is_singular() ) {
        $post_description = cleanup_text($post->post_content);
        $post_description = substr($post_description, 0, 500);
        echo '<meta name="description" content="' . $post_description . '" />';
    }

    if ( is_home() ) {
        $blog_description = get_bloginfo('description');
        if ($blog_description) {
            $blog_description = cleanup_text($blog_description);
            echo '<meta name="description" content="' . $blog_description . '" />';
        }
    }

    if ( is_category() ) {
        $category_description = category_description();
        if ($category_description) {
            $category_description = cleanup_text($category_description);
            echo '<meta name="description" content="' . $category_description . '" />';
        }
    }
}

// Register the function for adding meta tags.
add_action( 'wp_head', 'sleipnir_add_meta_tags');
