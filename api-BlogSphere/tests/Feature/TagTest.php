<?php

namespace Tests\Feature;

use App\Services\TagService;
use Mockery;
use Tests\TestCase;

class TagTest extends TestCase
{
    protected $tagServiceMock;

    // Configuração inicial antes de cada teste
    protected function setUp(): void
    {
        parent::setUp();

        // Criando mock do TagService
        $this->tagServiceMock = Mockery::mock(TagService::class);

        // Registrando o mock no contêiner de serviços
        $this->app->instance(TagService::class, $this->tagServiceMock);
    }

    // Testar a listagem de tags
    public function test_list_tags()
    {
        // Definindo comportamento esperado
        $this->tagServiceMock->shouldReceive('getAllTags')
            ->once()
            ->andReturn([
                ['id' => 1, 'name' => 'Tag 1'],
                ['id' => 2, 'name' => 'Tag 2']
            ]);

        // Chamando a rota para listar tags
        $response = $this->getJson('/api/tags');

        // Validando resposta
        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJson([
                ['id' => 1, 'name' => 'Tag 1'],
                ['id' => 2, 'name' => 'Tag 2']
            ]);
    }

    // Testar a criação de uma tag
    public function test_create_tag()
    {
        // Dados enviados para criar a tag
        $tagData = [
            'name' => 'Nova Tag'
        ];

        // Definindo comportamento esperado
        $this->tagServiceMock->shouldReceive('createTag')
            ->once()
            ->with($tagData)
            ->andReturn(array_merge(['id' => 1], $tagData));

        // Chamando a rota para criar uma tag
        $response = $this->postJson('/api/tags', $tagData);

        // Validando resposta
        $response->assertStatus(201)
            ->assertJson(array_merge(['id' => 1], $tagData));
    }

    // Testar a atualização de uma tag
    public function test_update_tag()
    {
        // Dados enviados para atualizar a tag
        $updateData = [
            'name' => 'Tag Atualizada'
        ];

        // Definindo comportamento esperado
        $this->tagServiceMock->shouldReceive('updateTag')
            ->once()
            ->with(1, $updateData)
            ->andReturn(array_merge(['id' => 1], $updateData));

        // Chamando a rota para atualizar a tag
        $response = $this->putJson('/api/tags/1', $updateData);

        // Validando resposta
        $response->assertStatus(200)
            ->assertJson(array_merge(['id' => 1], $updateData));
    }

    // Testar a exclusão de uma tag
    public function test_delete_tag()
    {
        // Definindo comportamento esperado
        $this->tagServiceMock->shouldReceive('deleteTag')
            ->once()
            ->with(1)
            ->andReturn(true);

        // Chamando a rota para deletar a tag
        $response = $this->deleteJson('/api/tags/1');

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
