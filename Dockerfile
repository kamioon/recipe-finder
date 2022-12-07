FROM composer:2 as composer_stage

RUN rm -rf /var/www && mkdir -p /var/www/html
WORKDIR /var/www/html

COPY composer.json ./

RUN composer install --ignore-platform-reqs --prefer-dist --no-scripts --no-progress --no-interaction

RUN composer dump-autoload --optimize --apcu --no-dev

FROM php:8.1-cli-alpine

WORKDIR /var/www/html

COPY --from=composer_stage /var/www/html /var/www/html

COPY . /var/www/html/
RUN cp /var/www/html/.env_example /var/www/html/.env
CMD tail /var/www/html/logs/* -f