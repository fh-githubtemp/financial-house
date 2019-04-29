FROM ubuntu:18.04

ENV COMPOSER_DISABLE_XDEBUG_WARN=1
ENV COMPOSER_NO_INTERACTION=1
ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update -y \
    && apt-get upgrade -y \
    && apt-get install -y \
    php php-fpm php-zip php-xmlwriter \
    php-mysql php-json php-curl \
    php-xml php-phar php-intl php-dom \
    php-xmlreader php-ctype php-opcache php-posix \
    php-mbstring php-gd php-igbinary php-bcmath \
    php-pdo php-tokenizer php-fileinfo php-xdebug \
    nginx supervisor curl git zip unzip vim \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /etc/nginx/conf.d/* \
    && mkdir /run/php \
    && curl -L -o /usr/local/bin/composer https://getcomposer.org/composer.phar \
    && chmod +x /usr/local/bin/composer && composer global require "hirak/prestissimo:^0.3"

COPY ./ /app

WORKDIR /app

COPY ./build/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./build/php/fpm/conf.d/ /etc/php/7.2/fpm/conf.d/
COPY ./build/php/fpm/pool.d/php-fpm-pool.conf /etc/php/7.2/fpm/pool.d/www.conf
COPY ./build/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN rm /etc/php/7.2/fpm/conf.d/20-xdebug.ini \
    && rm /etc/php/7.2/cli/conf.d/20-xdebug.ini

COPY ./build/php/fpm/conf.d /etc/php/7.2/fpm/conf.d
COPY ./build/php/fpm/conf.d /etc/php/7.2/cli/conf.d

RUN composer install \
                --prefer-dist \
                --no-autoloader \
                --no-scripts \
                --no-suggest \
                --no-ansi \
                --no-interaction &&\
   composer dump-autoload \
                --no-scripts \
                --optimize \
                --classmap-authoritative \
                --no-interaction &&\
    mkdir -p /app/storage/app/public &&\
    mkdir -p /app/storage/framework/cache &&\
    mkdir -p /app/storage/framework/sessions &&\
    mkdir -p /app/storage/framework/testing &&\
    mkdir -p /app/storage/framework/views &&\
    mkdir -p /app/storage/logs

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
