# Use official PHP image with Apache
FROM php:8.2-apache

# Install MySQL extension for PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files to Apache web root
COPY . /var/www/html/

# enable ouptput buffering
RUN echo "output_buffering=On" > /usr/local/etc/php/conf.d/output-buffering.ini

# Enable Apache mod_rewrite (if needed)
RUN a2enmod rewrite

# Set permissions (optional, depending on your project)
RUN chown -R www-data:www-data /var/www/html

# Expose port
EXPOSE 80
