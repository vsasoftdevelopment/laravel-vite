<?php

namespace Utterlabs\LaravelVite;

use Exception;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Http;

class LaravelVite
{
    public static function assets(string $entrypoint = ''): HtmlString
    {
        $entrypoint = preg_replace("/\'(.*)\'/", '$1', $entrypoint ?: "'resources/js/app.js'");

        $devServerIsRunning = false;

        if (app()->environment('local')) {
            try {
                Http::get("http://localhost:3000");
                $devServerIsRunning = true;
            } catch (Exception $e) {
            }
        }

        if ($devServerIsRunning) {
            return new HtmlString(<<<HTML
            <script type="module" src="http://localhost:3000/@vite/client"></script>
            <script type="module" src="http://localhost:3000/{$entrypoint}"></script>
        HTML);
        }

        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true, 512, JSON_THROW_ON_ERROR);

        return new HtmlString(<<<HTML
        <script type="module" src="/build/{$manifest[$entrypoint]['file']}"></script>
        <link rel="stylesheet" href="/build/{$manifest[$entrypoint]['css'][0]}">
    HTML);
    }
}
