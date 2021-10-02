FROM php:7.4-cli
RUN docker-php-ext-install pcntl
COPY . /usr/src/LeadProcessor
WORKDIR /usr/src/LeadProcessor
CMD "composer install"
CMD [ "php", "./run.php"]