# Tutorial for using the Symfony Messenger component

## Create a new project with dependency to Messenger

~~~bash
> symfony new messenger-tutorial
> symfony server:start
> composer require symfony/messenger
~~~

## Create a new controller

~~~bash
> composer req maker --dev
> composer req annotations
> symfony console make:controller OrderController
~~~

## Configure an async transport

- [Link to the documentation](https://symfony.com/doc/current/the-fast-track/de/18-async.html#going-async-for-real)

## Add persistence

~~~bash
> composer require symfony/orm-pack
> composer require --dev symfony/maker-bundle
~~~

## Create a new entity "Order"

~~~bash
> php bin/console make:entity
~~~

With the properties:
- name | string | 255 | not null
- status | string | 255 | not null

## Create the database + create migration

~~~bash
php bin/console doctrine:database:create
php bin/console make:migration
~~~