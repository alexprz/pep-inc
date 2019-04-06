/usr/sbin/sshd -D &
php-fpm &
composer install &
chmod 777 -R var/cache && chmod 777 -R var/logs
