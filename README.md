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
``
Na raiz do projeto dentro da pasta docker será necessário criar uma pasta denominada data e dentro dela uma outra de nome mysql
``
### 3.1 Construa e inicie os contêineres Docker
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
Usuários:
GET /api/user: Lista todos os usuários
GET /api/user/{id}: Mostra um usuário específico
POST /api/user: Cria um novo usuário
PUT /api/user/{id}: Atualiza um usuário existente
DELETE /api/user/{id}: Deleta um usuário

Postagens:
GET /api/post: Lista todas as postagens
GET /api/post/{id}: Mostra uma postagem específica
POST /api/post: Cria uma nova postagem
PUT /api/post/{id}: Atualiza uma postagem existente
DELETE /api/post/{id}: Deleta uma postagem

Tags:
GET /api/tag: Lista todas as tags
GET /api/tag/{id}: Mostra uma tag específica
POST /api/tag: Cria uma nova tag
PUT /api/tag/{id}: Atualiza uma tag existente
DELETE /api/tag/{id}: Deleta uma tag
```

### 6.1 Exemplo de Requisição e Resposta 

```bash
GET /api/user
{
    "status": true,
    "users": [
        {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "created_at": "2023-01-01T00:00:00.000000Z",
            "updated_at": "2023-01-01T00:00:00.000000Z",
            posts: [
                {
                id: 1,
                user_id: 1,
                title: "php teste",
                content: "Post bacana sobre php",
                created_at: "2024-11-09T05:13:29.000000Z",
                updated_at: "2024-11-09T05:13:29.000000Z"
                }
            ]
        }
    ]
}

GET /api/post
{
    "status": true,
    "posts": [
        posts: [
            {
            id: 1,
            user_id: 1,
            title: "php topado",
            content: "Post bacana sobre php",
            created_at: "2024-11-09T05:10:43.000000Z",
            updated_at: "2024-11-09T05:12:49.000000Z",
            user: [
                {
                    id: 1,
                    name: "John Doe",
                    email: "john@example.com",
                    email_verified_at: null,
                    created_at: "2024-11-09T03:54:34.000000Z",
                    updated_at: "2024-11-09T03:54:34.000000Z"
                }
            ],
            tags: [
                    {
                    id: 2,
                    post_id: 1,
                    name: "php",
                    created_at: "2024-11-09T05:20:06.000000Z",
                    updated_at: "2024-11-09T05:20:06.000000Z"
                    }
                ]
            },
    ]
}

GET /api/tag

    {
        status: true,
        tags: [
            {
                id: 2,
                post_id: 1,
                name: "php",
                created_at: "2024-11-09T05:20:06.000000Z",
                updated_at: "2024-11-09T05:20:06.000000Z",
                post: {
                id: 1,
                user_id: 2,
                title: "php topado",
                content: "Post bacana sobre php",
                created_at: "2024-11-09T05:10:43.000000Z",
                updated_at: "2024-11-09T05:12:49.000000Z"
                }
            }
        ]
    }
   
}
```



### Conclusão

Com este arquivo [README.md](http://_vscodecontentref_/3), qualquer pessoa deve ser capaz de configurar e executar a aplicação Laravel com Docker.