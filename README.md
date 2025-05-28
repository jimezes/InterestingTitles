# InterestingTitles

**InterestingTitles** is a web application built with **Laravel 12** and using **Inertia.js** with **Vue 3** that lets users search, categorize, and save books they find interesting by querying the [Open Library API](https://openlibrary.org/dev/docs/api/). It offers a clean interface to discover new books and organize your favorites.
This project is configured to run locally using [Laravel Herd](https://laravel.com/docs/12.x/herd), a simple local development environment for Laravel.

---

## Features

- Search books via Open Library API  
- Browse categorized book lists  
- Save and manage your favorite titles  
- Responsive and interactive UI powered by Vue 3  
- Backend API built with Laravel for smooth data handling



### Requirements

Make sure you have the following installed on your machine:

- [Laravel Herd](https://laravel.com/docs/12.x/herd) (recommended for macOS)
- PHP 8.2 or 8.3 (Herd includes this)
- Node.js v22+
- npm
- MySQL
- Git

---

### 1. Clone the Repository

```bash
git clone https://github.com/jimezes/InterestingTitles.git
cd InterestingTitles
composer install
npm install
create a MySQL database and give it a name of your preference
create a .env file and add set with your local URL and properties:
---
APP_NAME="Interesting Titles"
APP_URL=http://InterestingTitles.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_mysql_username
DB_PASSWORD=your_mysql_password

run php artisan key:generate
run php artisan migrate

Open Laravel Herd.

Add the InterestingTitles project directory to your Herd sites.

Herd will automatically configure a local domain such as http://InterestingTitles.test.

npm run dev

Visit http://InterestingTitles.test in your browser.

