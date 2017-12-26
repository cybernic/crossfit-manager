Crossfit Manager
================

Crossfit Manager is a symfony project to control reservations of users in your Crossfit Box


## Quick start guide

1. Clone the repository

    ```bash
    git clone https://github.com/cybernic/crossfit-manager.git
    ```


2. Create a `.env` from the `.env.dist` file.

    ```bash
    cp .env.dist .env
    ```


3. Build/run containers and init DB

    ```bash
    $ cd docker
    $ docker-compose up -d
    $ docker-compose exec php composer update

    $ sf3 doctrine:database:create
    $ sf3 doctrine:schema:update --force
    $ sf3 doctrine:fixtures:load --no-interaction
    ```


4. Update your /etc/hosts file and add `crossfit.test`


5. Visit `crossfit.test` in your browser