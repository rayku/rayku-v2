#!/bin/bash

sudo apt-get update
sudo apt-get install -yf --force-yes vim apache2 php5 php5-cli php5-curl php5-mysql php-pear php5-dev php-apc php5-mcrypt php5-gd python-software-properties git-core curl php5-mysql php5-intl mysql-client php5-xdebug
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password abc123'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password abc123'
sudo apt-get -y install mysql-server

if [ -d "/var/www" ]; then
    if [ -L "/var/www" ]; then
        sudo unlink /var/www
    else
        sudo rm -rf /var/www
    fi
fi
ln -s /var/rayku/web /var/www

if [ -d "/var/log/rayku" ]; then
    mkdir /var/log/rayku
fi
sudo chmod 777 /var/log/rayku

if [ -d "/tmp/cache/rayku" ]; then
    mkdir /tmp/cache/rayku
fi
sudo chmod 777 /tmp/cache/rayku

sudo curl -s https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
cd /var/rayku; COMPOSER_PROCESS_TIMEOUT=2400 composer -v update
cd /var/rayku; php app/console doctrine:database:create
cd /var/rayku; php app/console doctrine:schema:update --force