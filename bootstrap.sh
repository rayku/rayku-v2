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

if [ -f "/home/vagrant/.ssh/id_rsa" ]; then
	cp /var/rayku/id_rsa /home/vagrant/.ssh/
fi

if [ -d "/var/log/rayku" ]; then
    sudo mkdir /var/log/rayku
    sudo chmod 777 /var/log/rayku
fi

if [ -d "/tmp/cache/rayku" ]; then
    sudo mkdir /tmp/cache/rayku
    sudo chmod 777 /tmp/cache/rayku
fi

sudo cp /var/rayku/default /etc/apache2/sites-available
sudo a2enmod rewrite
sudo service apache2 restart

sudo curl -s https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
cd /var/rayku; COMPOSER_PROCESS_TIMEOUT=2400 composer -v update
cd /var/rayku; php app/console doctrine:database:create
#cd /var/rayku; php app/console assetic:dump --watch  &
if [ ! -f "~/dataimportdone" ]; then
	mysql -u root -pabc123 rayku_v2 < /var/rayku/rayku.dump.sql
	touch ~/dataimportdone
fi
cd /var/rayku; php app/console doctrine:schema:update --force
sudo gem install capifony