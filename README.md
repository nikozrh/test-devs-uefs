# Protótipo de Blog e Rede Social Digital

![Tela leitura usuários e tags](https://github.com/user-attachments/assets/0deb3f84-c0d8-4436-8c4b-42b9e4665cc7)

Este projeto é uma aplicação que gerencia Usuários, Tags e Posts.

Nela pode-se realizar operações CRUD de Usuários, Tags e Posts.

A aplicação é dividida em dois componentes principais:
- Backend
- Frontend

Ambos seguindo práticas de desenvolvimento modernas para garantir robustez, escalabilidade e fácil manutenção.

## Tabela de Conteúdos
- [Arquitetura](#arquitetura)
- [Tecnologias](#tecnologias)
- [Instalação](#instalação)
- [Uso](#uso)
- [API Backend](#backend)
- [Frontend](#frontend)
- [Testes](#testes)

## Arquitetura

A aplicação segue uma arquitetura baseada em:
- padrão de repositórios (Repository Pattern).
- princípios SOLID.

Assim, garante a escalabilidade e manutenção eficiente.

O frontend também obedece princípios SOLID.

A comunicação entre frontend e backend é realizada por meio de API RESTful.

### Componentes Principais:
- **Backend**: Responsável pela lógica de negócios, acesso a dados e exposições da API.
- **Frontend**: Interface do usuário desenvolvida em React.js.
- **Banco de Dados**: Utiliza MySQL para persistência de dados.

## Tecnologias

- **Backend**: PHP, Laravel, Repository Pattern, SOLID Principles
- **Frontend**: React.js, SOLID Principles
- **Banco de Dados**: MySQL, SQLite
- **Testes**: PHPUnit, Mockery
- **Documentação da API**: Swagger
- **Docker**: Para containerização

## Instalação

### Pré-requisitos
- Docker e Docker Compose instalados
- Node.js e npm instalados (para o frontend React)
- Composer

### Passos

1. Clone o repositório:
   ```bash
   git clone https://github.com/SeuUsuario/seu-repositorio.git
   cd seu-repositorio

2. Navegue até o diretório da API:
	```bash
    cd api_rede_social
   
3. Suba os contêineres Docker:
	```bash
    docker compose up --build

4. Acesse o contêiner da aplicação e configure o ambiente:
   ```bash
   docker exec -it laravel-app bash
   composer install
   php artisan migrate
   exit
   
5. A API estará disponível em:
	```bash
    http://localhost:8000
   
6. A documentação estará em:
	```bash
    http://localhost:8000/api/documentation

7. Navegue até o diretório do frontend:
    ```bash
    cd ..
    cd frontend_react

8. Instale as dependências do React:
	```bash
    npm install
   
9. Inicie o servidor React:
	```bash
    npm start
   
10. O frontend estará disponível em:
	```bash
    http://localhost:3000

Agora o projeto estará rodando em localhost:8000 para o backend e localhost:3000 para o frontend.

## Uso

adicionar telas da interface gráfica

## Detalhes

### Backend

As requisições à API são feitas por meio de localhost:8000/api.

Exemplo de requisição para criar um novo usuário:

POST /api/usuarios
Content-Type: application/json
{
  "name": "Joábio Vilela",
  "email": "joabio.vilela@gmail.com",
  "password": "xdJLKhfSJK54%4@@2e"
}

### Estrutura

- `routes/api.php`: As rotas de UsuarioController, TagController e PostController.
- `app/Http/Controllers`: Os controllers UsuarioController, TagController e PostController.
- `app/Http/Requests`: Os form request de store e de update com as regras de validações e mensagens de feedback para requisições e de Usuario, Tag e Post.
- `app/Models`: Os models Usuario, Tag e Post.
- `app/Providers/AppServiceProvider.php`: Todos os bindings entre repositories interfaces e repositories eloquent.
- `app/Repositories`: As interfaces e eloquent.
- `app/Services`: Os services UsuarioService, TagService e PostService.
- `tests/Unit`: Os testes unitários dos services e dos repositories de Usuario, Tag e Post.
- `.env`: As variáveis de ambiente referente à conexão do banco de dados MySQL e a outros aspectos.
- `.env.testing`: As variáveis de ambiente referente à conexão de banco de dados com o SQLite para realização dos testes unitários.
- `Dockerfile`: PHP 8.3 e dependências e o driver do MySQL.
- `docker-compose.yml`:  Dockerfile do projeto e o MySQL 8.
- `phpunit.xml`: Configurações do PHPUnit.

### Frontend

- O frontend foi desenvolvido usando React.js, useState, useEffect e Axios.

- Oferece operações de cadastro, exibição, edição e exclusão dos registros de usuários, tags e posts.

- Ele consome a API backend para fornecer dados dinâmicos.

### Estrutura

- `src/`: Contém todos os componentes React.
- `src/components`: Contém os componentes Modal, UsuarioManager, TagManager e PostManager.
- `src/services`: Contém os serviços UsuarioService, TagService e PostService.

## Testes

A aplicação usa PHPUnit para testes unitários.

Para rodar os testes:

1. Navegue até o diretório da API:
	```bash
	cd api_rede_social
	
2. Execute os testes:
	```bash
	php artisan test

## Licença

Este projeto está licenciado sob a MIT License.
