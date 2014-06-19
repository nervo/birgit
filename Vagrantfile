# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.require_version ">= 1.6.3"

ENV['VAGRANT_DEFAULT_PROVIDER'] = 'docker'

Vagrant.configure('2') do |config|

    config.vm.define 'mysql' do |container|
        container.vm.provider 'docker' do |docker|
            docker.build_dir = 'app/Resources/docker/mysql'
            docker.name = 'mysql'
        end
    end

    config.vm.define 'app' do |container|
        container.vm.provider 'docker' do |docker, override|
            docker.build_dir = 'app/Resources/docker/app'
            docker.name = 'app'
            docker.has_ssh = true

            override.ssh.username = "root"
            override.ssh.password = "root"
        end

        #container.vm.synced_folder '.',
        #    '/var/www', type: 'rsync',
        #    rsync__exclude: '.git/'
    end

    #config.vm.synced_folder '.', '/var/www'

    #config.vm.provider 'docker' do |docker|
    #    docker.build_dir = 'app/Resources/docker'
    #    docker.ports << '8080:80'
    #    #docker.has_ssh = true
    #end

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
