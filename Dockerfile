FROM php:8.2-fpm

# Installer extensions nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Régler le timezone
RUN ln -snf /usr/share/zoneinfo/Europe/Paris /etc/localtime \
    && echo "Europe/Paris" > /etc/timezone

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier d’abord composer.json pour tirer parti du cache Docker
COPY composer.json composer.lock* ./

# Installer les dépendances
RUN composer install --no-dev --optimize-autoloader

# Copier le reste du projet
COPY . .

# Générer autoload au cas où
RUN composer dump-autoload --optimize