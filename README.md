## About
This app was build to help manage the daily tasks inside a team.
I have build this app using Laravel 7+ for backend and VueJS with Tailwind CSS for the frontend.

## Instalation Steps:
1. ``git clone https://github.com/lartisan/laravel-tasks-app.git``;
2. After you ``cd`` into the directory, run ``composer install``;
3. Then copy the environment file with ``cp .env.example .env`` and fill the credentials to connect to the database ``vim .env``;
4. Run ``php artisan key:generate``;
5. Migrate and seed the database ``php artisan migrate --seed``;
6. Install the frontend dependencies with ``npm install && npm run dev``;
7. Finally, run the dev server with ``php artisan serve``.

## Demo users:
- Admin: admin@example.com
- Manager: manager@example.com
- Team Leader: teamleader@example.com
- Staff: staff@example.com

***One password for all: parola123***
