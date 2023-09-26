#!/bin/bash

if ! command -v php &> /dev/null; then
    echo "instalando php"
    sudo apt install php php-xml php-curl php-pdo
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

sed -i "s/DB_DATABASE=.*/DB_DATABASE=gestor-de-emails-automatico/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=root/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=root/" .env
sed -i "s/MAIL_HOST=.*/MAIL_HOST=smtp.gmail.com/" .env
sed -i "s/MAIL_PORT=.*/MAIL_PORT=587/" .env
sed -i "s/MAIL_ENCRYPTION=.*/MAIL_ENCRYPTION=tls/" .env


#talve precise
#find * -type d -exec chmod 755 {} \;
#find * -type f -exec chmod 644 {} \;
#chmod 755 gestor-de-emails-automatico/
##reescrever o arquivo env

php artisan key:generate
php artisan migrate
php artisan serve
