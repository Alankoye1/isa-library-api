# Library REST API (Laravel mini project, ISA)

REST API for managing books. Token auth with Laravel Sanctum.

## Run
    composer install
    cp .env.example .env && php artisan key:generate
    php artisan migrate --seed     # demo user: demo@example.com / password
    php artisan serve              # http://127.0.0.1:8000/api
    php artisan test

## Endpoints
| Method | URL | Auth | Purpose |
|---|---|---|---|
| POST | /api/register | no | create user, get token |
| POST | /api/login | no | get token |
| POST | /api/logout | yes | revoke token |
| GET | /api/books?search=&per_page= | no | list, search, paginate |
| GET | /api/books/{id} | no | show one |
| POST | /api/books | yes | create |
| PUT/PATCH | /api/books/{id} | yes (owner) | update |
| DELETE | /api/books/{id} | yes (owner) | delete |

Send token as `Authorization: Bearer <token>` and `Accept: application/json`.

## Laravel features demonstrated
- Routing (`routes/api.php`, route groups, route-model binding)
- Controllers (`BookController`, `AuthController`)
- Eloquent ORM + relationships (User hasMany Book)
- Migrations, factories, seeders
- Form Request validation (`BookRequest`)
- API Resources (`BookResource`) = JSON transformation
- Middleware (`auth:sanctum`)
- Authentication with Sanctum tokens
- Pagination, query filtering
- Feature tests (`php artisan test`)
- Artisan CLI

## REST concepts demonstrated
Resource URLs, HTTP verbs, status codes (200, 201, 204, 401, 403, 404, 422), stateless token auth, JSON.
