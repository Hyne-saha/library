# Laravel Library Management System

> A Laravel-based application that allows users to manage book transactions (borrow, return, fines) and provides an admin panel for managing users and books.

## Features

- **User Authentication**: Allows users to register, log in, and manage their accounts.
- **Book Management**: Admin panel for adding, and removing books.
- **Transaction Management**: Users can borrow and return books. Admin can view all transactions.
- **Fines**: If a user does not return a book within the due date (7 days), after 7 days, each day 10rs fine will be added 
- **Admin Dashboard**: Admins can view users, books, and transactions in a table.

## Installation
Make sure you have the following installed:

- PHP (7.4 or higher)
- Composer
- MySQL (or another compatible database)

### Clone the repository

Clone the repository using Git:

**bash**
git clone https://github.com/Hyne-saha/library_management.git

**Navigate to the project repository**
cd library_management

**Install dependencies**
composer install

**Environment configuration**
cp .env.example .env

**Database setup**
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library
DB_USERNAME=root
DB_PASSWORD=


Run migrations to create the required database tables:
    php artisan migrate

**Run application**
    php artisan serve

**Application will start with:**
    http://127.0.0.1:8000


**User panel**
    http://127.0.0.1:8000/ = register
    http://127.0.0.1:8000/login = login

**Admin panel**
    http://127.0.0.1:8000/admin/adminlogin = admin login
    



