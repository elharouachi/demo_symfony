FROM php:7.4

RUN apt-get update && apt-get install -y git
# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définition du répertoire de travail
WORKDIR /var/www

# Copie du code de l'application
COPY . /var/www

# Installation des dépendances
RUN composer install