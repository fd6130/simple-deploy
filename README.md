# Simple Deploy

## About

simple-deploy is a very simple deployment script written in Laravel Console.

> This tool will assume that your project already setup properly and running without issue in your server.

## Requirements

> We will assume that you already know how to setup a hosting environment and host your project in server.

-   PHP 8.2
-   DigitalOcean or AWS EC2 Linux OS (ex: ubuntu).
-   Some knowledge of Linux terminal command and usage.
-   Some knowledge of hosting a project in server.
-   Git
-   NodeJS
-   Yarn
-   PM2

## Configuration

Full config:

```yaml
put_your_project_name_here:
    # (optional) laravel, vue, nuxt
    recipe:
    # your project path
    path:
    # github branch
    branch:
    # override the command in recipe (if using recipe).
    start_deploy:
    finish_deploy:
    after_finish_deploy:
    # switch to specific node version (ex: 20) using nvm
    nvm_use:
    # pm2 instance name
    pm2_reload:
```

Put all your project you wish to deploy under `project.yaml` in this repository root folder.

```yaml
project1:
    path: ""
    branch: ""
    start_deploy: ""
    finish_deploy: ""

project2:
    path: ""
    branch: ""
    start_deploy: ""
    finish_deploy: ""
```

## Usage

Clone this repository into your server and then execute this command in the repository:

`php artisan app:deploy`

> You may use our recipe for quick start to do some deployment.

### Laravel

```yaml
put_your_project_name_here:
    recipe: "laravel"
    path:
    branch:
```

### Vue

> Your vue build files will be copied to '<your project folder>/public_html'.

```yaml
put_your_project_name_here:
    recipe: "vue"
    path:
    branch:
    nvm_use:
```

### Nuxt

> We will assume that your nuxt instance is already setup in PM2.

```yaml
put_your_project_name_here:
    recipe: "nuxt"
    path:
    branch:
    nvm_use:
    pm2_reload:
```
