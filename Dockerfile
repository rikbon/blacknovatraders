# Re-export the PHP container image for direct root builds
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    libzip-dev \
    libicu-dev \
    libmemcached-dev \
    libssl-dev \
    zlib1g-dev \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Install PECL extensions
RUN pecl install memcached-3.2.0 \
    && docker-php-ext-enable memcached

# Install PHP extensions
RUN docker-php-ext-install \
    bcmath \
    intl \
    mysqli \
    opcache \
    pdo_mysql \
    zip

# Copy Composer from official image
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copy custom php.ini
COPY docker/php/php.ini $PHP_INI_DIR/conf.d/99-bnt.ini

# Set working directory
WORKDIR /app

# Copy entrypoint script
COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["php-fpm"]
