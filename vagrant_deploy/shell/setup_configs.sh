#!/bin/bash
#
rm /etc/php5/fpm/php.ini
rm /etc/php5/fpm/pool.d/www.conf
rm /etc/mysql/my.cnf

# Nginx
ln -s /home/vagrant/configs/nginx/vhost_site /etc/nginx/sites-enabled/

# PHP
ln -s /home/vagrant/configs/php/php.ini /etc/php5/fpm/
ln -s /home/vagrant/configs/php/www.conf /etc/php5/fpm/pool.d/

#Mysql
ln -s /home/vagrant/configs/mysql/my.cnf /etc/mysql/

#SSH additional keys
cat /home/vagrant/configs/pub_keys/key.pub >> /home/vagrant/.ssh/authorized_keys