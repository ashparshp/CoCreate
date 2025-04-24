# CoCreate – Laravel Project Setup Guide

This guide will help you set up and run the CoCreate Laravel application on your local machine.

---

## 1. Clone the Repository

```bash
git clone https://github.com/ashparshp/CoCreate.git
cd CoCreate
```

---

## 2. Create the SQLite Database

Create an empty SQLite database file inside the `database/` directory:

```bash
touch database/database.sqlite
```

---

## 3. Configure the Environment

Create a `.env` file in the root directory and paste the following configuration:

```
APP_NAME=CoCreate
APP_ENV=local
APP_KEY=base64:mgT1x8WCLHr4tClNNs1rTIxCP2DLn/xG4AwwrtabHIE=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=ashparsh63@gmail.com
MAIL_PASSWORD=hjjchrpmplohiklb
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@cocreate.tech
MAIL_FROM_NAME="CoCreate"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="CoCreate"
```

---

## 4. Install Dependencies

Install PHP and JavaScript dependencies:

```bash
composer install
npm install
npm run build
```

---

## 5. Generate the Application Key

```bash
php artisan key:generate
```

---

## 6. Set Up the Database

Run database migrations:

```bash
php artisan migrate
```

Create the session and queue tables:

```bash
php artisan session:table
php artisan queue:table
php artisan migrate
```

---

## 7. Start the Development Server

```bash
php artisan serve
```

Then open your browser and go to:

```
http://localhost:8000
```

---

## 8. Create Admin User (Optional)

To create a default admin user, run:

```bash
php artisan tinker
```

Then paste this code:

```php
\App\Models\User::updateOrCreate(
    ['email' => 'admin@cocreate.com'],
    [
        'name' => 'Administrator',
        'password' => \Illuminate\Support\Facades\Hash::make('cocreate@admin'),
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]
);
```

---

You’re now ready to use the CoCreate application.
