# Dados Simulados

## Requisitos

-   MySql
-   PHP >= 8.1
-   Composer

## Como rodar o projeto:

-   Clone o projeto para sua maquina

-   Instalar dependencias

```
composer install
```

-   copie o arquivo **".env.example"** e crie um **".env"**

-   Crie o seu Banco de Dados, ex: **"mock_data"**
-   Coloque suas configurações de Banco de Dados no `.env`
-   Coloque suas configurações de envio email no `.env`, se você não possui uma hospedagem para disparar emails use o [mailtrap](https://mailtrap.io/) que é gratuito para testes de envio de email

-   Criar as tabelas do Banco de Dados

```
php artisan migrate
```

-   Rodar o projeto

```
php artisan key:generate
```

```
php artisan serve
```
