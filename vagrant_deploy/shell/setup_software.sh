#!/bin/bash
#
apt-get update

apt-get -y purge apache2
apt-get -y install debconf-utils

debconf-set-selections <<< 'mysql-server mysql-server/root_password password 12344321'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password 12344321'

apt-get -y install mysql-server
apt-get -y install nginx
apt-get -y install php5-cli
apt-get -y install php5-common
apt-get -y install php5-cgi
apt-get -y install php5-fpm
apt-get -y install php5-curl
apt-get -y install php5-intl
apt-get -y install php5-gd
apt-get -y install php5-mysql
apt-get -y install php5-xdebug
apt-get -y autoremove
