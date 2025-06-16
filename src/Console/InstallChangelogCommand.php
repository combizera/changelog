<?php

namespace Combizera\Changelog\Console;

use Illuminate\Console\Command;

class InstallChangelogCommand extends Command
{
    protected $signature = 'changelog:install';
    protected $description = 'Instala o sistema de changelog no projeto';

    public function handle()
    {
        try {
            $this->info('🚀 Testando Laravel Changelog...');

            // Verificar se a configuração está acessível
            if (config('changelog')) {
                $this->info('✅ OK - Configuração carregada com sucesso!');

                // Mostrar alguns dados da config para confirmar
                $title = config('changelog.page.title', 'N/A');
                $this->info("📝 Título configurado: {$title}");

                return Command::SUCCESS;
            } else {
                $this->error('❌ ERRO - Configuração não encontrada!');
                return Command::FAILURE;
            }

        } catch (\Exception $e) {
            $this->error('❌ ERRO - Exceção capturada: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
