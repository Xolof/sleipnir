# Sleipnir

Lightweight Wordpress theme focusing on performance and accessibility.

Using Roots Sage as a foundation.

## Before deploy

Before deploying you should:

1. Build the JS:

`npm run build`

2. Install Composer dependencies for production:

`composer install --no-dev  --optimize-autoloader`

3. Remove node_modules:

`rm -rf node_modules`

Then upload this directory to your Wordpress themes directory.

## Changelog

### Version 0.0.1

#### Added

* Basic styling.
* Mobile menu.
* Metatags for SEO.
* Image conversion to WebP on upload.
* Disabling of dashicons on frontend.
* Removal of custom CSS section in admin.

## Todo
* Make it possible to install the theme with Composer.

