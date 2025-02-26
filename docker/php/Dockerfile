# Utilisation de la dernière image PHP 8.3 avec support FPM
FROM php:8.3-fpm

# Mise à jour des paquets système et installation des dépendances requises
RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip \
    curl \
    libpq-dev \
    libonig-dev \
    libssl-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        pgsql \
        mbstring \
        xml \
        zip \
        bcmath \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers du projet Laravel dans le conteneur
COPY ../.. /var/www

# Installation des dépendances PHP via Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist

# Donner les permissions correctes au répertoire storage et bootstrap
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Exposer le port 9000 (par défaut pour PHP-FPM)
EXPOSE 9000

# Commande par défaut
CMD ["php-fpm"]
