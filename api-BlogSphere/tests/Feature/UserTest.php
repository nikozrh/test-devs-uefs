<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\UserService;
use Mockery;
use Illuminate\Support\Collection;

class UserTest extends TestCase
{
    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();

        // Criando um Mock do UserService
        $this->userService = Mockery::mock(\App\Services\UserService::class);
        $this->app->instance(\App\Services\UserService::class, $this->userService);
    }

    public function test_list_users()
    {
        // Simular os dados como Collection
        $mockedUsers = new Collection([
            ['id' => 1, 'name' => 'Usuário 1', 'email' => 'user1@example.com'],
            ['id' => 2, 'name' => 'Usuário 2', 'email' => 'user2@example.com'],
        ]);

        // Configurar o mock do serviço
        $this->userService->shouldReceive('getAllUsers')
            ->once()
            ->andReturn($mockedUsers);

        // Fazer a requisição GET para a rota
        $response = $this->getJson('/api/users');

        // Verificar o status HTTP e o conteúdo retornado
        $response->assertStatus(200)
            ->assertJsonCount(2) // Deve retornar 2 usuários
            ->assertJson([
                ['id' => 1, 'name' => 'Usuário 1', 'email' => 'user1@example.com'],
                ['id' => 2, 'name' => 'Usuário 2', 'email' => 'user2@example.com'],
            ]);
    }

    
    public function test_update_user()
    {
        // Criando mock do UserService
        $userServiceMock = Mockery::mock(\App\Services\UserService::class);
        $this->app->instance(\App\Services\UserService::class, $userServiceMock);

        // Definindo o comportamento esperado
        $userServiceMock->shouldReceive('updateUser')
            ->once()
            ->with(1, [
                'name' => 'Novo Nome',
                'email' => 'novoemail@example.com',
            ])
            ->andReturn([
                'id' => 1,
                'name' => 'Novo Nome',
                'email' => 'novoemail@example.com',
            ]);

        // Enviando requisição PATCH para atualizar o usuário
        $response = $this->patchJson('/api/users/1', [
            'name' => 'Novo Nome',
            'email' => 'novoemail@example.com',
        ]);

        // Verificando se a resposta é 200 OK e os dados estão corretos
        $response->assertStatus(200)
                ->assertJson([
                    'id' => 1,
                    'name' => 'Novo Nome',
                    'email' => 'novoemail@example.com',
                ]);
    }

    public function test_create_user()
    {
        // Criando mock do UserService
        $userServiceMock = Mockery::mock(UserService::class);
        $this->app->instance(UserService::class, $userServiceMock);

        // Definindo o comportamento esperado
        $userServiceMock->shouldReceive('createUser')
            ->once()
            ->with([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'password',
            ])
            ->andReturn([
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com',
            ]);

        // Enviando requisição POST para criar o usuário
        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
        ]);

        // Verificando se a resposta é 201 Created e os dados estão corretos
        $response->assertStatus(201)
                ->assertJson([
                    'id' => 1,
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                ]);
    }

    public function test_delete_user()
    {
        // Criando mock do UserService
        $userServiceMock = Mockery::mock(UserService::class);
        $this->app->instance(UserService::class, $userServiceMock);

        // Definindo o comportamento esperado
        $userServiceMock->shouldReceive('deleteUser')
            ->once()
            ->with(1)
            ->andReturn(true);

        // Enviando requisição DELETE para deletar o usuário
        $response = $this->deleteJson('/api/users/1');

        // Verificando se a resposta é 204 No Content
        $response->assertStatus(204);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
