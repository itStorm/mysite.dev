# vagrant package --output some_new_box_name.box --base vagrant-MyMachine
# -*- mode: ruby -*-
# vi: set ft=ruby :
# ATTENTION!!! After vagrant up run on virtual machine:
#   cd /home/vagrant/www/;
#   composer global require "fxp/composer-asset-plugin:~1.0.1";
#   composer install;

Vagrant.configure(2) do |config|
  config.vm.box = "debian_web_server"
  config.vm.hostname = "www.dev"
  config.vm.box_url = "/home/vkrasikov/DISTRIB/vagrant-boxes/debian8.1.0-32.box"
  config.vm.network "private_network", ip: "192.168.88.11"

  config.vm.synced_folder "./", "/home/vagrant/www", :mount_options => ['dmode=777', 'fmode=777']

  # Provision
  config.vm.provision "file", source: "./vagrant_deploy/configs/", destination: "/home/vagrant/", run: "always"
  config.vm.provision "shell", path: "./vagrant_deploy/shell/setup_software.sh"
  config.vm.provision "shell", path: "./vagrant_deploy/shell/setup_configs.sh"
  config.vm.provision "shell", path: "./vagrant_deploy/shell/up_services.sh", run: "always"

end