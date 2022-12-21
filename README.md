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

2/ Configure your own .env file (.env.local) to setup database, ports, and credentials. Then build database:
```sh
php bin/console doctrine:database:create
```

3/ Run doctrine migrations to schematize database up-to-date:
```sh
php bin/console doctrine:migrations:migrate
```

4/ Run fixtures to add one-way required datas (diving themes, roles and environments):
```sh
php bin/console doctrine:fixtures:load
```

## Development

1/ Run project:
```sh
symfony serve
```

