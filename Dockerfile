# Use an official Ubuntu as a base image
FROM php:8.0.5-apache

# Update OS and install common dev tools
RUN apt-get update
RUN apt-get install -y wget vim git zip unzip zlib1g-dev libzip-dev libpng-dev

RUN docker-php-ext-install mysqli pdo_mysql gd zip pcntl exif 
RUN docker-php-ext-enable mysqli

# Set the global ServerName to suppress the warning
RUN echo "ServerName 192.168.197.61:3000" >> /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod headers expires rewrite

# XDEBUG
#RUN pecl install xdebug
#RUN docker-php-ext-enable xdebug
# This needs in order to run xdebug from VSCode
#ENV PHP_IDE_CONFIG 'serverName=DockerApp'

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Expose port 80 for Apache
#EXPOSE 8000

# Set Apache and PHP to run on container startup
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]