# Deploy de demo: Render + Supabase

O frontend é publicado separadamente na Vercel. A API deste repositório roda como Render Web Service, conectada a um banco Postgres gratuito do Supabase.

## Preparação

1. Crie um projeto Postgres no Supabase e obtenha host, porta, banco, usuário e senha.
2. No Render, conecte este repositório e use o `render.yaml` da raiz. Ele usa o `Dockerfile` de produção e o endpoint `/up` como health check.
3. No painel do serviço, preencha os valores marcados como secretos no blueprint:

```env
APP_URL=https://fuxi-api-demo.onrender.com
APP_KEY=base64:<resultado de php artisan key:generate --show>
DB_HOST=<host do Supabase>
DB_PASSWORD=<senha do Supabase>
DB_SSLMODE=require
CORS_ALLOWED_ORIGINS=https://<projeto>.vercel.app
```

O container executa migrations e o seeder idempotente no início. A conta de demonstração é `admin@fuxi.com` com a senha `fuxi123@`. Não use um banco SQLite ou arquivos locais: o disco gratuito do Render é efêmero.

## Publicar o frontend

Na Vercel, configure:

```env
VITE_API_URL=https://fuxi-api-demo.onrender.com/api
```

Depois de conhecer a URL final da Vercel, atualize `CORS_ALLOWED_ORIGINS` no Render e dispare novo deploy.

## Validação

```bash
curl -i https://fuxi-api-demo.onrender.com/up
curl -i https://fuxi-api-demo.onrender.com/api/login
```

O primeiro comando deve responder `200`; o segundo, `405` para GET, confirmando que o endpoint existe e aceita apenas POST.

## Limites

O serviço gratuito do Render hiberna após inatividade e pode levar cerca de um minuto para acordar. O Supabase Free pode pausar projetos inativos. Esta arquitetura é somente para demonstração.
