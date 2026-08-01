# Repository Guidelines

## Project Structure

- `wp-restaurant-menu.php` is the plugin bootstrap and defines shared constants.
- `includes/` contains plugin initialization, widget registration, and Elementor widget classes. The main widget is `includes/widgets/class-restaurant-menu-widget.php`.
- `templates/restaurant-menu.php` renders the widget markup.
- `assets/css/restaurant-menu.css` and `assets/js/restaurant-menu.js` contain front-end styling and behavior.
- `languages/` is reserved for translations. `readme.txt` contains WordPress plugin metadata and installation notes.
- There is currently no automated test directory or build output.

## Development and Verification

This plugin is loaded directly by WordPress; no npm or compile step is required. From the plugin directory, run PHP syntax checks before testing:

```powershell
php -l wp-restaurant-menu.php
php -l includes/plugin.php
php -l includes/widgets/class-restaurant-menu-widget.php
php -l templates/restaurant-menu.php
```

For functional verification, activate the plugin in a local WordPress site with Elementor (and WooCommerce when product data is involved), add the Restaurant Menu widget, and check both editor controls and the front-end at desktop and mobile widths.

## Coding Style and Naming

Use PHP 7.4-compatible code, WordPress escaping and sanitization APIs, and tabs for PHP indentation to match the existing files. Keep the `WPRestaurantMenu` namespace and `WPRM_` constants. Use snake_case for PHP method/control keys and BEM-style `wprm-menu__...` classes for markup and CSS. Keep user-facing strings translatable with the `wp-restaurant-menu` text domain. Avoid unrelated refactors and preserve the existing Elementor control and template structure.

## Testing Guidelines

No PHPUnit or JavaScript test framework is configured. Every change should at minimum pass `php -l` for modified PHP files and a manual Elementor preview check. Test saved widget settings, empty states, links, stock/sold-out behavior, and responsive layout when those areas are affected.

## Commits and Pull Requests

The repository currently has only an `init` commit, so no established history convention exists. Use short, imperative commit subjects such as `Fix dynamic stock status`. Pull requests should explain the user-visible behavior, identify affected files, include reproduction or verification steps, and attach before/after screenshots for visual changes. Mention WordPress, Elementor, or WooCommerce version assumptions when relevant.

## Security and Configuration

Do not commit WordPress credentials, database exports, generated uploads, or environment-specific configuration. Preserve the plugin bootstrap guard against direct access, escape output at render time, and validate IDs and URLs before using external or user-controlled values.
