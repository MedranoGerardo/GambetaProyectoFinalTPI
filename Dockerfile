# ---------------------------------------------------------
# Imagen base PHP 8.2 con Apache (compatible Laravel 12)
# ---------------------------------------------------------
FROM php:8.2-apache

# ---------------------------------------------------------
# Instalar dependencias del sistema
# ---------------------------------------------------------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring xml bcmath zip gd intl

# ---------------------------------------------------------
# Habilitar mod_rewrite para Laravel
# ---------------------------------------------------------
RUN a2enmod rewrite

# ---------------------------------------------------------
# Configurar DocumentRoot a /public
# ---------------------------------------------------------
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf

# ---------------------------------------------------------
# Agregar configuración para permitir .htaccess
# ---------------------------------------------------------
RUN printf "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n" \
    > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# ---------------------------------------------------------
# Instalar Composer dentro del contenedor
# ---------------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ---------------------------------------------------------
# Permisos correctos para Laravel (evita Permission Denied)
# ---------------------------------------------------------
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ---------------------------------------------------------
# Directorio de trabajo
# ---------------------------------------------------------
WORKDIR /var/www/html

# ---------------------------------------------------------
# Puerto expuesto
# ---------------------------------------------------------
EXPOSE 80