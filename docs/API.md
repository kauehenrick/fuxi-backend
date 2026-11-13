# FuXi API — arquitetura e contrato

## Implementação

Laravel 13 e PHP 8.3+, Laravel Sanctum para tokens pessoais, Eloquent e banco relacional. O ambiente local usa MySQL 8 em Docker. Autores, gêneros e livros suportam soft delete.

Todas as rotas de domínio usam o prefixo `/api`. Exceto cadastro e login, elas exigem:

```http
Authorization: Bearer <token>
Accept: application/json
```

## Endpoints

| Método e rota | Autenticação | Resultado |
| --- | --- | --- |
| `GET /up` | não | health check Laravel |
| `POST /api/users` | não | cria usuário e devolve `{ token, user }` |
| `POST /api/login` | não | devolve `{ token, user }` |
| `POST /api/logout` | Bearer | revoga o token atual |
| `GET /api/me` | Bearer | usuário atual |
| `GET/POST /api/authors` | Bearer | lista, incluindo inativos, ou cria autor |
| `PATCH/DELETE /api/authors/{id}` | Bearer | atualiza ou desativa autor |
| `PATCH /api/authors/{id}/restore` | Bearer | reativa autor |
| `GET/POST /api/genres` | Bearer | lista, incluindo inativos, ou cria gênero |
| `PATCH/DELETE /api/genres/{id}` | Bearer | atualiza ou desativa gênero |
| `PATCH /api/genres/{id}/restore` | Bearer | reativa gênero |
| `GET/POST /api/books` | Bearer | lista, incluindo inativos, ou cria livro |
| `PATCH/DELETE /api/books/{id}` | Bearer | atualiza ou desativa livro |
| `PATCH /api/books/{id}/restore` | Bearer | reativa livro |
| `GET /api/dashboard` | Bearer | retorna livros por gênero e autores com mais livros |

`DELETE` não remove registros definitivamente. Autor e gênero vinculados a livros ativos não podem ser desativados. Livros só podem referenciar autor e gênero ativos.

### Payloads

```json
// POST /api/users
{ "name": "Ana", "email": "ana@example.com", "password": "senha-segura" }

// POST/PATCH /api/books
{
  "title": "Livro",
  "author_id": 1,
  "genre_id": 1,
  "published_year": 2026,
  "amount": 1,
  "localization": "Estante A",
  "isbn": "1234567890123"
}
```

Campos obrigatórios de livro: `title`, `author_id`, `genre_id` e `amount` (mínimo 1). Autor e gênero aceitam `{ "name": "..." }`.

## Segurança e operação

- `CORS_ALLOWED_ORIGINS` recebe origens separadas por vírgula; no ambiente local, mantenha `http://localhost:5173` na lista.
- Nunca versione `.env`, `APP_KEY`, senha de banco ou token.
- Para uma origem de browser, o token é enviado em `Authorization`; não há cookie de sessão necessário.
