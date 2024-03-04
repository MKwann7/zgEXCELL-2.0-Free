FROM alpine:3

# Install packages
RUN apk --no-cache add nano curl nginx p7zip supervisor nghttp2 \
    php8 php8-fpm php8-mysqli php8-json php8-openssl php8-curl \
    php8-zlib php8-xml php8-phar php8-intl php8-dom php8-xmlreader php8-ctype php8-session \
    php8-mbstring php8-gd php8-pdo php8-pdo_pgsql php8-pdo_mysql \
    php8-posix php8-fileinfo php8-tokenizer php8-xmlwriter

# Configure nginx
COPY docker/setup/config/nginx.conf /etc/nginx/nginx.conf
# Remove default server definition
RUN rm /etc/nginx/http.d/default.conf

# Configure PHP-FPM
COPY docker/setup/config/fpm-pool.conf /etc/php8/php-fpm.d/www.conf
COPY docker/setup/config/php.ini /etc/php8/conf.d/custom.ini

# Configure supervisord
COPY docker/setup/config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Switch to use a non-root user from here on
USER nobody

# Setup document root
RUN mkdir -p /app/excell/code
RUN mkdir -p /app/excell/logs
RUN mkdir -p /app/excell/k6
RUN mkdir -p /app/excell/ssl
RUN mkdir -p /app/excell/list
RUN mkdir -p /app/excell/storage
RUN mkdir -p /app/excell/storage/core
RUN mkdir -p /app/excell/storage/ssl
RUN mkdir -p /app/excell/storage/uploads
RUN mkdir -p /app/excell/list/commands
RUN mkdir -p /app/excell/storage/modules
RUN mkdir -p /app/excell/storage/modules/company
RUN mkdir -p /app/excell/tmp
RUN addgroup nobody xfs

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /app/excell/code && \
    chown -R nobody.nobody /app/excell/ssl && \
    chown -R nobody.nobody /app/excell/list && \
    chown -R nobody.nobody /app/excell/storage && \
    chown -R nobody.nobody /app/excell/tmp && \
    chown -R nobody.nobody /app/excell/logs && \
    chown -R nobody.nobody /app/excell/k6 && \
    chown -R nobody.nobody /run && \
    chown -R nobody.nobody /var/lib/nginx && \
    chown -R nobody.nobody /var/log/nginx

# Make the document root a volume
#VOLUME /app/excell/code
#VOLUME /app/excell/list
#VOLUME /app/excell/tmp
#VOLUME /app/excell/logs

# Switch to root user
USER root

COPY docker/ssl/ssl.zip /app/excell/storage/ssl
RUN 7z e /app/excell/storage/ssl/ssl.zip -o/app/excell/ssl -y > nul
RUN chown -R nobody.nobody /app/excell/ssl
RUN chmod -R 777 /app/excell/ssl
RUN chmod -R 777 /app/excell/list

# Switch to use a non-root user from here on
USER nobody

# Add application
WORKDIR /app/excell/code
COPY --chown=nobody src /app/excell/code

#COPY docker/env/excell-app-dev.env /app/excell/code/.env
COPY docker/ssl/ssl.zip /app/excell/storage/ssl
RUN 7z e /app/excell/storage/ssl/ssl.zip -o/app/excell/ssl -y > nulp7zip

# Expose the port nginx is reachable on
EXPOSE 8080 4443

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://localhost:8080/fpm-ping
