# Use a imagem base do PHP
FROM php:8.3-fpm

# Instalar dependências do sistema operacional
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
    # Instalar o Node.js (necessário para o frontend)
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-configure mysqli --with-mysqli \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar os arquivos do projeto para dentro do container
COPY . /var/www

# Definir o diretório de trabalho
WORKDIR /var/www

# Instalar as dependências do frontend (npm)
WORKDIR /var/www/frontend-BlogSphere
RUN npm install

# Voltar para o diretório raiz do projeto
WORKDIR /var/www
