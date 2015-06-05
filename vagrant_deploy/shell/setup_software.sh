#!/bin/bash
#
apt-get update

apt-get -y purge apache2
apt-get -y install debconf-utils

debconf-set-selections <<< 'mysql-server mysql-server/root_password password 12344321'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password 12344321'

apt-get -y install mysql-server=5.5.43-0+deb8u1
apt-get -y install nginx=1.6.2-5
apt-get -y install php5-cli=5.6.9+dfsg-0+deb8u1
apt-get -y install php5-common=5.6.9+dfsg-0+deb8u1
apt-get -y install php5-cgi=5.6.9+dfsg-0+deb8u1
apt-get -y install php5-fpm=5.6.9+dfsg-0+deb8u1
apt-get -y install php5-curl=5.6.9+dfsg-0+deb8u1
apt-get -y install php5-intl=5.6.9+dfsg-0+deb8u1
apt-get -y install php5-gd=5.6.9+dfsg-0+deb8u1
apt-get -y install php5-mysql=5.6.9+dfsg-0+deb8u1
apt-get -y install php5-xdebug=2.2.5-1
apt-get -y autoremove
