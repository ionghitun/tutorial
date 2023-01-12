FROM php:8.1-fpm

SHELL [ "/bin/bash", "-l", "-c" ]

USER root

ARG USER_ID
ARG GROUP_ID

RUN userdel -f www-data
RUN if getent group www-data ; then groupdel www-data; fi
RUN groupadd -g ${GROUP_ID} www-data
RUN useradd -l -u ${USER_ID} -g www-data www-data
RUN chown -R www-data:www-data /var/www

RUN install -d -m 0755 -o www-data -g www-data /home/www-data
RUN chown -R www-data:www-data /home/www-data

RUN mkdir /var/log/supervisor
RUN chown -R www-data:www-data /var/log/supervisor
RUN touch /var/run/supervisord.pid
RUN touch /var/run/crond.pid
RUN chown -R www-data:www-data /var/run
RUN chown www-data:www-data /var/run/supervisord.pid /var/run/crond.pid

RUN apt-get update
RUN apt-get install -y nano git curl zip unzip zlib1g-dev libicu-dev g++ libxml2-dev supervisor default-mysql-client cron libmcrypt-dev openssh-client libzip-dev  \
    libmagickwand-dev imagemagick

RUN pecl update-channels

RUN export EDITOR="/usr/bin/nano"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install intl zip exif pcntl bcmath soap pdo_mysql gd sockets gettext

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN pecl install imagick

RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-configure intl

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN curl -sL https://deb.nodesource.com/setup_lts.x | bash -
RUN apt-get install -y nodejs
RUN npm update -g

ADD ./docker/php/crontab /etc/cron.d/tutorial-cron
RUN crontab -u www-data /etc/cron.d/tutorial-cron

RUN usermod -a -G crontab www-data
RUN chmod gu+s /usr/sbin/cron

RUN python3 -c "import socket as s; sock = s.socket(s.AF_UNIX); sock.bind('/dev/shm/supervisor.sock')"

USER www-data

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

WORKDIR /var/www
