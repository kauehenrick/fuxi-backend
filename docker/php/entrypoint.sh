#!/bin/bash

set -e

# Instala dependências se necessário
if [ ! -d "vendor" ]; then
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Garante permissões mínimas
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

exec php-fpm
