FROM php:8.2-apache

# Install required PHP extensions
RUN docker-php-ext-install pdo

# Fix MPM conflict - disable mpm_event and enable mpm_prefork
RUN a2dismod mpm_event && a2enmod mpm_prefork

# Enable Apache modules
RUN a2enmod rewrite

# Copy application files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port
EXPOSE 80

CMD ["apache2-foreground"]