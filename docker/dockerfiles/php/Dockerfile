FROM php:8.3.14-fpm
WORKDIR /projects

ADD . /projects

RUN chmod -R 664 /projects
RUN chown 1000:1000 /projects

RUN apt-get update && apt-get install -y zlib1g-dev libxml2-dev libicu-dev g++ \
    imagemagick libmagickwand-dev --no-install-recommends \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxpm-dev \
    libzip-dev \
    libwebp-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    nano \
    exif \
    unzip \
    curl \
    git \
    yarn \
    wget \
    #php8.1-soap \
    libmcrypt-dev \
    && docker-php-ext-install zip \
    && pecl install imagick \
    && docker-php-ext-install gd \
    && docker-php-ext-enable imagick \
    && docker-php-ext-configure gd --enable-gd  --with-freetype --with-jpeg --with-webp\
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install exif \
    && docker-php-ext-configure exif \
    && docker-php-ext-install soap \
    && docker-php-ext-configure soap \
    && docker-php-ext-install intl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install fileinfo \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install ctype \
    && docker-php-ext-install sockets \
    ##&& docker-php-ext-install tokenizer \
    && docker-php-ext-install xml \
    && docker-php-ext-install iconv \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && docker-php-ext-install pcntl \
    && docker-php-ext-enable pcntl \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_16.x | bash && \
    apt-get -y install nodejs && \
    ln -s /usr/bin/nodejs /usr/local/bin/node

RUN node -v
