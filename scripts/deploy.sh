#!/usr/bin/env bash
set -euo pipefail

APP_DIR="${APP_DIR:-/var/www/supermarche}"
APP_ENV_FILE="${APP_ENV_FILE:-${APP_DIR}/.env}"

if [ ! -d "$APP_DIR" ]; then
  echo "Dossier de déploiement introuvable : $APP_DIR"
  exit 1
fi

cd "$APP_DIR"

if [ -f ".env" ]; then
  echo ".env exists"
else
  cp .env.example .env || true
fi

composer install --no-interaction --prefer-dist --no-progress --no-dev --optimize-autoloader
npm ci --omit=dev
npm run build

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

chown -R www-data:www-data "$APP_DIR"
chmod -R 775 storage bootstrap/cache

if command -v systemctl >/dev/null 2>&1; then
  systemctl reload nginx || systemctl reload php8.3-fpm || true
fi

echo "Déploiement Laravel terminé."
