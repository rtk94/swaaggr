# Use the official PHP 8.2 with Apache image:
FROM php:8.2-apache

# Enable Apache mod-rewrite
RUN a2enmod rewrite

# Copy source files from local 'src' to the container's web root
COPY src/ /var/www/html/

# Create the data directory structure inside the container.
# This ensures the mount point exists and has correct ownership.
RUN mkdir -p /var/www/html/data

# Give the Apache user (www-data) ownership of the web root.
# This allows the script to write to the 'data' folder.
RUN chown -R www-data:www-data /var/www/html/
