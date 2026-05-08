FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data storage bootstrap/cache

COPY docker/render/nginx.conf /etc/nginx/sites-enabled/default
COPY docker/render/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 10000

CMD ["/usr/bin/supervisord"]
