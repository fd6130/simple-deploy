<?php

namespace App\Console\Commands\Recipes;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class Nuxt implements Recipes
{
    public function __construct(private array $config, private Command $command)
    {
    }

    public static function deploy(array $config, Command $command)
    {
        $instance = new self($config, $command);
        $instance->startDeploy();
        $instance->finishDeploy();
        $instance->afterFinishDeploy();

        $command->info('Deployment is done.');
    }

    public function startDeploy()
    {
        $this->command->info('[Start Deploy] Executing now...');

        $shell = !empty($this->config['start_deploy']) ? $this->config['start_deploy'] : "git fetch; git checkout {$this->config['branch']}; git pull origin {$this->config['branch']};";

        Process::path($this->config['path'])->run($shell, function (string $type, string $output)
        {
            echo $output;
        })->throw();
    }

    public function finishDeploy()
    {
        $this->command->info('[Finish Deploy] Executing now...');

        $shell = !empty($this->config['finish_deploy']) ? $this->config['finish_deploy'] : "export NODE_OPTIONS=--max-old-space-size=4096; yarn install; yarn build; mkdir -p public_html; cp -r dist/. public_html;";

        Process::path($this->config['path'])->run($shell, function (string $type, string $output)
        {
            echo $output;
        })->throw();
    }

    public function afterFinishDeploy()
    {
        if (empty($this->config['after_finish_deploy'])) return;

        $this->command->info('[After Finish Deploy] Executing now...');

        Process::path($this->config['path'])->run($this->config['after_finish_deploy'], function (string $type, string $output)
        {
            echo $output;
        })->throw();
    }
}