web: php artisan migrate --force && php artisan serve --host 0.0.0.0 --port ${PORT:-8000}
worker: php artisan mqtt:subscribe
reverb: php artisan reverb:start --host=0.0.0.0 --port=${PORT:-8080} --no-interaction
