<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
Esta é uma aplicação API desenvolvida com Laravel 11. Foram implementados os endpoinsts USUARIOS, POSTs, TAGs, Login e Logout. Foi utilizado o banco de dados postgreSQL como repositório de dados para testar a aplicação.
</p>

# Laravel com Docker

Este projeto utiliza Docker para simplificar o ambiente de desenvolvimento.

## Pré-requisitos
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

## Clone o repositório
- git clone https://github.com/lefundes/test-devs-uefs.git
- cd test-devs-uefs

## Gerenciamento de dependências e Migrations
- sudo docker-compose exec laravel composer install
- sudo docker-compose exec laravel php artisan migrate

## Iniciar o Container
- sudo docker-compose up -d

## Gerenciar API via Docker
- sudo docker exec -it laravel_app bash

## Popular entidade de usuários para teste da API
- php artisan db:seed

## Testar a API
- http://localhost:8000

## Dados de acesso para testar API
- Endpoint http://127.0.0.1:8000/api/login

JSON
{
    "email": "admin@api.com.br",
    "password": "123456"
}

Preview
{
	"token": {
		"access_token": "15|Zsjb2hk2c1AuvmSHWeZPoCvxblhb5B0R3FUz01ZFcedc0b12",
		"token_type": "bearer",
		"expires_in": null
	}
}

## Documentação da API
- http://localhost:8000/doc

