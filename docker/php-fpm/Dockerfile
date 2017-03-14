FROM php:7.1-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install zlib1g-dev git -y

RUN docker-php-ext-install pdo pdo_mysql zip

ENV user swen
ARG PUID=1000
ARG PGID=1000
RUN groupadd -g $PGID $user && \
    useradd -u $PUID -g $user -m $user

# Install phpunit globally
RUN curl -O -L https://phar.phpunit.de/phpunit.phar
RUN chmod +x phpunit.phar
RUN mv phpunit.phar /usr/local/bin/phpunit

USER $user

WORKDIR /var/www
