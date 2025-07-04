FROM php:7.4-apache

# Install mysql so that php can talk with mysql
RUN docker-php-ext-install mysqli

# Copy the php app
COPY index.php .

# Expose Apache
EXPOSE 80

# Defautl command to run Apache
CMD ["apache2-foreground"]