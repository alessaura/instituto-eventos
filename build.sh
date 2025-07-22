#!/bin/bash

echo "🚀 Iniciando build do Instituto de Embalagens..."

# Instalar dependências PHP
echo "📦 Instalando dependências PHP..."
composer install --no-dev --optimize-autoloader

# Instalar dependências Node.js
echo "📦 Instalando dependências Node.js..."
npm install

# Build dos assets
echo "🔨 Compilando assets..."
npm run build

# Cache de configurações
echo "⚡ Otimizando aplicação..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Executar migrations
echo "🗄️ Executando migrations..."
php artisan migrate --force

echo "✅ Build concluído com sucesso!"

