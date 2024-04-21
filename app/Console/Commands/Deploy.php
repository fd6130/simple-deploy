<?php

namespace App\Console\Commands;

use App\Console\Commands\Recipes\General;
use App\Console\Commands\Recipes\Laravel;
use App\Console\Commands\Recipes\Nuxt;
use App\Console\Commands\Recipes\Vue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Symfony\Component\Yaml\Yaml;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy your application inside server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $projects = collect(Yaml::parseFile(base_path('project.yaml')));

        $choice = select(
            label: 'Which project do you want to deploy?',
            options: $projects->keys(),
            hint: 'Make sure your project path is valid.'
        );

        $confirmChoice = confirm(
            label: "Are you sure you want to deploy '{$choice}'?",
            hint: 'Make sure your project path is valid.'
        );

        if (!$confirmChoice) return;

        $project = $projects->get($choice);

        if (!empty($project['recipe']))
        {
            match ($project['recipe'])
            {
                'laravel' => Laravel::deploy($project, $this),
                'vue' => Vue::deploy($project, $this),
                'nuxt' => Nuxt::deploy($project, $this),
                default => $this->error("Unknown project type '{$project['type']}'.")
            };
        }
        else
        {
            General::deploy($project, $this);
        }
    }
}
