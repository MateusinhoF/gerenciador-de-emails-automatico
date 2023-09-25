#!/bin/bash

if ! command -v php &> /dev/null; then
    echo "instalando php"
    sudo apt install php
fi

if ! command -v composer &> /dev/null; then
    echo "instalando composer"
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php
    sudo mv composer.phar /usr/local/bin/composer
fi

if ! command -v npm &> /dev/null; then
    echo "instalando npm"
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
