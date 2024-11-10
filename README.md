# Blog API

Esta é uma API de blog desenvolvida com Laravel 11. A API permite gerenciar usuários, postagens e tags. A aplicação está configurada para ser executada em contêineres Docker.

## Requisitos

- Docker
- Docker Compose

## Configuração

### 1. Clone o repositório

```bash
git clone https://github.com/HenriqueMVSS/test-devs-uefs
```
#### Após clonar o repositório acessar a pasta utilizando o comendo abaixo
```bash 
cd test-devs-uefs
```
### 2. Configure o arquivo .env
Crie um arquivo .env na raiz do projeto e configure as variáveis de ambiente. Você pode usar o arquivo .env.example como base.

``Lembre-se por conta da aplicação esta utilizando o docker, na váriavel ambiente DB_HOSDT configurar para o nome do serviço de banco do docker, no caso dessa aplicação o nome do serviço é db``

### 3. Construa e inicie os contêineres Docker
```bash 
docker-compose up -d --build
```
### 4. Gere a chave da aplicação
```bash 
php artisan key:generate
```
### 5. Execute as migrations
```bash 
docker-compose exec app php artisan migrate
```
### 6. Endpoints da API
```bash 
Usuários
GET /api/user: Lista todos os usuários
GET /api/user/{id}: Mostra um usuário específico
POST /api/user: Cria um novo usuário
PUT /api/user/{id}: Atualiza um usuário existente
DELETE /api/user/{id}: Deleta um usuário

Postagens
GET /api/post: Lista todas as postagens
GET /api/post/{id}: Mostra uma postagem específica
POST /api/post: Cria uma nova postagem
PUT /api/post/{id}: Atualiza uma postagem existente
DELETE /api/post/{id}: Deleta uma postagem

Tags
GET /api/tag: Lista todas as tags
GET /api/tag/{id}: Mostra uma tag específica
POST /api/tag: Cria uma nova tag
PUT /api/tag/{id}: Atualiza uma tag existente
DELETE /api/tag/{id}: Deleta uma tag
```

### Conclusão

Com este arquivo [README.md](http://_vscodecontentref_/3), qualquer pessoa deve ser capaz de configurar e executar a aplicação Laravel com Docker.