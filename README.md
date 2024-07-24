# Currency exchange
## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. If not already done, install Make on [Linux](https://www.incredibuild.com/integrations/gnu-make), [macOs](https://formulae.brew.sh/formula/make), [Windows](https://gnuwin32.sourceforge.net/packages/make.htm)
3. Run `make setup` to configure the app
4. Run `make tests` to run tests prepared for the task's code and to check the app health
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Docker image information
I've used [Symfony Docker](https://github.com/dunglas/symfony-docker).
A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework,
with [FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com/) inside!

Settings are default. This is production settings. They are used to quickly develop the application and check its operation.
