FROM php:7.2-apache

#Install XDEBUG
RUN pecl install xdebug-3.1.5 && docker-php-ext-enable xdebug

# Use the default development configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
