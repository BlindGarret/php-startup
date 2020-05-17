# build stage
FROM php:7.4-fpm-alpine3.11 as build-stage
WORKDIR /build
COPY --from=composer /usr/bin/composer /usr/bin/composer
# Install dependencies
COPY . . 
RUN composer  \
    --no-ansi \
    --no-interaction \
    --optimize-autoloader \
    --no-progress \
    --no-dev \
    --profile \
    install
# Clean up image
RUN composer dump-autoload --optimize --no-dev

# run stage
FROM php:7.4-fpm-alpine3.11 as run-stage
RUN apk update; \
    apk upgrade;
RUN docker-php-ext-install pdo_mysql
COPY --from=build-stage /build/public /build/src /build/vendor ./