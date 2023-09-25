#!/bin/bash

if which php > /dev/null; then
    sudo apt install php
fi

if which composer > /dev/null; then
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php
    sudo mv composer.phar /usr/local/bin/composer
fi

if which npm > /dev/null; then
    sudo apt install npm
fi

composer install
npm install
cp .env.example .env

#talve precise
#find * -type d -exec chmod 755 {} \;
#find * -type f -exec chmod 644 {} \;
#chmod 755 gestor-de-emails-automatico/
##reescrever o arquivo env

php artisan key:generate
php artisan migrate
php artisan serve
