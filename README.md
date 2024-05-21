


# Laravel Vue Inertia Vuetify JWT Authentication

This project is a web application built with Laravel, Vue, Vuetify, Inertia, and JWT authentication. It includes a basic setup for authentication and authorization using JWT tokens.

## Prerequisites

Make sure you have the following software installed on your machine:

- PHP >= 7.4
- Composer
- Node.js & npm
- SQLite (or another database of your choice)

## Installation

Follow these steps to set up the project:

### 1. Clone the Repository

```bash
git clone https://github.com/your-repo/laravel-vue-inertia-jwt-auth.git
cd laravel-vue-inertia-jwt-auth
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node.js Dependencies

```bash
npm install
```

### 4. Configure Environment Variables

Copy the `.env.example` file to `.env` and update the environment variables as needed. Ensure you set the database connection to SQLite or your preferred database.

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Configure JWT Secret

Generate a JWT secret key and update the `.env` file.

```bash
php artisan jwt:secret
```

### 7. Migrate the Database

```bash
php artisan migrate
```

### 8. Run the Development Server

```bash
php artisan serve
```

### 9. Run the Vite Development Server

In another terminal window, run:

```bash
npm run dev
```

## Project Structure

The main components of the project are:

- **Laravel Backend**: Handles API requests, authentication, and serves the Vue frontend.
- **Vue Frontend**: Built with Vuetify and Inertia.js to create a modern SPA-like experience.
- **JWT Authentication**: Secure authentication using JSON Web Tokens.

## Middleware

The project includes custom middleware for ensuring authentication:

- **EnsureAuthenticated**: Redirects users based on their authentication status.

## Routes

The routes are protected by middleware and serve the appropriate Inertia components based on the user's authentication state.

## Vue Components

The frontend is built using Vue and Vuetify, with components managed by Inertia.js. Authentication state is managed through Inertia props.

## Authentication

Authentication is handled using JWT tokens. The following endpoints are available:

- **Register**: `POST /register`
- **Login**: `POST /login`
- **Logout**: `POST /logout`
- **Refresh Token**: `POST /refresh`
- **Get Authenticated User**: `GET /me`

## Sample Middleware (EnsureAuthenticated)

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;
use Tymon\JWTAuth\Facades\JWTAuth;

class EnsureAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            $user = null;
        }

        if (!$user && !$request->routeIs('login')) {
            return Inertia::location(route('login'));
        }

        if ($user && $request->routeIs('login')) {
            return Inertia::location(route('home'));
        }

        return $next($request);
    }
}
```

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request for any improvements or bug fixes.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
```

You can copy and paste this content into your `README.md` file. Adjust the repository URL and any other details specific to your project as needed.
