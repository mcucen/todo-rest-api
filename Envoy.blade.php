@servers(['web' => ['root@185.241.63.153']])

@task('deploy', ['on' => 'web'])
cd /var/www/mucahit
git pull
mkdir -p bootstrap/cache
chmod -R 0777 bootstrap/cache
php artisan migrate --force
php artisan optimize:clear
@endtask
