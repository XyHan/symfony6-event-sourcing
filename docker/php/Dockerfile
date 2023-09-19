FROM php:8.2-apache

ENV COMPOSER_ALLOW_SUPERUSER=1

EXPOSE 80
WORKDIR /var/www/

RUN a2enmod rewrite

# git, unzip & zip are for composer
RUN apt-get update -qq && \
    apt-get install -qy \
    nano \
    git \
    gnupg \
    unzip \
    zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


RUN pecl install xdebug-3.2.2 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# PHP Extensions
RUN docker-php-ext-install -j$(nproc) opcache pdo_mysql
COPY conf/php.ini /usr/local/etc/php/conf.d/app.ini

# Apache
COPY errors /errors
COPY vhosts/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY vhosts/apache.conf /etc/apache2/conf-available/s6es-app.conf

CMD ["apache2-foreground"]

RUN a2enmod rewrite remoteip && \
    a2enconf s6es-app
