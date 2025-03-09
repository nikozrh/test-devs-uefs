<?php

namespace Tests\Feature;

use App\Services\PostService;
use Mockery;
use Tests\TestCase;

class PostTest extends TestCase
{
    protected $postServiceMock;

    // Configuração inicial antes de cada teste
    protected function setUp(): void
    {
        parent::setUp();

        // Criando mock do PostService
        $this->postServiceMock = Mockery::mock(PostService::class);

        // Registrando o mock no contêiner de serviços
        $this->app->instance(PostService::class, $this->postServiceMock);
    }

    // Testar a listagem de posts
    public function test_list_posts()
    {
        // Definindo comportamento esperado
        $this->postServiceMock->shouldReceive('getAllPosts')
            ->once()
            ->andReturn([
                ['id' => 1, 'title' => 'Post 1', 'content' => 'Conteúdo do Post 1'],
                ['id' => 2, 'title' => 'Post 2', 'content' => 'Conteúdo do Post 2']
            ]);

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
                 ->assertJsonCount(2)
                 ->assertJson([
                     ['id' => 1, 'title' => 'Post 1', 'content' => 'Conteúdo do Post 1'],
                     ['id' => 2, 'title' => 'Post 2', 'content' => 'Conteúdo do Post 2']
                 ]);
    }

    // Testar a criação de um post
    public function test_create_post()
    {
        // Criar um usuário válido para o teste
        $user = \App\Models\User::factory()->create();

        $postData = [
            'user_id' => $user->id, 
            'title' => 'Novo Post',
            'content' => 'Conteúdo do novo post'
        ];

        $this->postServiceMock->shouldReceive('createPost')
            ->once()
            ->with($postData)
            ->andReturn(array_merge(['id' => 1], $postData));

        $response = $this->postJson('/api/posts', $postData);

        $response->assertStatus(201)
                ->assertJson(array_merge(['id' => 1], $postData));
    }

    // Testar a atualização de um post
    public function test_update_post()
    {
        // Criar um usuário válido para o teste
        $user = \App\Models\User::factory()->create();

        $updateData = [
            'user_id' => $user->id,
            'title' => 'Post Atualizado',
            'content' => 'Conteúdo atualizado'
        ];

        $this->postServiceMock->shouldReceive('updatePost')
            ->once()
            ->with(1, $updateData)
            ->andReturn(array_merge(['id' => 1, 'user_id' => $user->id], $updateData));

        $response = $this->putJson('/api/posts/1', $updateData);

        $response->assertStatus(200)
                ->assertJson(array_merge(['id' => 1, 'user_id' => $user->id], $updateData));
    }

    // Testar a exclusão de um post
    public function test_delete_post()
    {
        // Definindo comportamento esperado
        $this->postServiceMock->shouldReceive('deletePost')
            ->once()
            ->with(1)
            ->andReturn(true);

        // Chamando a rota para deletar o post
        $response = $this->deleteJson('/api/posts/1');

        // Validando resposta
        $response->assertStatus(204);
    }

    // Limpeza após cada teste
    protected function tearDown(): void
    {
        // Limpando os mocks do Mockery
        Mockery::close();
        parent::tearDown();
    }

}
