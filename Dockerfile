FROM php:8.4-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt update && \
    apt install -y $PHPIZE_DEPS && \
    pecl install pcov xdebug && \
    docker-php-ext-enable pcov xdebug

RUN echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
    echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
    echo "xdebug.client_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
