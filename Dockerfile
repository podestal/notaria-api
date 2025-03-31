# # # Use PHP 7.4 since it supports both 5.3.3+ and 7.x
# # FROM php:7.4-cli

# # # Set working directory inside container
# # WORKDIR /var/www

# # # Install system dependencies
# # RUN apt-get update && apt-get install -y unzip curl mariadb-client

# # # Install Composer
# # RUN curl -sS https://getcomposer.org/installer | php && \
# #     mv composer.phar /usr/local/bin/composer

# # # Copy project files into the container
# # COPY . .

# # # Install PHP dependencies for PHPWord
# # WORKDIR /var/www/notarios/PHPWord
# # RUN composer install --no-dev --optimize-autoloader || true

# # # Switch back to main project directory
# # WORKDIR /var/www/notarios

# # # Expose port 8000 for development
# # EXPOSE 8000

# # # Run the built-in PHP server
# # CMD ["php", "-S", "0.0.0.0:8000"]

# # Use PHP 7.4 with FPM
# FROM php:7.4-fpm

# # Set working directory inside container
# WORKDIR /var/www

# # Install system dependencies
# RUN apt-get update && apt-get install -y \
#     unzip \
#     curl \
#     mariadb-client \
#     libonig-dev \
#     libzip-dev \
#     zip \
#     && docker-php-ext-install mysqli pdo pdo_mysql

# # Install Composer
# RUN curl -sS https://getcomposer.org/installer | php && \
#     mv composer.phar /usr/local/bin/composer

# # Copy project files into the container
# COPY . .

# # Install PHP dependencies for PHPWord
# WORKDIR /var/www/notarios/PHPWord
# RUN composer install --no-dev --optimize-autoloader || true

# # Switch back to main project directory
# WORKDIR /var/www/notarios

# # Expose PHP-FPM port
# EXPOSE 9000

# # Run PHP-FPM
# CMD ["php", "-S", "0.0.0.0:8000"]

# Use PHP 7.4 with FPM
# FROM php:7.4-fpm

# # Set working directory inside container
# WORKDIR /var/www

# # Install system dependencies
# RUN apt-get update && apt-get install -y \
#     unzip \
#     curl \
#     mariadb-client \
#     libonig-dev \
#     libzip-dev \
#     zip \
#     && docker-php-ext-install mysqli pdo pdo_mysql

# # Install Composer
# RUN curl -sS https://getcomposer.org/installer | php && \
#     mv composer.phar /usr/local/bin/composer

# # Copy project files into the container
# COPY . .

# # Install PHP dependencies for PHPWord
# WORKDIR /var/www/notarios/PHPWord
# RUN composer install --no-dev --optimize-autoloader || true

# # Switch back to main project directory
# WORKDIR /var/www/notarios

# # Expose PHP-FPM port
# EXPOSE 9000

# # Start PHP-FPM instead of built-in server
# CMD ["php-fpm"]

FROM php:7.4-fpm

# Set working directory inside container
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    mariadb-client \
    libonig-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Copy project files into the container
COPY . .

# Install PHP dependencies for the main project (notarios)
WORKDIR /var/www/notarios
RUN composer install --no-dev --optimize-autoloader || true

# Install PHP dependencies for PHPWord
WORKDIR /var/www/notarios/PHPWord
RUN composer install --no-dev --optimize-autoloader || true

# Switch back to main project directory
WORKDIR /var/www/notarios

# Expose PHP-FPM port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]


