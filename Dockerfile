# Use a base image with PHP and required dependencies
FROM php:8.1-cli

# Install system dependencies
RUN apt-get update && \
    apt-get install -y libssl1.0.0 libssl-dev && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /app

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose the application port
EXPOSE 8080

# Command to run the Laravel application
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
