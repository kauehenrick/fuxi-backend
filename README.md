# FuXi Backend

API Laravel 13 do FuXi. Fornece autenticação por token Bearer e o gerenciamento de livros, autores, gêneros e painel.

## Executar localmente

Pré-requisitos: Docker e Docker Compose.

```bash
cp .env.example .env
docker compose up --build -d
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

A API fica em `http://localhost:8000/api`; o health check é `http://localhost:8000/up`. O usuário da demo é `admin@fuxi.com` com senha `fuxi123@`.

## Documentação

- [Arquitetura e contrato HTTP](docs/API.md)
- [Deploy da demo](docs/DEPLOY.md)

## Comandos

```bash
docker compose exec app php artisan test
docker compose exec app php artisan pint --test
docker compose logs -f
```
