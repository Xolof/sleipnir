# Sleipnir

Lightweight Wordpress theme focusing on performance and accessibility.

Using Roots Sage as a foundation.

## Installation

Add the repository as a vcs repo in the repositories section of your composer.json.

```
{
  "type": "vcs",
  "url": "https://github.com/xolof/sleipnir"
}
```

Install the package.

`composer require xolof/sleipnir`

Go to the theme's directory. In Roots Bedrock it will be in `web/app/themes/sleipnir`.

`cd web/app/themes/sleipnir`

### Install the theme's dependencies.

#### For development:
`composer install`

`npm i` 

#### For production:
`composer install --no-dev --optimize-autoloader`

`npm install`

`npm run build`

`rm -rf node_modules`

### Activate the theme
Activate the theme in WordPress admin under Appearance >> Themes.

## Start dev server
From the theme's directory: 
`npm run dev`

## Changelog

### Version 0.0.3

#### Added

* Installation with Composer.

### Version 0.0.2

#### Added

* More styling.

### Version 0.0.1

#### Added

* Basic styling.
* Mobile menu.
* Metatags for SEO.
* Image conversion to WebP on upload.
* Disabling of dashicons on frontend.
* Removal of custom CSS section in admin.

