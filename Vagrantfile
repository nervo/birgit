# -*- mode: ruby -*-
# vi: set ft=ruby :

ENV['VAGRANT_DEFAULT_PROVIDER'] = 'docker'

Vagrant.configure('2') do |config|

  config.vm.provider 'docker' do |docker|
    docker.build_dir = '.'
    docker.has_ssh = true
  end

  #config.vm.define 'app' do |app|
  #  app.vm.provider "docker" do |d|
  #    d.build_dir = "."
  #    d.link "db"
  #  end
  #end

  #config.vm.define 'mysql' do |container|
  #  container.vm.provider 'docker' do |docker|
  #    docker.image = 'tutum/mysql'
  #    #docker.image = 'mysql'
  #    docker.name = 'mysql'
  #  end
  #end

end