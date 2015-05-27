# vagrant package --output some_new_box_name.box --base vagrant-MyMachine
# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu_test_server"
  config.vm.hostname = "www.dev"
  config.vm.box_url = "/home/vkrasikov/DISTRIB/vagrant-boxes/ubuntu_test_server.box"
  config.vm.network "private_network", ip: "192.168.33.11"

  config.vm.synced_folder "./", "/home/vagrant/www/mysite.dev", :mount_options => ['dmode=777', 'fmode=777']
  config.vm.provision "shell", inline: <<-SHELL
     sudo service nginx restart
  SHELL

end
