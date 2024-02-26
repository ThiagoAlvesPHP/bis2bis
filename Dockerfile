FROM php:8.1-apache
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /bis2bis
COPY . /var/www/html