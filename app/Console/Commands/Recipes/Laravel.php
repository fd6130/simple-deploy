<?php

namespace App\Console\Commands\Recipes;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class Laravel implements Recipes
{
    public function __construct(private array $config, private Command $command)
    {
    }

    public static function deploy(array $config, Command $command)
    {
        $instance = new self($config, $command);
        $phase1 = $instance->startDeploy();
        $phase2 = $phase1 ? $instance->finishDeploy() : false;
        $phase3 = $phase2 ? $instance->afterFinishDeploy() : false;

        $command->info('Deployment is done.');
    }

    public function startDeploy(): bool
    {
        $this->command->info('[Start Deploy] Executing now...');

        $shell = !empty($this->config['start_deploy']) ? $this->config['start_deploy'] : "git reset --hard; git fetch; git checkout {$this->config['branch']}; git pull origin {$this->config['branch']};";

        Process::timeout(180)->path($this->config['path'])->run($shell, function (string $type, string $output)
        {
            echo $output;
        })->throw();

        return true;
    }

    public function finishDeploy(): bool
    {
        $this->command->info('[Finish Deploy] Executing now...');

        $shell = !empty($this->config['finish_deploy']) ? $this->config['finish_deploy'] : "composer install --optimize-autoloader --no-dev; php artisan migrate --force; php artisan optimize:clear; php artisan optimize; sudo chown -R \$USER:www-data storage; sudo chown -R \$USER:www-data bootstrap/cache; sudo chmod -R 775 storage; sudo chmod -R 775 bootstrap/cache;";

        Process::timeout(180)->path($this->config['path'])->run($shell, function (string $type, string $output)
        {
            echo $output;
        })->throw();

        return true;
    }

    public function afterFinishDeploy(): bool
    {
        if (empty($this->config['after_finish_deploy'])) return false;

        $this->command->info('[After Finish Deploy] Executing now...');

        Process::timeout(180)->path($this->config['path'])->run($this->config['after_finish_deploy'], function (string $type, string $output)
        {
            echo $output;
        })->throw();

        return true;
    }
}
