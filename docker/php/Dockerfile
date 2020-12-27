FROM php:7.4-fpm as praga_backend

#Install environment
RUN apt-get update \
 && apt-get install -y software-properties-common locales apt-utils gnupg libpng-dev libzip-dev zlib1g-dev libicu-dev g++ unzip zip \
 && rm -rf /var/lib/apt/lists/* \
 && localedef -i ru_RU -c -f UTF-8 -A /usr/share/locale/locale.alias ru_RU.UTF-8
ENV LANG ru_RU.utf8

# Install DB extensions
RUN apt-get update \
 && apt-get install -y unixodbc unixodbc-dev tdsodbc postgresql libpq-dev \
 && mkdir -p /app

# PHP extension install
RUN set -ex; \
    docker-php-source extract; \
    { \
        echo '# https://github.com/docker-library/php/issues/103#issuecomment-271413933'; \
        echo 'AC_DEFUN([PHP_ALWAYS_SHARED],[])dnl'; \
        echo; \
        cat /usr/src/php/ext/odbc/config.m4; \
    } > temp.m4; \
    mv temp.m4 /usr/src/php/ext/odbc/config.m4; \
    docker-php-ext-configure odbc --with-unixODBC=shared,/usr; \
    docker-php-ext-install odbc; \
    docker-php-source delete
RUN docker-php-ext-configure pgsql \
 && docker-php-ext-install pgsql \
 && docker-php-ext-enable pgsql \
 && docker-php-ext-configure sockets \
 && docker-php-ext-install sockets \
 && docker-php-ext-enable sockets \
 && docker-php-ext-configure gd \
 && docker-php-ext-install gd \
 && docker-php-ext-enable gd \
 && docker-php-ext-configure intl \
 && docker-php-ext-install intl \
 && docker-php-ext-enable intl \
 && docker-php-ext-configure pdo_pgsql \
 && docker-php-ext-install pdo_pgsql \
 && docker-php-ext-enable pdo_pgsql \
 && docker-php-ext-configure zip \
 && docker-php-ext-install zip \
 && docker-php-ext-enable zip \
# Composer install
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \

WORKDIR /app/backend

COPY docker/php/conf /usr/local/etc/php-fpm.d
COPY app/backend /app/backend

RUN cd /app/backend/ && composer install && chown -R www-data:www-data /app/backend && mkdir -p /logs && chown -R www-data:www-data /logs && chmod -R 0766 /logs

COPY docker/php/migrate.sh /app

RUN chmod +x /app/migrate.sh

ENTRYPOINT ["/app/migrate.sh"]

EXPOSE 65535
