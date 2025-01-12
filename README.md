<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
Esta é uma aplicação API desenvolvida com Laravel 11. Foi implementado os endpoinsts USUARIOS, POSTs e TAGs. Foi utilizado o banco de dados postgreSQL como repositório de dados para testar a aplicação.
</p>

## Instalação via Docker
### No terminal Linux executar os passos a seguir:
#### Iniciar o Container
- docker-compose up -d
#### Configurar o Banco de Dados
- docker exec -it laravel_app bash
#### Configure as entidades na banco de dados
- php artisan migrate
#### Testar a API
- http://localhost:8000
#### Documentação da API
- http://localhost:8000/doc

