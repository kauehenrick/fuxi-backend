# Execução local da API

Este repositório é executado localmente com Docker Compose. Ele sobe três containers: PHP-FPM/Laravel (`app`), Nginx (`webserver`) e MySQL 8 (`db`). Não há configuração de deploy hospedado neste projeto.

## Pré-requisitos

- Docker Engine ou Docker Desktop;
- Docker Compose v2;
- Git.

## Subir o ambiente

Na raiz do repositório:

```bash
cp .env.example .env
LOCAL_UID=$(id -u) LOCAL_GID=$(id -g) docker compose up --build -d
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

`LOCAL_UID` e `LOCAL_GID` fazem os arquivos gerados pelo container pertencerem ao usuário local. Se não forem informados, o Compose usa `1000:1000`.

## Endereços e acesso

| Item | Endereço ou valor |
| --- | --- |
| API | `http://localhost:8000/api` |
| Health check | `http://localhost:8000/up` |
| MySQL exposto no host | `localhost:3307` |
| Banco | `fuxi_db` |
| Usuário inicial | `admin@fuxi.com` / `fuxi123@` |

Valide o ambiente:

```bash
curl -i http://localhost:8000/up
curl -i http://localhost:8000/api/login
```

O health check deve devolver `200`. `GET /api/login` deve devolver `405`, pois a rota aceita somente `POST`.

## Operação diária

```bash
# acompanhar logs
docker compose logs -f

# executar testes
docker compose exec app php artisan test

# parar containers e preservar o banco
docker compose down
```

Para remover o banco local e todos os seus dados, execute `docker compose down -v`. Na próxima inicialização, rode novamente as migrations e o seeder.
