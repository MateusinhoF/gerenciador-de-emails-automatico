#!/bin/bash

if ! command -v apache2 &> /dev/null; then
    echo "instalando lamp"
    sudo apt-get install lamp-server^
    sudo apt-get install php-xml php-curl php-pdo php-mbstring
    sudo apt-get install zip unzip php-zip
    #sudo chmod -R 777 /var/www

#    sudo sed -i "s/;extension=curl/extension=curl/" /etc/php/8.1/cli/php.ini
#    sudo sed -i "s/;extension=curl/extension=curl/" /etc/php/8.1/apache2/php.ini
#
#    sudo sed -i "s/;extension=pdo_mysql/extension=pdo_mysql/" /etc/php/8.1/cli/php.ini
#    sudo sed -i "s/;extension=pdo_mysql/extension=pdo_mysql/" /etc/php/8.1/apache2/php.ini
#
    sudo sed -i "s/;extension=fileinfo/extension=fileinfo/" /etc/php/8.1/cli/php.ini
    sudo sed -i "s/;extension=fileinfo/extension=fileinfo/" /etc/php/8.1/apache2/php.ini
#
#    sudo sed -i "s/;extension=mbstring/extension=mbstring/" /etc/php/8.1/cli/php.ini
#    sudo sed -i "s/;extension=mbstring/extension=mbstring/" /etc/php/8.1/apache2/php.ini
#
#    sudo sed -i "s/;extension=openssl/extension=openssl/" /etc/php/8.1/cli/php.ini
#    sudo sed -i "s/;extension=openssl/extension=openssl/" /etc/php/8.1/apache2/php.ini

fi

if ! command -v composer &> /dev/null; then
    echo "instalando composer"
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php
    sudo mv composer.phar /usr/local/bin/composer
fi

#if ! command -v npm &> /dev/null; then
#    echo "instalando npm"
#    sudo apt install npm
#fi

composer install
#npm install
cp .env.example .env

sed -i "s/DB_DATABASE=.*/DB_DATABASE=gestor-de-emails-automatico/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=root/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=root/" .env
sed -i "s/MAIL_HOST=.*/MAIL_HOST=smtp.gmail.com/" .env
sed -i "s/MAIL_PORT=.*/MAIL_PORT=587/" .env
sed -i "s/MAIL_ENCRYPTION=.*/MAIL_ENCRYPTION=tls/" .env


#talvez precise
find * -type d -exec chmod 755 {} \;
find * -type f -exec chmod 644 {} \;
chmod 755 gestor-de-emails-automatico/

sudo ln -s ../gestor-de-emails-automatico /var/www/gestor-de-emails-automatico

php artisan key:generate
php artisan migrate  #ta precisando rodar sudo

#comando para inserir o comando no cron
#php artisan serve

