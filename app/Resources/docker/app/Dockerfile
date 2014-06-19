FROM debian:wheezy

MAINTAINER <<Me>>

ENV DEBIAN_FRONTEND noninteractive

RUN echo "Europe/Paris" > /etc/timezone; dpkg-reconfigure tzdata

RUN apt-get update
RUN apt-get upgrade -y

#######
# Php #
#######

RUN apt-get install -y php5-cli php5-intl php5-mysqlnd

##################
# Php - Composer #
##################

RUN apt-get install -y curl

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

###############
# Daemontools #
###############

RUN apt-get install -y daemontools
RUN mkdir /srv/services

CMD ["/usr/bin/svscan", "/srv/services"]

#############
# Php - Fpm #
#############

#RUN apt-get install -y php5-fpm

#ADD services/php5-fpm /srv/services/php5-fpm

#######
# Ssh #
#######

RUN apt-get install -y openssh-server
RUN mkdir /var/run/sshd
RUN echo 'root:root' |chpasswd

ADD services/sshd /srv/services/sshd

EXPOSE 22

#########
# Nginx #
#########

RUN apt-get install -y nginx
RUN echo "\ndaemon off;" >> /etc/nginx/nginx.conf

ADD services/nginx /srv/services/nginx

EXPOSE 80
