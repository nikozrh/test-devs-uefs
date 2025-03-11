## Teste Técnico UEFS - Avansys/ACP Group
---

## Requisitos do Projeto
Desenvolva uma API em Laravel que inclua o CRUD para:
- Usuários
- Posts
- Tags

### Regras de Modelagem
- O usuário (users) possui diferentes postagens (posts).
- As postagens (posts) possuem várias palavras-chave (tags).

### Endpoints
Implemente os seguintes endpoints com operações CRUD para:
- Usuários
- Posts
- Tags

**Nota:** As rotas devem ser acessadas com o prefixo `/api`. Por exemplo: `/api/posts`  

---

## Estrutura do Projeto
O projeto é composto por duas pastas principais:
- `api-BlogSphere` - Contém a API desenvolvida em Laravel.
- `frontend-BlogSphere` - Contém o frontend desenvolvido em Vue.js.

Cada pasta possui um README específico explicando detalhadamente sua estrutura e funcionamento.

---

## Ambiente de Desenvolvimento com Docker
Para facilitar a execução e configuração do projeto, utilizamos Docker e Docker Compose.

### Tecnologias Utilizadas
- **Backend:** Laravel 11 (PHP 8.3)
- **Banco de Dados:** MySQL 8.0.33
- **Frontend:** Vue.js + Vite

### Instalação e Execução

**Requisitos:**
- Docker e Docker Compose instalados na máquina.

**Passos para rodar o projeto:**
1. Clone o repositório
2. No terminal, navegue até a raiz do projeto TEST-DEVS-UEFS e execute:
   ```sh
   docker compose up --build
   ```
3. Aguarde a inicialização dos containers.

---

## Serviços e Portas Utilizadas

| Serviço      | URL de Acesso                  | Porta |
|--------------|--------------------------------|------|
| API Backend | [http://localhost:8000](http://localhost:8000) | 8000 |
| Frontend    | [http://localhost:5173](http://localhost:5173) | 5173 |
| Swagger     | [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation) | 8000 |
| MySQL       | -                              | 3306 |

---

## Estrutura do Docker Compose
```yaml
version: "3.8"

services:
  # Backend (Laravel)
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: laravel-app
    ports:
      - "8000:8000"
    volumes:
      - ./api-BlogSphere:/var/www
    networks:
      - app-network
    depends_on:
      - mysql
    environment:
      DB_CONNECTION: mysql
      DB_HOST: mysql
      DB_PORT: 3306
      DB_DATABASE: blogSphore
      DB_USERNAME: user
      DB_PASSWORD: password
    command: >
      /bin/bash -c "
      while ! nc -z mysql 3306; do
        echo 'Aguardando o banco de dados...';
        sleep 1;
      done;
      php artisan migrate &&
      php artisan serve --host=0.0.0.0 --port=8000
      "

  # Banco de Dados (MySQL)
  mysql:
    image: mysql:8.0.33-oracle
    container_name: mysql-container
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: blogSphore
      MYSQL_USER: user
      MYSQL_PASSWORD: password
    ports:
      - "3306:3306"
    volumes:
      - mysql-data:/var/lib/mysql
    networks:
      - app-network

  # Frontend (Vue.js)
  frontend:
    image: node:18.15.0
    container_name: frontend-container
    working_dir: /var/www/frontend-BlogSphere
    volumes:
      - ./frontend-BlogSphere:/var/www/frontend-BlogSphere
    networks:
      - app-network
    ports:
      - "5173:5173"
      - "5174:5174"
    depends_on:
      - app
    command: >
      /bin/bash -c "
      npm install &&
      npm run dev -- --host 0.0.0.0 --port 5173
      "

# Definição da Rede Compartilhada
networks:
  app-network:
    driver: bridge

# Persistência de Dados do Banco de Dados
volumes:
  mysql-data:

```

```dockerfile
# Define a imagem base do PHP 8.3 com FPM
FROM php:8.3-fpm

# Atualiza os pacotes e instala as dependências do sistema operacional necessárias para o Laravel e o MySQL
RUN apt-get update && apt-get install -y \
    libpng-dev \                 # Suporte para manipulação de imagens PNG
    libjpeg-dev \                # Suporte para manipulação de imagens JPEG
    libfreetype6-dev \           # Suporte para fontes TrueType (necessário para GD)
    libmariadb-dev-compat \      # Biblioteca para compatibilidade com MariaDB
    libmariadb-dev \             # Biblioteca de desenvolvimento do MariaDB para conexões MySQL
    unzip \                      # Utilitário para descompactar arquivos ZIP
    curl \                       # Ferramenta para transferências de dados
    git \                        # Sistema de controle de versão para dependências do projeto
    zip \                        # Utilitário para compactação de arquivos
    netcat-openbsd \             # Ferramenta para aguardar a conexão com o banco de dados antes de iniciar a aplicação
    # Instalação do Node.js (necessário para o frontend)
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    # Configura o suporte ao MySQL no PHP
    && docker-php-ext-configure mysqli --with-mysqli \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    # Remove arquivos temporários para reduzir o tamanho da imagem
    && rm -rf /var/lib/apt/lists/*

# Instala o Composer, que é o gerenciador de dependências do PHP
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia todos os arquivos do projeto para dentro do container
COPY . /var/www

# Define o diretório de trabalho como a raiz do projeto dentro do container
WORKDIR /var/www

# Instala as dependências do frontend usando npm
WORKDIR /var/www/frontend-BlogSphere
RUN npm install

# Volta para o diretório raiz do projeto
WORKDIR /var/www
```
Para mais informações sobre a API e o Frontend, consulte os README dentro das pastas **`api-BlogSphere`** e **`frontend-BlogSphere`**.
