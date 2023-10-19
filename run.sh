#!/bin/bash

if ! command -v apache2 &> /dev/null; then
    echo "instalando lamp"
    sudo apt-get install lamp-server^
    sudo apt-get install php-xml php-curl php-pdo php-mbstring
    sudo apt-get install zip unzip php-zip
    #sudo chmod -R 777 /var/www

    sudo sed -i "s/;extension=fileinfo/extension=fileinfo/" /etc/php/8.1/cli/php.ini
    sudo sed -i "s/;extension=fileinfo/extension=fileinfo/" /etc/php/8.1/apache2/php.ini

fi

if ! command -v composer &> /dev/null; then
    echo "instalando composer"
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php
    sudo mv composer.phar /usr/local/bin/composer
fi

composer install

USUARIO_DB="user_laravel"
SENHA_DB="sfgd645aerg1sb"

sudo mysql -u root <<EOF

USE mysql;
CREATE USER '$USUARIO_DB'@'localhost' IDENTIFIED BY '$SENHA_DB';
GRANT ALL PRIVILEGES ON *.* TO '$USUARIO_DB'@'localhost';
UPDATE user SET plugin='caching_sha2_password' WHERE user='$USUARIO_DB';
FLUSH PRIVILEGES;
exit
EOF

sudo systemctl restart mysql

cp .env.example .env

sed -i "s/DB_DATABASE=.*/DB_DATABASE=gestor-de-emails-automatico/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$USUARIO_DB/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$SENHA_DB/" .env

echo "digite o nome que aparecera no cabeçalho do email"
read NOMEENVIO

echo "digite o email para envio"
read EMAILENVIO

echo "digite a senha do email"
read SENHAENVIO


sed -i "s/MAIL_HOST=.*/MAIL_HOST=smtp.gmail.com/" .env
sed -i "s/MAIL_PORT=.*/MAIL_PORT=587/" .env
sed -i "s/MAIL_USERNAME=.*/MAIL_USERNAME=$EMAILENVIO/" .env
sed -i "s/MAIL_PASSWORD=.*/MAIL_PASSWORD=$SENHAENVIO/" .env
sed -i "s/MAIL_ENCRYPTION=.*/MAIL_ENCRYPTION=tls/" .env
sed -i "s/MAIL_FROM_ADDRESS=.*/MAIL_FROM_ADDRESS=$EMAILENVIO/" .env
sed -i "s/MAIL_FROM_NAME=.*/MAIL_FROM_NAME=$NOMEENVIO/" .env


#talvez precise
#find * -type d -exec chmod 755 {} \;
#find * -type f -exec chmod 644 {} \;
#chmod 755 ../gestor-de-emails-automatico/

#isso nao funciona direito pelo visto vou ter que mover para a pasta do apache
#sudo ln -s ../gestor-de-emails-automatico /var/www/gestor-de-emails-automatico
sudo cp ../gestor-de-emails-automatico /var/www/

php artisan key:generate
php artisan migrate  #ta precisando rodar sudo

#comando para inserir o comando no cron

temp_file="/tmp/crontab.tempfile"
cp /etc/crontab "$temp_file"
echo "*  *   * * * root cd /var/www/gestor-de-emails-automatico && php artisan schedule:run >> dev/null 2>&1" >> "$temp_file"
sudo cp "$temp_file" /etc/crontab
rm "$temp_file"
sudo service cron restart
