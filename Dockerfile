FROM php:8.3-cli

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    nodejs \
    npm

# Instalar extensões PHP necessárias para Laravel
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar composer files primeiro (para cache)
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-dev --no-scripts

# Copiar resto dos arquivos
COPY . .

# Instalar dependências JS e build
RUN npm install && npm run build

# Finalizar instalação do Composer
RUN composer dump-autoload --optimize

# Criar diretórios necessários e permissões
RUN mkdir -p storage/logs storage/framework/sessions storage/framework/views storage/framework/cache/data \
    && chmod -R 775 storage bootstrap/cache

# Expor porta
EXPOSE 10000

# Comando de inicialização
CMD php artisan config:cache && \
    php artisan migrate --force && \
    php artisan serve --host 0.0.0.0 --port 10000
EOF