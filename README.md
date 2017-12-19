Crossfit Manager
================

Crossfit Manager is a symfony project to control users of your Crossfit Box


## Quick start guide

1. Clone the repository

    ```bash
    git clone https://github.com/cybernic/crossfit-manager.git
    ```


2. Build/run containers and init DB

    ```bash
    $ docker-compose up -d
    $ docker-compose exec php composer update

    $ sf3 doctrine:database:create
    $ sf3 doctrine:schema:update --force
    $ sf3 doctrine:fixtures:load --no-interaction
    ```


3. Update your /etc/hosts file and add `symfony.dev`


4. Visit `symfony.dev` in your browser