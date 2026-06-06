FROM php:8.3-fpm-alpine

# Useful PHP extension installer image, copy binary into your container
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer /usr/bin/composer /usr/local/bin/

COPY docker/php/conf.d/php.ini /usr/local/etc/php/conf.d/php.ini

RUN apk add git

RUN set -eux; install-php-extensions xdebug;
RUN set -eux; install-php-extensions gd;
RUN set -eux; install-php-extensions intl;
RUN set -eux; install-php-extensions mysqli;
# pcntl for the phpunit.xml enforceTimeLimit="true" option
RUN set -eux; install-php-extensions pcntl;
