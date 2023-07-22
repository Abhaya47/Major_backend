cd /var/www/html/Major_backend
chown -R www-data:www-data storage
php artisan key:generate
php artisan migrate
