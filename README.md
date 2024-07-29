# Blog API
A simple blog API built with Laravel for the Cube Academy PHP technical task.

## Setup
1. Clone the repository
2. Run `composer install`
3. Run `php artisan key:generate`
4. Create a database and add the database credentials to the `.env` file
5. Run `php artisan migrate`
7. Run `php artisan serve`
8. The project will now be available at `http://localhost:8000`

## Endpoints
- `GET /api/posts` - Get all blogs
- `POST /api/posts` - Create a new blog (requires authentication)
- `GET /api/posts/{id}` - Get a single blog (requires authentication)
- `PUT /api/posts/{id}` - Update a blog (requires authentication)
- `DELETE /api/posts/{id}` - Delete a blog (requires authentication)
- `POST /api/login` - Login
- `POST /api/register` - Register

## Authentication
To authenticate, send a POST request to `/api/login` with the following payload:
```
{
    "email": ""
    "password": ""
}
```
The API will return a token which should be included in the headers of all requests that require authentication.

## Testing
To run the tests, run `php artisan test`
