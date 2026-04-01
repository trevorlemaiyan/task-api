FROM php:8.2-cli

# Install system dependencies needed for Laravel and MySQL
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory inside the container
WORKDIR /app

# Copy your actual project files into the container
COPY . .

# Install Laravel's PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Start the built-in server on the port Render assigns
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}