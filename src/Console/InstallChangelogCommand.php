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
        $this->createController();
        $this->createView();
        $this->addRoute();

        $this->info('✅ Changelog package installed successfully!');
        $this->info('🔧 Run "php artisan migrate" to create the database table');
        $this->info('🌐 Access your changelog at: /changelog');
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
            $this->warn('⚠️ Model already exists: app/Models/Changelog.php');
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
            $this->warn('⚠️ Migration already exists');
        }
    }

    private function createController()
    {
        $controllerPath = app_path('Http/Controllers/ChangelogController.php');

        if (!File::exists($controllerPath)) {
            File::ensureDirectoryExists(dirname($controllerPath));
            File::copy(__DIR__ . '/../../stubs/ChangelogController.php', $controllerPath);
            $this->info('🎮 Controller created: app/Http/Controllers/ChangelogController.php');
        } else {
            $this->warn('⚠️ Controller already exists: app/Http/Controllers/ChangelogController.php');
        }
    }

    private function createView()
    {
        $viewPath = resource_path('views/changelog.blade.php');

        if (!File::exists($viewPath)) {
            File::ensureDirectoryExists(dirname($viewPath));
            File::copy(__DIR__ . '/../../stubs/changelog.blade.php', $viewPath);
            $this->info('👁️ View created: resources/views/changelog.blade.php');
        } else {
            $this->warn('⚠️ View already exists: resources/views/changelog.blade.php');
        }
    }

    private function addRoute()
    {
        $routesPath = base_path('routes/web.php');
        $routeContent = "\n// Changelog route\nRoute::get('/changelog', [App\\Http\\Controllers\\ChangelogController::class, 'index'])->name('changelog.index');\n";

        if (File::exists($routesPath)) {
            $currentContent = File::get($routesPath);

            if (!str_contains($currentContent, 'changelog')) {
                File::append($routesPath, $routeContent);
                $this->info('🛣️ Route added to routes/web.php');
            } else {
                $this->warn('⚠️ Route already exists in routes/web.php');
            }
        }
    }
}
