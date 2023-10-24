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

sudo cp -r ../gestor-de-emails-automatico /var/www/gestor-de-emails-automatico

if ! command -v composer &> /dev/null; then
    echo "instalando composer"
    sudo apt-get install composer
#    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
#    php composer-setup.php
#    sudo mv composer.phar /usr/local/bin/composer
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

cd /var/www/gestor-de-emails-automatico

cp .env.example .env

sudo sed -i "s/DB_DATABASE=.*/DB_DATABASE=gestor-de-emails-automatico/" .env
sudo sed -i "s/DB_USERNAME=.*/DB_USERNAME=$USUARIO_DB/" .env
sudo sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$SENHA_DB/" .env

echo "digite o nome que aparecera no cabeçalho do email:"
read NOMEENVIO

echo "digite o email para envio:"
read EMAILENVIO

echo "digite a senha do email:"
read -s SENHAENVIO


sudo sed -i "s/MAIL_HOST=.*/MAIL_HOST=smtp.gmail.com/" .env
sudo sed -i "s/MAIL_PORT=.*/MAIL_PORT=587/" .env
sudo sed -i "s/MAIL_USERNAME=.*/MAIL_USERNAME=$EMAILENVIO/" .env
sudo sed -i "s/MAIL_PASSWORD=.*/MAIL_PASSWORD=$SENHAENVIO/" .env
sudo sed -i "s/MAIL_ENCRYPTION=.*/MAIL_ENCRYPTION=tls/" .env
sudo sed -i "s/MAIL_FROM_ADDRESS=.*/MAIL_FROM_ADDRESS=$EMAILENVIO/" .env
sudo sed -i "s/MAIL_FROM_NAME=.*/MAIL_FROM_NAME=$NOMEENVIO/" .env


#talvez precise
#sudo find . -type d -exec chmod 755 {} \;
#sudo find . -type f -exec chmod 644 {} \;
#sudo chmod 755 ../gestor-de-emails-automatico/
#sudo chown -R root:root ../gestor-de-emails-automatico/


php artisan key:generate
php artisan migrate

#sudo mv /var/www/html /var/www/html_bck
#sudo ln -s public /var/www/html

###
#sudo nano /etc/apache2/sites-available/seuprojeto.conf
CONF="<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    ServerName gestor-de-emails-automatico
    DocumentRoot /var/www/gestor-de-emails-automatico/public

#    <Directory /var/www/gestor-de-emails-automatico/public>
#        Options Indexes FollowSymLinks
#        AllowOverride All
#        Require all granted
#    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>"
cd /etc/apache2/sites-available/
sudo echo "$CONF" >> gestoremails.conf
sudo a2ensite gestoremails.conf
#sudo a2dissite 000-default.conf
sudo systemctl restart apach2

IP_ADDRESS="127.0.0.1"
HOST_NAME="gestor-de-emails-automatico"
if ! grep -q "$HOST_NAME" /etc/hosts; then
    echo "$IP_ADDRESS   $HOST_NAME" | sudo tee -a /etc/hosts
else
    sudo sed -i "s/.*$HOST_NAME.*/$IP_ADDRESS   $HOST_NAME/g" /etc/hosts
fi
sudo systemctl restart apach2


#comando para inserir o comando no cron
#TEMPFILE="/tmp/crontab.tempfile"
#cp /etc/crontab "$TEMPFILE"
#echo "*  *   * * * root cd /var/www/gestor-de-emails-automatico && php artisan schedule:run >> dev/null 2>&1" >> "$TEMPFILE"
#sudo cp "$temp_file" /etc/crontab
#rm "$TEMPFILE"
#sudo service cron restart
