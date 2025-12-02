FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nginx \
    supervisor

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Obter Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www/html

# Copiar configuração do nginx
COPY docker/nginx/default.conf /etc/nginx/sites-available/default

# Copiar configuração do supervisor
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Criar usuário para a aplicação
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copiar arquivos da aplicação
COPY --chown=www:www . /var/www/html

# Ajustar permissões
RUN chown -R www:www /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Expor porta 80
EXPOSE 80

# Iniciar supervisor
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
