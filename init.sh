cd /var/www/Major_backend
if [ ! -f .env ]; then
    cp .env.example .env
fi
chown -R www-data:www-data storage
php artisan key:generate
php artisan migrate
