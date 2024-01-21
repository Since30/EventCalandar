# Utiliser l'image PHP avec Apache
FROM php:8.1-apache

# Installer les extensions PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copier les fichiers du projet
COPY . /var/www/html/

# Configurer Apache
RUN a2enmod rewrite
