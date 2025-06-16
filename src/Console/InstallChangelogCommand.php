<?php

namespace Combizera\Changelog\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallChangelogCommand extends Command
{
    protected $signature = 'changelog:install';
    protected $description = 'Install changelog system';

    public function handle()
    {
        $this->info('Installing Changelog package...');

        $this->createModel();
        $this->createMigration();

        $this->info('✅ Changelog package installed successfully!');
        return Command::SUCCESS;
    }

    private function createModel()
    {
        $modelPath = app_path('Models/Changelog.php');

        if (!File::exists($modelPath)) {
            File::ensureDirectoryExists(dirname($modelPath));
            File::copy(__DIR__ . '/../../stubs/Changelog.php', $modelPath);
            $this->info('📝 Model created: app/Models/Changelog.php');
        } else {
            $this->warn('⚠️  Model already exists: app/Models/Changelog.php');
        }
    }

    private function createMigration()
    {
        $timestamp = date('Y_m_d_His');
        $migrationPath = database_path("migrations/{$timestamp}_create_changelogs_table.php");

        if (!File::exists($migrationPath)) {
            File::ensureDirectoryExists(dirname($migrationPath));
            File::copy(__DIR__ . '/../../stubs/create_changelogs_table.php', $migrationPath);
            $this->info('📁 Migration created: database/migrations/' . basename($migrationPath));
        } else {
            $this->warn('⚠️  Migration already exists');
        }

        $this->call('migrate');
    }
}
