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
    libzip-dev \
    libicu-dev \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP necessárias
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar Composer para root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Definir diretório de trabalho
WORKDIR /var/www

# Criar diretórios necessários ANTES do composer
RUN mkdir -p bootstrap/cache storage/logs storage/framework/sessions storage/framework/views storage/framework/cache/data

# Copiar composer files primeiro
COPY composer.json composer.lock ./

# Instalar dependências sem scripts
RUN composer install --optimize-autoloader --no-dev --no-scripts

# Copiar resto dos arquivos
COPY . .

# Definir permissões corretas
RUN chmod -R 775 storage bootstrap/cache

# Instalar dependências JS e build
RUN npm install && npm run build

# Gerar autoload SEM package discovery (causa problema)
RUN composer dump-autoload --optimize --no-scripts

# Expor porta
EXPOSE 10000

# Comando de inicialização
CMD php artisan config:cache && \
    php artisan migrate --force && \
    php artisan serve --host 0.0.0.0 --port 10000
