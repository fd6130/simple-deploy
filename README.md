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

Put all your project you wish to deploy in `app/project.yaml`.

```yaml
project1:
    type: "laravel|vue|nuxt"
    path: ""
    branch: ""

project2:
    type: "laravel|vue|nuxt"
    path: ""
    branch: ""
```

Full config:

```yaml
put_your_project_name_here:
    type: "laravel|vue|nuxt"
    path: ""
    branch: ""
    start_deploy: ""
    finish_deploy: ""
    after_finish_deploy: ""
```
