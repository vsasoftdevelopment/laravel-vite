<?php declare(strict_types=1);

namespace Utterlabs\LaravelVite;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vite:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Vite';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->updatePackages();
        $this->removeWebpackMixFile();
        $this->removeNodeModules();
        $this->createViteConfig();

        $this->comment('Vite files installed. Please run "npm install" and "npm run dev"');
        $this->comment('Please update your blade files to include the assets compiled by vite');
    }

    protected function updatePackages()
    {
        if (! file_exists(base_path('package.json'))) {
            $this->warn('package.json does not exist');
            return;
        }

        $packages = json_decode(file_get_contents(base_path('package.json')), true, 512, JSON_THROW_ON_ERROR);

        $packages['scripts'] = [
            'dev' => 'concurrently -n "vite" -c "green" "vite --clearScreen false"',
            'prod' => 'vite build'
        ];

        $packages['devDependencies'] = $this->updatePackageArray(
            array_key_exists('devDependencies', $packages) ? $packages['devDependencies'] : [],
            'devDependencies'
        );

        ksort($packages['devDependencies']);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    protected function updatePackageArray(array $packages): array
    {
        return [
            'vite' => '^2.7.13',
            'postcss' => '^8.4.5',
            'postcss-import'=> '^14.0.1',
            'concurrently' => '^7.0.0',
        ] + $packages;
    }

    protected function createViteConfig(): void
    {
        copy(__DIR__.'/../stubs/vite.config.js', base_path('vite.config.js'));
    }

    protected function removeWebpackMixFile(): void
    {
        tap(new Filesystem(), static function ($files) {
            $files->delete(base_path('webpack.mix.js'));
        });
    }

    /**
     * Remove the installed Node modules.
     *
     * @return void
     */
    protected function removeNodeModules(): void
    {
        tap(new Filesystem(), static function ($files) {
            $files->deleteDirectory(base_path('node_modules'));

            $files->delete(base_path('yarn.lock'));
            $files->delete(base_path('package-lock.json'));
        });
    }
}
