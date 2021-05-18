<?php
namespace Inensus\KonexaBulkRegistration\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Inensus\KonexaBulkRegistration\Console\Commands\InstallPackage;
use Inensus\KonexaBulkRegistration\Console\Commands\UpdatePackage;
use Inensus\KonexaBulkRegistration\Helpers\GeographicalLocationFinder;
use Inensus\KonexaBulkRegistration\Http\Controllers\ImportCsvController;
use Inensus\KonexaBulkRegistration\Services\ICreatorService;



class KonexaBulkRegistrationServiceProvider extends ServiceProvider
{
    public function boot(Filesystem $filesystem)
    {
        $this->app->register(RouteServiceProvider::class);
        if ($this->app->runningInConsole()) {
            $this->publishConfigFiles();
            $this->publishVueFiles();
            $this->publishMigrations($filesystem);
            $this->commands([InstallPackage::class,UpdatePackage::class]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/konexa-bulk-registration.php',
            'konexa-bulk-registration');
        $this->app->register(EventServiceProvider::class);
        $this->app->register(ObserverServiceProvider::class);
   /*     $this->app->bind(GeographicalLocationFinder::class,function($app){
            return
        });*/
    }

    public function publishConfigFiles()
    {
        $this->publishes([
            __DIR__ . '/../../config/konexa-bulk-registration.php' => config_path('konexa-bulk-registration.php'),
        ]);
    }

    public function publishVueFiles()
    {
        $this->publishes([
            __DIR__ . '/../resources/assets' => resource_path('assets/js/plugins/konexa-bulk-registration'
            ),
        ], 'vue-components');
    }

    public function publishMigrations($filesystem)
    {

            $this->publishes([
                __DIR__ . '/../../database/migrations/create_konexa_tables.php.stub'
                => $this->getMigrationFileName($filesystem),
            ], 'migrations');

    }

    protected function getMigrationFileName(Filesystem $filesystem): string
    {
        $timestamp = date('Y_m_d_His');
        return Collection::make($this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem) {
                if (count($filesystem->glob($path . '*_create_konexa_tables.php'))) {
                    $file = $filesystem->glob($path . '*_create_konexa_tables.php')[0];
                    file_put_contents($file,
                        file_get_contents(__DIR__ . '/../../database/migrations/create_konexa_tables.php.stub'));
                }
                return $filesystem->glob($path . '*_create_konexa_tables.php');
            })->push($this->app->databasePath() . "/migrations/{$timestamp}_create_konexa_tables.php")
            ->first();
    }
}