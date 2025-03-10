FROM php:8.3-fpm

# Instalar dependências e ferramentas adicionais
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libmariadb-dev-compat \
    libmariadb-dev \
    unzip \
    curl \
    git \
    zip \
    # Instalar o netcat para aguardar a conexão com o banco de dados
    netcat-openbsd \
    && docker-php-ext-configure mysqli --with-mysqli \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar os arquivos do projeto para dentro do container
COPY . /var/www

# Definir o diretório de trabalho
WORKDIR /var/www
