# php7-fpm/Dockerfile
FROM php:7-fpm
COPY php.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y \
    unzip \
    wget \
    zlib1g-dev \
    libicu-dev \
    g++

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql intl mysqli
RUN docker-php-ext-enable mysqli

WORKDIR /var/www/app
