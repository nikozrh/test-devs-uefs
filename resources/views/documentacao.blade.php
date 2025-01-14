<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentação Completa da API Laravel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background: #007bff;
            color: white;
            padding: 1em 0;
            text-align: center;
        }
        nav {
            background: #f8f9fa;
            padding: 1em;
            border-bottom: 1px solid #ddd;
        }
        nav a {
            margin: 0 1em;
            text-decoration: none;
            color: #007bff;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            padding: 2em;
        }
        section {
            margin-bottom: 3em;
        }
        h1, h2, h3, h4 {
            color: #007bff;
        }
        pre {
            background: #f8f9fa;
            padding: 1em;
            border: 1px solid #ddd;
            overflow-x: auto;
        }
        code {
            font-family: monospace;
        }
        .request, .response {
            margin-top: 1em;
            padding: 1em;
            background: #e9ecef;
            border-left: 4px solid #007bff;
        }
        .note {
            background: #fff3cd;
            color: #856404;
            padding: 1em;
            border: 1px solid #ffeeba;
            border-radius: 5px;
            margin-bottom: 1em;
        }
    </style>
</head>
<body>
    <header>
        <h1>Documentação da API Laravel</h1>
    </header>
    <nav>
        <a href="#arquitetura">Arquitetura</a>
        <a href="#instalacao">Configuração e Instalação</a>
        <a href="#endpoints">Endpoints</a>
    </nav>
    <main>
        <!-- Arquitetura do Sistema -->
        <section id="arquitetura">
            <h2>Arquitetura do Sistema</h2>
            <p>O sistema foi desenvolvido utilizando as seguintes tecnologias principais:</p>
            <ul>
                <li><strong>Laravel 11</strong>: Framework PHP usado para criar a API.</li>
                <li><strong>PostgreSQL</strong>: Banco de dados utilizado para armazenar as informações.</li>
                <li><strong>Insomnia</strong>: Ferramenta para testar e validar os endpoints da API.</li>
            </ul>
            <p>A aplicação utiliza autenticação com JWT (JSON Web Token) por meio do laravel/sanctum.</p>
        </section>
        <!-- Iniciar os Containers -->
        <section id="instalacao">
            <h2>Instalação da aplicação</h2>
            <ol>
                <li>Pré-requisitos
                    <pre>
                        <code>[Docker](https://www.docker.com/)</code>
                        <code>[Docker Compose](https://docs.docker.com/compose/)</code>
                    </pre>
                </li>
                <li>Clone o repositório
                    <pre>
                        <code>git clone https://github.com/lefundes/test-devs-uefs.git</code>
                        <code>cd test-devs-uefs</code>
                    </pre>
                </li>
                <li>Gerenciamento de dependências
                    <pre><code>sudo docker-compose exec laravel composer install</code></pre>
                </li>
                <li>Excutar Migrations
                    <pre><code>sudo docker-compose exec laravel php artisan migrate</code></pre>
                </li>
                <li>Iniciar o Container
                    <pre><code>sudo docker-compose up -d</code></pre>
                </li>
                <li>Gerenciar API via Docker
                    <pre><code>sudo docker exec -it laravel_app bash</code></pre>
                </li>
                <li>Popular entidade de usuários para teste da API
                    <pre><code>php artisan db:seed</code></pre>
                </li>
                <li>Testar a API
                    <pre><code>http://localhost:8000</code></pre>
                </li>
                <li>Documentação da API
                    <pre><code>http://localhost:8000/doc</code></pre>
                </li>
            </ol>
        </section>
        <!-- Endpoints -->
        <section id="endpoints">
            <h2>Endpoints</h2>
            <p>A API suporta operações CRUD completas para Usuários, Posts, Tags, Login e Logout. Abaixo estão os detalhes de cada grupo de rotas.</p>
            <!-- Login/Logout -->
            <section id="auth">
                <h3>Autenticação</h3>
                
                <!-- Login -->
                <h4>Login de Usuário</h4>
                <p>Gera um token de autenticação para a sessão do usuário.</p>
                <pre class="request"><code>POST /api/login
            Content-Type: application/json

            {
                "email": "usuario@api.com.br",
                "password": "senha123"
            }</code></pre>
                <h5>Resposta de Sucesso:</h5>
                <pre class="response"><code>{
                "token": {
                    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
                    "token_type": "bearer",
                    "expires_in": null
                }
            }</code></pre>

                <!-- Logout -->
                <h4>Logout de Usuário</h4>
                <p>Encerra a sessão de um usuário autenticado, revogando o token de acesso.</p>
                <pre class="request"><code>POST /api/logout
            Authorization: Bearer {seu_token_aqui}</code></pre>
                <h5>Resposta de Sucesso:</h5>
                <pre class="response"><code>{
                "message": "Logout realizado com sucesso"
            }</code></pre>
                
                <!-- Erros Comuns -->
                <h4>Erros Comuns</h4>
                <ul>
                    <li>
                        <strong>401 Unauthorized</strong>: Token inválido ou ausente.
                        <pre class="error"><code>{
                "message": "Não autenticado"
            }</code></pre>
                    </li>
                    <li>
                        <strong>422 Unprocessable Entity</strong>: Dados de login inválidos.
                        <pre class="error"><code>{
                "message": "Credenciais inválidas"
            }</code></pre>
                    </li>
                </ul>
            </section>


            <!-- Usuários -->
            <section id="usuarios">
                <h3>Usuários</h3>
                <h4>Listar Usuários</h4>
                <p>Retorna todos os usuários registrados.</p>
                <pre class="request"><code>GET /api/users</code></pre>

                <h4>Visualizar Usuário</h4>
                <p>Retorna informações de um usuário específico.</p>
                <pre class="request"><code>GET /api/users/{id}</code></pre>

                <h4>Cadastrar Usuário</h4>
                <p>Cria um novo usuário.</p>
                <pre class="request"><code>POST /api/users
Content-Type: application/json

{
    "name": "Novo Usuário",
    "email": "novo@api.com.br",
    "password": "senha"
}</code></pre>

                <h4>Editar Usuário</h4>
                <p>Atualiza as informações de um usuário existente.</p>
                <pre class="request"><code>PUT /api/users/{id}
Content-Type: application/json

{
    "name": "Admin",
    "email": "admin2@api.com.br",
    "password": "123456"
}</code></pre>

                <h4>Deletar Usuário</h4>
                <p>Remove um usuário específico.</p>
                <pre class="request"><code>DELETE /api/users/{id}</code></pre>
            </section>

            <!-- Posts -->
            <section id="posts">
                <h3>Posts</h3>
                <h4>Listar Posts</h4>
                <p>Retorna todos os posts registrados.</p>
                <pre class="request"><code>GET /api/posts</code></pre>

                <h4>Visualizar Post</h4>
                <p>Retorna informações de um post específico.</p>
                <pre class="request"><code>GET /api/posts/{id}</code></pre>

                <h4>Cadastrar Post</h4>
                <p>Cria um novo post.</p>
                <pre class="request"><code>POST /api/posts
Content-Type: application/json

{
    "title": "Post de programação",
    "content": "Conteúdo do post",
    "user_id": 2,
    "tags": [1, 2, 4]
}</code></pre>

                <h4>Editar Post</h4>
                <p>Atualiza as informações de um post existente.</p>
                <pre class="request"><code>PUT /api/posts/{id}
Content-Type: application/json

{
    "title": "Post de programação",
    "content": "Conteúdo atualizado",
    "user_id": 2,
    "tags": [1, 2, 4]
}</code></pre>

                <h4>Deletar Post</h4>
                <p>Remove um post específico.</p>
                <pre class="request"><code>DELETE /api/posts/{id}</code></pre>
            </section>

            <!-- Tags -->
            <section id="tags">
                <h3>Tags</h3>
                <h4>Listar Tags</h4>
                <p>Retorna todas as tags registradas.</p>
                <pre class="request"><code>GET /api/tags</code></pre>

                <h4>Visualizar Tag</h4>
                <p>Retorna informações de uma tag específica.</p>
                <pre class="request"><code>GET /api/tags/{id}</code></pre>

                <h4>Cadastrar Tag</h4>
                <p>Cria uma nova tag.</p>
                <pre class="request"><code>POST /api/tags
Content-Type: application/json

{
    "name": "Nova Tag"
}</code></pre>

                <h4>Editar Tag</h4>
                <p>Atualiza as informações de uma tag existente.</p>
                <pre class="request"><code>PUT /api/tags/{id}
Content-Type: application/json

{
    "name": "Tag Atualizada"
}</code></pre>

                <h4>Deletar Tag</h4>
                <p>Remove uma tag específica.</p>
                <pre class="request"><code>DELETE /api/tags/{id}</code></pre>
            </section>
        </section>
    </main>
</body>
</html>