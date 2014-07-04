# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = '2'

options = {
    :name    => 'birgit',
    :memory  => 512,
    :box     => 'debian-7-amd64',
    :debug   => false
}

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    # Box
    config.vm.box = options[:box]
    config.vm.box_url = 'https://boxes.elao.com/boxes/' + options[:box] + '.box'

    # Hostname
    config.vm.hostname = options[:name] + '.dev'

    # Dns
    config.landrush.enabled = true
    config.landrush.tld = 'dev'
    config.landrush.guest_redirect_dns = false

    # Network
    config.vm.network 'private_network',
        type: 'dhcp'

    # Ssh
    config.ssh.forward_agent = true

    # Folders
    config.vm.synced_folder '.', '/var/www',
        type:           'rsync',
        rsync__exclude: '.git/'

    # Providers
    config.vm.provider :virtualbox do |vb|
        vb.name   = options[:name]
        vb.memory = options[:memory]
        vb.gui    = options[:debug]
        vb.customize ['modifyvm', :id, '--natdnshostresolver1', 'on']
    end

    # Git Config
    if File.exists?(File.join(Dir.home, '.gitconfig')) then
        config.vm.provision 'shell',
            inline: "echo -e \"#{File.read("#{Dir.home}/.gitconfig")}\" > /home/vagrant/.gitconfig"
    end

    # Cache
    if Vagrant.has_plugin?('vagrant-cachier')
        config.cache.scope = :box
    end

    # Provisioners
    config.vm.provision 'ansible' do |ansible|
        ansible.playbook   = 'app/Resources/ansible/playbook.yml'
        ansible.extra_vars = {
            user: 'vagrant',
            host: options[:name] + '.dev'
        }
        ansible.verbose    = options[:debug] ? 'vvvv' : false
    end

end
