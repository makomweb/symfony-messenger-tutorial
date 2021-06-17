# Tutorial for using the Symfony Messenger component

![image](sequence-diagram-handle-order.png)

## Steps

### 1. Clone the repo

~~~bash
> git clone git@github.com:makomweb/symfony-messenger-tutorial.git
~~~

### 2. Composer install

~~~bash
> cd <symfony-messenger-tutorial>
> composer install
~~~

### 3. Set up the database

~~~bash
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
~~~

### 4. Start RabbitMQ via docker

~~~bash
> docker-composer up -d
~~~

### 5. Start Symfony Development Server

~~~bash
> symfony server:start -d
~~~

### 6. Start the message consumer

~~~bash
> php bin/console messenger:consume async -vv
~~~

### 7. Access the app 

Your app is runnint locally under [https://127.0.0.1:8000](https://127.0.0.1:8000)

### 8. Access the RabbitMQ admin console 

Your app is runnint locally under [http://guest:guest@127.0.0.1:15672](http://guest:guest@127.0.0.1:15672)

# Learnings

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

## Create the database + create migration + run migration

~~~bash
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
~~~

## Show orders

~~~bash
# to install TWIG view rendering engine
> composer require twig 
~~~

## Consume message asynchronously

`symfony console messenger:consume async -vv`

## Add RabbitMQ

RabbitMQ is part of the docker-compose inside this repo.

You can start a docker container with `docker-compose up -d`.

After the container is up you can access the webfrontend via
http://guest:guest@localhost:15672.

---

# Fileupload

- [File upload](https://symfony.com/doc/current/controller/upload_file.html)
- [CSRF](https://symfony.com/doc/current/security/csrf.html)
