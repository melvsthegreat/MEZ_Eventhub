# Laravel SaaS Application

A simple SaaS application built with Laravel, featuring user roles, transactions, and dashboards.

## Features

- User authentication (login/register)
- Role-based access control (admin/client)
- Transaction management
- Separate dashboards for admin and clients
- Bootstrap styling

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL
- Node.js & NPM

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd <project-directory>
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Create a copy of the environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in the `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

7. Run database migrations and seeders:
```bash
php artisan migrate --seed
```

8. Build assets:
```bash
npm run build
```

9. Start the development server:
```bash
php artisan serve
```

## Default Users

After running the seeders, you can log in with these credentials:

### Admin User
- Email: admin@example.com
- Password: password

### Client Users
- Multiple test clients are created with random credentials
- You can register new client accounts through the registration page

## Usage

1. Access the application at `http://localhost:8000`
2. Log in with the admin credentials or register a new account
3. Navigate through the dashboard and transaction pages
4. Admins can view all transactions and filter them
5. Clients can create and view their own transactions

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
