FROM debian:wheezy

MAINTAINER <<Me>>

ENV DEBIAN_FRONTEND noninteractive

RUN echo "Europe/Paris" > /etc/timezone; dpkg-reconfigure tzdata

RUN apt-get update
RUN apt-get upgrade -y

###############
# Daemontools #
###############

RUN apt-get install -y daemontools
RUN mkdir /srv/services

CMD ["/usr/bin/svscan", "/srv/services"]

#########
# MySQL #
#########

RUN apt-get install -y mysql-server
RUN sed -i -e"s/^bind-address\s*=\s*127.0.0.1/bind-address = 0.0.0.0/" /etc/mysql/my.cnf

ADD services/mysql /srv/services/mysql

EXPOSE 3306
