FROM php:8.2-cli

WORKDIR /app

# Install system dependencies (zip, unzip, git)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer


COPY . /app

COPY --from=composer:2.5 /usr/bin/composer /usr/local/bin/composer

# Install dependencies
RUN composer install