<?php

use Roots\Acorn\Application;
use App\Helpers\SleipnirMetaTagger;
use App\Helpers\SleipnirWebpConverter;

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

// Add meta tags.
$metaTagger = new SleipnirMetaTagger();
add_action( 'wp_head', [$metaTagger, 'add_meta_tags']);


$webPConverter = new SleipnirWebpConverter();

// Convert images to WebP format on upload
add_filter('wp_handle_upload', [$webPConverter, 'convert_to_webp_on_upload']);

// Add filter for generating metadata for WebP files.
add_filter('wp_generate_attachment_metadata', [$webPConverter, 'update_webp_metadata'], 10, 2);
