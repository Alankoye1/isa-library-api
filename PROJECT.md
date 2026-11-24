# ISA Library API

A simple web service for managing a library's books. People can look at the books. Logged-in users can add and manage their own.

## The idea

A **REST API** is a program that other programs and web pages talk to over HTTP. This one stores books in a database. A web page on top of it lets people use it.

## Main features

1. **Accounts:** a user registers and logs in. The server gives back a **token**, like a digital ticket.
2. **Browse books:** anyone can list, search and open books. No login is needed.
3. **Manage books:** a logged-in user can add a book. They can edit or delete only their own books.
4. **Rate limiting:** the server limits how many requests one person can send per minute. This stops abuse such as guessing passwords.

## How each feature works

| Feature | How |
|---|---|
| Login with a token | **Laravel Sanctum.** The client sends the token with each request, and the server checks it. |
| Only the owner can change a book | The server compares the book's owner with the logged-in user. If they differ, it returns `403 Forbidden`. |
| Checking input | A validation class rejects bad data, such as a missing title or a duplicate ISBN. |
| Rate limiting | Login and register: 5 requests per minute. Everything else: 60 per minute. Over the limit, the server returns `429 Too Many Requests`. |

## The API

| Action | Request | Needs login? |
|---|---|---|
| Register | `POST /api/register` | No |
| Log in | `POST /api/login` | No |
| List or search books | `GET /api/books` | No |
| See one book | `GET /api/books/{id}` | No |
| Add a book | `POST /api/books` | Yes |
| Edit a book | `PUT /api/books/{id}` | Yes, owner only |
| Delete a book | `DELETE /api/books/{id}` | Yes, owner only |
| Log out | `POST /api/logout` | Yes |

## The web page

- It shows the catalog as book covers, with search and page buttons.
- Log in, sign up, add book and edit book open in pop-up windows.
- The **Console** button opens a panel for developers. It shows:
  - every request with its status and response time,
  - a switch that turns rate limiting on or off,
  - a button that sends 70 requests at once. With rate limiting on, some get `429`. With it off, all succeed.

## Demo steps

1. Open the page and search for a book.
2. Sign up, then add a book.
3. Open another user's book and see that Edit and Delete do not appear.
4. Open **Console** and click **Send 70 requests** with rate limiting on. Some requests fail with `429`.
5. Turn the switch off and click it again. All requests succeed.

## Technology

- **Laravel** (PHP framework)
- **Sanctum** (token login)
- **SQL database** with Eloquent models
- **HTML, CSS and JavaScript** for the web page

## Where the code is

| What | File |
|---|---|
| Routes and rate limits | `routes/api.php` |
| Login and register | `app/Http/Controllers/AuthController.php` |
| Book actions | `app/Http/Controllers/BookController.php` |
| Rate-limit rules | `app/Providers/AppServiceProvider.php` |
| Web page | `resources/views/library.blade.php` |

## Run it

```
composer install
php artisan migrate
php artisan serve
```

Then open http://127.0.0.1:8000.
