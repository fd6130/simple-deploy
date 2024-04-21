<?php

namespace App\Console\Commands\Recipes;

interface Recipes
{
    /**
     * Perform the task when start deploying.
     *
     * Such as git pull latest branch, backup database, etc.
     *
     * @return void
     */
    public function startDeploy();

    /**
     * Perform the task when finish deploying.
     *
     * Such as composer install, npm run build, yarn build, clear cache, etc.
     *
     * @return void
     */
    public function finishDeploy();

    /**
     * Perform the task after finish deploying.
     *
     * Such as laravel command, restart laravel worker, clear cache, etc.
     *
     * @return void
     */
    public function afterFinishDeploy();
}
