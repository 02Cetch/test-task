FROM php:8.3-fpm

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip \
    curl \
    libmagickwand-dev \
    libzip-dev \
    libpq-dev \
    libicu-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# install php extensions
RUN pecl install imagick redis \
    && docker-php-ext-enable imagick redis \
    && docker-php-ext-install -j$(nproc) opcache gd zip bcmath pdo_mysql mysqli pcntl intl

# install ext-http
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions http

# for composer cache
RUN mkdir -p /var/www/.composer

# install symfony console
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

ADD php.ini /usr/local/etc/php/php.ini
ADD php-fpm.conf /usr/local/etc/php-fpm.d/

WORKDIR /var/www/workdir

EXPOSE 9000

CMD ["php-fpm", "-F"]
