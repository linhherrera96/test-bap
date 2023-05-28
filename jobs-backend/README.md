
- Step 1:
Install composer.
Link: https://getcomposer.org/doc/00-intro.md#using-the-installer

<!-- You can specify the filename (default: composer.phar) using the --filename option. Example: -->
<!-- php composer-setup.php --version=1.0.0-alpha8 -->

- Step 2:
Run cmd: composer install

- Step 3:
Run cmd: composer update

- Step 4:
Run cmd: npm install

- Step 5:
php artisan storage:link

- Step 6: setting DB
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

- Step 7: reload config 
php artisan config:cache

- Step 8: migrate DB
Run cmd: php artisan migrate:fresh --seed

- Step 9:
Run cmd: php artisan serve