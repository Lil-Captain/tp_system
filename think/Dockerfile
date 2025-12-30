FROM php:8.1-fpm

# 设置非交互模式，避免构建时等待用户输入
ENV DEBIAN_FRONTEND=noninteractive

# 安装系统依赖和 MySQL 扩展
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    mysqli \
    gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

