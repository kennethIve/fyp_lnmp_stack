FROM php:7.2-fpm

RUN apt-get update && \
    apt-get install -y git zip unzip

RUN curl --silent --show-error https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mbstring pdo_mysql mysqli

RUN sed -ri 's/^www-data:x:82:82:/www-data:x:1000:50:/' /etc/passwd
ADD . /var/www
RUN chown -R www-data:www-data /var/www



