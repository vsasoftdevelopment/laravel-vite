# Laravel Vite

[![Latest Version on Packagist](https://img.shields.io/packagist/v/utterlabs/laravel-vite.svg?style=flat-square)](https://packagist.org/packages/utterlabs/laravel-vite)
[![Total Downloads](https://img.shields.io/packagist/dt/utterlabs/laravel-vite.svg?style=flat-square)](https://packagist.org/packages/utterlabs/laravel-vite)
![GitHub Actions](https://github.com/utterlabs/laravel-vite/actions/workflows/main.yml/badge.svg)

This simple package just prepares your project to used Vite instead of Webpack Mix.

## Installation

You can install the package via composer:

```bash
composer require utterlabs/laravel-vite
```

Then, update `package.json` and create `vite.config.js`:

```bash
php artisan vite:install
```

The default configuration expects your entry point to be `resources/js/app.js`. If you need to change that, first edit the
generated `vite.config.js` and then reference it in your Blade layout.

You have to reference the vite generated assets in your Blade layouts. Inside the `head` tag of your HTML, just add `@vite`. This is an example:

```php
<html>
<head>
...

@vite
</head>

...
</html>
```

If you changed the entrypoint in `vite.config.js`, you have to inform it in Blade as well:

```
@vite('resources/js/myscript.js')
```

## Usage

On development environment:

```bash
npm run dev
```

On production:

```bash
npm run prod
```

## Tips

### Refresh React components

If you're using React components you can install  add the following snippet in your `head` tag:

```html
<script type="module">
    import RefreshRuntime from "http://localhost:3000/@react-refresh";
    RefreshRuntime.injectIntoGlobalHook(window);
    window.\$RefreshReg$ = () => {};
    window.\$RefreshSig$ = () => (type) => type;
    window.__vite_plugin_react_preamble_installed__ = true;
</script>
```

You have to install the dependency as well:

```bash
npm i -D @vitejs/plugin-react-refresh
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email vanderlei@utterlabs.com instead of using the issue tracker.

## Credits

-   [Vanderlei Sbaraini Amancio](https://github.com/utterlabs)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
