FROM php:8.3-cli

WORKDIR /app

RUN apt-get update && apt-get install -y libzip-dev unzip curl git \
    && docker-php-ext-install pdo_mysql zip \
    && pecl install redis-6.0.2 \
    && docker-php-ext-enable redis

COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

CMD ["php", "index.php"]
