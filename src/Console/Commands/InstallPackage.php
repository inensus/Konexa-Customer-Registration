<?php

namespace Inensus\KonexaBulkRegistration\Console\Commands;

use Illuminate\Console\Command;
use Inensus\KonexaBulkRegistration\Services\MenuItemService;
use Inensus\KonexaBulkRegistration\Services\MeterTypeService;

class InstallPackage extends Command
{
    protected $signature = 'konexa-bulk-registration:install';
    protected $description = 'Install KonexaBulkRegistration Package';

    private $menuItemService;
    private $meterTypeService;
    public function __construct(MenuItemService $menuItemService,MeterTypeService $meterTypeService)
    {
        parent::__construct();
        $this->menuItemService = $menuItemService;
        $this->meterTypeService=$meterTypeService;
    }

    public function handle(): void
    {
        $this->info('Installing KonexaBulkRegistration Integration Package\n');
        $this->publishConfigurations();
        $this->publishMigrations();
        $this->createDatabaseTables();
        $this->publishVueFiles();
        $this->createPluginRecord();
        $this->meterTypeService->createDefaultMeterTypeIfDoesNotExistAny();
        $this->call('routes:generate');
        $this->createMenuItems();
        $this->call('sidebar:generate');
        $this->info('Package installed successfully..');
    }

    private function publishConfigurations()
    {
        $this->info('Copying configurations\n');
        $this->call('vendor:publish', [
            '--provider' => "Inensus\KonexaBulkRegistration\Providers\KonexaBulkRegistrationServiceProvider",
            '--tag' => "configurations",
        ]);
    }
    private function publishMigrations()
    {
        $this->info('Copying migrations\n');
        $this->call('vendor:publish', [
            '--provider' => "Inensus\KonexaBulkRegistration\Providers\KonexaBulkRegistrationServiceProvider",
            '--tag' => "migrations",
        ]);
    }

    private function createDatabaseTables()
    {
        $this->info('Creating database tables\n');
        $this->call('migrate');
    }

    private function publishVueFiles()
    {
        $this->info('Copying vue files\n');

        $this->call('vendor:publish', [
            '--provider' => "Inensus\KonexaBulkRegistration\Providers\KonexaBulkRegistrationServiceProvider",
            '--tag' => "vue-components",
            '--force' => true
        ]);
    }

    private function createPluginRecord()
    {
        $this->call('plugin:add', [
            'name' => "KonexaBulkRegistration",
            'composer_name' => "inensus/konexa-bulk-registration",
            'description' => "KonexaBulkRegistration integration package for MicroPowerManager",
        ]);

    }

    private function createMenuItems()
    {
        $menuItems = $this->menuItemService->createMenuItems();
        $this->call('menu-items:generate', [
            'menuItem' => $menuItems['menuItem'],
            'subMenuItems' => $menuItems['subMenuItems'],
        ]);
    }
}