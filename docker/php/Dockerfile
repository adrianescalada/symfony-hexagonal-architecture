FROM php:8.2-fpm-buster
ARG TIMEZONE

LABEL maintainer="Adrian <adrianescalada@gmail.com>"

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-configure gd --with-jpeg --with-freetype 

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

# Copy the input script
COPY ./entrypoint.sh /usr/local/bin/entrypoint.sh

# Set execution permissions on the input script
RUN chmod +x /usr/local/bin/entrypoint.sh

# Print the contents of the directory to the container (for debugging purposes)
RUN ls -al

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/symfony

# Set the entry script as the default command when starting the container
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]