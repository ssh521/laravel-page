<?php

namespace Ssh521\LaravelPage\Console\Commands;

use Illuminate\Console\Command;
use Ssh521\LaravelAdmin\Support\PackageInstaller;
use Ssh521\LaravelPage\Database\Seeders\LaravelPageAdminMenuSeeder;

class InstallCommand extends Command
{
    protected $signature = 'laravel-page:install
        {--force : Force database commands and overwrite update-safe published files}
        {--skip-migrate : Publish migrations without running them}
        {--skip-seed : Do not seed Laravel Page admin menus}
        {--publish-config : Publish Laravel Page config}
        {--publish-migrations : Publish Laravel Page migrations}
        {--publish-views : Publish Laravel Page views}
        {--publish-seeders : Publish Laravel Page seeders}
        {--force-config : Overwrite published Laravel Page config}
        {--force-views : Overwrite published Laravel Page views}
        {--force-seeders : Overwrite published Laravel Page seeders}';

    protected $description = 'Publish, migrate, and seed Laravel Page resources.';

    public function handle(): int
    {
        $this->info('Installing Laravel Page...');

        $this->publishResources();

        if (! $this->option('skip-migrate')) {
            $this->installer()->migrate($this, (bool) $this->option('force'));
        }

        if (! $this->option('skip-seed') && $this->canSeedAdminMenus()) {
            $this->installer()->seed($this, LaravelPageAdminMenuSeeder::class, (bool) $this->option('force'));
        }

        $this->newLine();
        $this->info('Laravel Page install complete.');

        return self::SUCCESS;
    }

    private function publishResources(): void
    {
        if ($this->option('publish-config') || $this->option('force-config')) {
            $this->installer()->publishTags($this, ['laravel-page-config'], (bool) $this->option('force-config'));
        }

        if ($this->option('publish-migrations')) {
            $this->installer()->publishTags($this, ['laravel-page-migrations']);
        }

        if ($this->option('publish-views') || $this->option('force-views')) {
            $this->installer()->publishTags($this, ['laravel-page-views'], (bool) $this->option('force-views'));
        }

        if ($this->option('publish-seeders') || $this->option('force-seeders')) {
            $this->installer()->publishTags($this, ['laravel-page-seeders'], (bool) $this->option('force-seeders'));
        }
    }

    private function canSeedAdminMenus(): bool
    {
        return $this->installer()->canSeedAdminMenus($this, 'Page');
    }

    private function installer(): PackageInstaller
    {
        return app(PackageInstaller::class);
    }
}
