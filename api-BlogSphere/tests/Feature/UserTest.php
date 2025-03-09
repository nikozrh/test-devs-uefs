<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\UserService;
use Mockery;

class UserTest extends TestCase
{
    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();

        // Criando um Mock do UserService
        $this->userService = Mockery::mock(UserService::class);
        $this->app->instance(UserService::class, $this->userService);
    }

    public function test_list_users()
    {
        // Criando um mock para UserService
        $userServiceMock = Mockery::mock(UserService::class);

        // Simulando retorno esperado do método getAllUsers()
        $userServiceMock->shouldReceive('getAllUsers')
            ->once() // Espera que seja chamado uma vez
            ->andReturn([
                ['name' => 'John Doe', 'email' => 'john@example.com'],
                ['name' => 'Jane Doe', 'email' => 'jane@example.com'],
            ]);

        // Substituindo a instância real pelo mock
        $this->app->instance(UserService::class, $userServiceMock);

        // Fazendo a requisição para listar usuários
        $response = $this->getJson('/api/users');

        // Verificando resposta
        $response->assertStatus(200)
                 ->assertJson([
                     ['name' => 'John Doe', 'email' => 'john@example.com'],
                     ['name' => 'Jane Doe', 'email' => 'jane@example.com'],
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
