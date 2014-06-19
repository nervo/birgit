FROM debian:wheezy

MAINTAINER <<Me>>

ENV DEBIAN_FRONTEND noninteractive

RUN echo "Europe/Paris" > /etc/timezone; dpkg-reconfigure tzdata

RUN apt-get update
RUN apt-get upgrade -y

##########
# Base #
##########

RUN apt-get install -y curl

##########
# Dotdeb #
##########

RUN echo "deb http://packages.dotdeb.org wheezy all" >> /etc/apt/sources.list.d/dotdeb.org.list && \
    echo "deb-src http://packages.dotdeb.org wheezy all" >> /etc/apt/sources.list.d/dotdeb.org.list && \
    echo "deb http://packages.dotdeb.org wheezy-php55 all" >> /etc/apt/sources.list.d/dotdeb.org.list && \
    echo "deb-src http://packages.dotdeb.org wheezy-php55 all" >> /etc/apt/sources.list.d/dotdeb.org.list && \
    curl http://www.dotdeb.org/dotdeb.gpg | apt-key add -
RUN apt-get update

#######
# Php #
#######

RUN apt-get install -y php5-cli php5-intl php5-mysqlnd

##################
# Php - Composer #
##################

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

#########
# Runit #
#########

RUN apt-get install -y runit

CMD ["/usr/sbin/runsvdir-start"]

#######
# Ssh #
#######

RUN apt-get install -y openssh-server

RUN mkdir /var/run/sshd
RUN echo "root:root" | chpasswd

ADD service/sshd /etc/service/sshd

EXPOSE 22

#############
# Php - Fpm #
#############

#RUN apt-get install -y php5-fpm

#RUN echo "daemonize=no" > /etc/php5/fpm/pool.d/daemonize.conf
#RUN sed -e "s,127.0.0.1:9000,9000," -i /etc/php5/fpm/pool.d/www.conf

#ADD service/php5-fpm /etc/service/php5-fpm

#EXPOSE 9000

#########
# Nginx #
#########

RUN apt-get install -y nginx

RUN echo "\ndaemon off;" >> /etc/nginx/nginx.conf

ADD service/nginx /etc/service/nginx

EXPOSE 80
