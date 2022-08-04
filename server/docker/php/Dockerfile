FROM php:7.4.12-fpm-alpine as core

STOPSIGNAL SIGTERM

# Set working directory
WORKDIR /var/www

ENV MUSL_LOCALE_DEPS cmake make musl-dev gcc gettext-dev libintl

RUN apk add --no-cache \
	$MUSL_LOCALE_DEPS \
	&& wget https://gitlab.com/rilian-la-te/musl-locales/-/archive/master/musl-locales-master.zip \
	&& unzip musl-locales-master.zip \
	&& cd musl-locales-master \
	&& cmake -DLOCALE_PROFILE=OFF -D CMAKE_INSTALL_PREFIX:PATH=/usr . && make && make install \
	&& cd .. && rm -r musl-locales-master

# Install dependencies
RUN apk update && apk  add --update --no-cache \
	build-base \
	libpng-dev  \
	libzip-dev \
	zip \
	jpegoptim \
	optipng \
	pngquant \
	gifsicle \
	libjpeg-turbo-dev \
	freetype-dev \
	oniguruma-dev \
	tini

# Install extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl opcache \
	&& docker-php-ext-configure gd --enable-gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
	&& docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN addgroup -g 1000 www \
	&& adduser --uid 1000 --ingroup www --disabled-password --home /home/www www

# originally /usr/local/bin/docker-php-entrypoint
COPY docker/php/entrypoint.sh /usr/local/bin/docker-php-entrypoint

COPY docker/php/php.ini "$PHP_INI_DIR/php.ini"

# Copy existing application directory permissions
COPY --chown=www:www . /var/www
RUN composer install -n --prefer-dist

RUN > .phpunit.result.cache && chown www:www .phpunit.result.cache

# Expose port 9000 and start php-fpm server
EXPOSE 9000

# Change current user to www
USER www

FROM core as batch
USER root

RUN apk add bash jq

RUN apk add --no-cache \
        python3 \
        py3-pip \
    && pip3 install --upgrade pip \
    && pip3 install \
        awscli \
    && rm -rf /var/cache/apk/*

COPY docker/php/entrypoint_batch.sh docker/php/worker.sh /usr/local/bin/

USER www

ENTRYPOINT ["tini", "--", "entrypoint_batch.sh"]
CMD ["worker.sh"]

USER www

FROM core as debug
USER root
RUN apk update && apk add --update --no-cache \
    alpine-sdk autoconf && \
    apk add --update --no-cache \
    vim \
    unzip \
    git \
    procps \
    curl && \
    pecl install xdebug-2.9.6 && \
    docker-php-ext-enable xdebug
RUN touch /var/log/xdebug.log && chmod 666 /var/log/xdebug.log
USER www
