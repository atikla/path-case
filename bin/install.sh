# remove cache and logs
rm -rf ./var ./vendor
# composer install
composer install --no-cache
# DB DROP
php bin/console doctrine:database:drop --force --if-exists
# DB CREATE
php bin/console doctrine:database:create
# DB MIGRATION AND INITIAL DATA
php bin/console doctrine:migrations:migrate -q
# FIXTURES FOR DEV ENV
php bin/console doctrine:fixtures:load -q
echo "DB migrations and seeding ready."
echo "generating keypair for jwt"
# generating keypair for jwt
php bin/console lexik:jwt:generate-keypair --skip-if-exists
echo "Done!"
