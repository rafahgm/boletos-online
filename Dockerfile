FROM php:5.3-apache

#Install XDEBUG
# RUN pecl install xdebug-2.2.7 && docker-php-ext-enable xdebug

# Use the default development configuration
# RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
