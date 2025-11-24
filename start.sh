#!/bin/bash
set -e

echo "🚀 Starting Aura Experience..."

# Crear directorios necesarios
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache
mkdir -p public/build

# Dar permisos
chmod -R 775 storage bootstrap/cache

# Verificar que los assets existen
if [ ! -d "public/build" ]; then
    echo "⚠️  Build directory not found, creating..."
    npm run build
fi

# Ejecutar migraciones
echo "📦 Running migrations..."
php artisan migrate --force

# Ejecutar seeders
echo "🌱 Seeding database..."
php artisan db:seed --force 2>/dev/null || echo "Seeders already run"

# Crear enlace de storage
echo "🔗 Creating storage link..."
php artisan storage:link 2>/dev/null || echo "Storage link exists"

# Limpiar cache anterior
echo "🧹 Clearing old cache..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cachear para producción
echo "📝 Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✨ Starting server on port $PORT..."
php -S 0.0.0.0:$PORT -t public
