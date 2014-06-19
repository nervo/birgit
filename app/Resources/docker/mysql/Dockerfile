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
	curl http://www.dotdeb.org/dotdeb.gpg | apt-key add -
RUN apt-get update

#########
# Runit #
#########

RUN apt-get install -y runit

CMD ["/usr/sbin/runsvdir-start"]

#########
# MySQL #
#########

RUN apt-get install -y mysql-server
RUN sed -i -e"s/^bind-address\s*=\s*127.0.0.1/bind-address = 0.0.0.0/" /etc/mysql/my.cnf

ADD service/mysql /etc/service/mysql

EXPOSE 3306
