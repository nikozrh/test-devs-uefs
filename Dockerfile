# Build stage: Using Composer image to install dependencies
FROM composer:2.6 AS builder

WORKDIR /app

# Copy the full application source into the container
COPY . .

# Install PHP dependencies using Composer (optimized for production)
# Set proper permissions for Laravel's storage and cache directories
RUN mkdir -p /app/docker && \
    composer install \
        --no-dev \
        --no-interaction \
        --no-plugins \
        --no-scripts \
        --no-progress \
        --optimize-autoloader \
        --ignore-platform-reqs && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Production stage: PHP 8.3 with Alpine Linux (lightweight and secure)
FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

# Install necessary dependencies:
# 1. .build-deps for compiling PHP extensions
# 2. runtime packages for nginx, supervisor, Redis, PostgreSQL, etc.
RUN apk add --no-cache --virtual .build-deps \
        autoconf g++ make \
    && apk add --no-cache \
        nginx supervisor \
        libpng libjpeg-turbo libzip libpq redis \
        libpng-dev libjpeg-turbo-dev libzip-dev freetype-dev oniguruma-dev postgresql-dev \
    # Install and enable Redis extension
    && pecl install redis \
    && docker-php-ext-enable redis \
    # Configure and install GD extension (for image handling)
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo pdo_pgsql zip mbstring gd opcache \
    # Remove build dependencies to reduce image size
    && apk del .build-deps \
    # Also clean up header dev packages that are no longer needed
    && apk del \
        libpng-dev libjpeg-turbo-dev libzip-dev freetype-dev oniguruma-dev postgresql-dev

# Configure PHP Opcache for better performance
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    echo -e "opcache.enable=1\n\
opcache.memory_consumption=128\n\
opcache.interned_strings_buffer=8\n\
opcache.max_accelerated_files=4000\n\
opcache.revalidate_freq=60\n\
opcache.fast_shutdown=1" >> "$PHP_INI_DIR/conf.d/opcache.ini"

# Create necessary directories for Nginx and Supervisor
RUN mkdir -p /etc/nginx/conf.d /var/log/nginx /run/nginx /var/log/supervisor

# Copy configuration files for Supervisor and Nginx
COPY docker/supervisor.conf /etc/supervisor/conf.d/supervisor.conf
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/vhost.conf /etc/nginx/conf.d/default.conf

# Copy built application from the builder stage
COPY --from=builder /app .

# Set proper permissions for Laravel to operate correctly
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage bootstrap/cache

# Copy startup script and make it executable
COPY docker/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Expose HTTP port
EXPOSE 80

# Define the default command to start services
CMD ["/usr/local/bin/startup.sh"]
