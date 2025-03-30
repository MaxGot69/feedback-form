FROM php:8.2-apache

# Устанавливаем MySQLi и другие зависимости
RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    docker-php-ext-enable mysqli

# Включаем отображение ошибок (для разработки)
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/errors.ini && \
    echo "display_errors = On" >> /usr/local/etc/php/conf.d/errors.ini

# Включаем mod_rewrite для Apache (опционально)
RUN a2enmod rewrite