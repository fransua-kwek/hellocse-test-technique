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

# Use ARG to define environment variables passed from the Docker build command or Docker Compose.
ARG XDEBUG_ENABLED=true
ARG XDEBUG_MODE=develop,coverage,debug,profile
ARG XDEBUG_HOST=host.docker.internal
ARG XDEBUG_IDE_KEY=DOCKER
ARG XDEBUG_LOG=/dev/stdout
ARG XDEBUG_LOG_LEVEL=0

USER root

# Configure Xdebug if enabled
RUN if [ "${XDEBUG_ENABLED}" = "true" ]; then \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    echo "xdebug.mode=${XDEBUG_MODE}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.idekey=${XDEBUG_IDE_KEY}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.log=${XDEBUG_LOG}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.log_level=${XDEBUG_LOG_LEVEL}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.client_host=${XDEBUG_HOST}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ; \
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ; \
fi

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
