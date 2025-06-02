FROM php:8.2-fpm-alpine

# Mettre à jour le cache APK et installer les dépendances
RUN apk update && \
    apk add --no-cache \
    sqlite \
    sqlite-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    autoconf \
    g++ \
    gcc \
    make \
    && docker-php-ext-install pdo_sqlite zip \
    && apk del autoconf g++ gcc make

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /app

# Copier le code du microservice
COPY . .
COPY .env /app/.env

# Débogage : Vérifier les fichiers copiés
RUN ls -la /app

# Installer les dépendances PHP via Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Créer le répertoire et le fichier avec les bonnes permissions
RUN mkdir -p /app/database && \
    touch /app/database/database.sqlite && \
    chown -R www-data:www-data /app/database && \
    chmod -R 775 /app/database


# Exécuter les migrations
RUN php artisan migrate --force

# Exposer le port
EXPOSE 8003

# Commande pour démarrer
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8003"]