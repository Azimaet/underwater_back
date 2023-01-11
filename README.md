# Underwwwater API

[![Symfony](https://symfony.com/logos/symfony_black_02.svg)](https://symfony.com)

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

## Requirements

Underwwwater API uses somes requirements to work properly:

- Apache
- PHP - (version: > 8.1)
- MySQL
- PHPmyadmin
- Composer - https://getcomposer.org/download/
- Symfony CLI - https://symfony.com/download

## Installation

1/ Install dependencies:

```sh
composer install
```

2/ Configure your own .env file (.env.local) on root of project, to setup database, ports, and credentials:

```sh
cd /
touch .env.local
```

3/ (optionnal): Change allow-origin to authorize front-end to call Underwwwater API. (default to https://127.0.0.1/*)

```sh
nano config/packages/nelmio_cors_local.yaml
```

4/ Configure your own .env file (.env.local) to setup database, ports, and credentials. Then build database:

```sh
php bin/console doctrine:database:create
```

5/ Run doctrine migrations to schematize database up-to-date:

```sh
php bin/console doctrine:migrations:migrate
```

6/ Run fixtures to add one-way required datas (diving themes, roles and environments):

```sh
php bin/console doctrine:fixtures:load
```

7/ Gen keypair for JWT

```sh
php bin/console lexik:jwt:generate-keypair
```

8/ Run Project TLS on SSL

```sh
symfony server:ca:install
```

## Development

1/ Run project:

```sh
symfony serve
```

2/ Clear cache:

```sh
php bin/console cache:clear
```

3/ Create/Update entities resources:

```sh
php bin/console make:entity
php bin/console make:migration
php bin/console doctrine migrations:migrate
```
