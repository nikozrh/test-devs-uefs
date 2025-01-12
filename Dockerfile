# Etapa 1: Imagem base com PHP 8.1
FROM php:8.2-fpm


# Atualizar e instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libxml2-dev \
    libpq-dev \
    libmcrypt-dev \
    libonig-dev \
    && docker-php-ext-install \
    pdo_pgsql \
    mbstring \
    xml \
    && pecl install mcrypt && docker-php-ext-enable mcrypt

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto para o container
COPY . .

# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expor a porta 8000
EXPOSE 8000

# Comando padrão para iniciar o servidor
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

