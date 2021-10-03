FROM php:7.4-cli
RUN docker-php-ext-install pcntl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /usr/src/LeadProcessor
WORKDIR /usr/src/LeadProcessor
RUN composer install
CMD [ "php", "./run.php"]