@servers(['web' => ['root@185.241.63.153']])

@task('deploy', ['on' => 'web'])
cd /var/www/mucahit
git pull
php artisan migrate --force
php artisan optimize:clear
@endtask
