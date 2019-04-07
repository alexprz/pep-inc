php symfony/bin/console cache:clear --env=dev
php symfony/bin/console assetic:dump --env=dev --no-debug
php symfony/bin/console cache:clear --env=prod
php symfony/bin/console assetic:dump --env=prod --no-debug
php symfony/bin/console assets:install --symlink

# php bin/console cache:clear --env=dev
# php bin/console assetic:dump --env=dev --no-debug
# php bin/console cache:clear --env=prod
# php bin/console assetic:dump --env=prod --no-debug
# php bin/console assets:install --symlink
