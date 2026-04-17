# Dockerfile
# Imagen base de PHP 8.2 con FPM para ejecutar Laravel
# FPM (FastCGI Process Manager) permite que Nginx se comunique con PHP
FROM php:8.2-fpm

# Instalar dependencias del sistema necesarias
# git y unzip: necesarios para que Composer descargue paquetes
# libzip-dev: necesario para la extension zip de PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql bcmath zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer (gestor de dependencias de PHP)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copiar los archivos del proyecto al contenedor
COPY . .

# Exponer el puerto 9000 que usa PHP-FPM
EXPOSE 9000

# Comando para iniciar PHP-FPM
CMD ["php-fpm"]
