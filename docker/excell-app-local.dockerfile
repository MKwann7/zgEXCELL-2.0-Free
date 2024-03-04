FROM alpine:3

# Install packages
RUN apk --no-cache add nano curl nginx p7zip supervisor nghttp2 \
    php81 php81-fpm php81-mysqli php81-json php81-openssl php81-curl \
    php81-zlib php81-xml php81-phar php81-intl php81-dom php81-xmlreader php81-ctype php81-session \
    php81-mbstring php81-gd php81-pdo php81-pdo_pgsql php81-pdo_mysql \
    php81-posix php81-fileinfo php81-tokenizer php81-xmlwriter

# Configure nginx
COPY docker/setup/config/nginx.conf /etc/nginx/nginx.conf
# Remove default server definition
RUN rm /etc/nginx/http.d/default.conf

# Configure PHP-FPM
COPY docker/setup/config/fpm-pool.conf /etc/php81/php-fpm.d/www.conf
COPY docker/setup/config/php.ini /etc/php81/conf.d/custom.ini

# Configure supervisord
COPY docker/setup/config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

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
RUN chown -R nobody:nobody /app/excell/code && \
    chown -R nobody:nobody /app/excell/ssl && \
    chown -R nobody:nobody /app/excell/list && \
    chown -R nobody:nobody /app/excell/storage && \
    chown -R nobody:nobody /app/excell/tmp && \
    chown -R nobody:nobody /app/excell/logs && \
    chown -R nobody:nobody /app/excell/k6 && \
    chown -R nobody:nobody /run && \
    chown -R nobody:nobody /var/lib/nginx

# Make the document root a volume
#VOLUME /app/excell/code
#VOLUME /app/excell/list
#VOLUME /app/excell/tmp
#VOLUME /app/excell/logs

COPY docker/ssl/ssl.zip /app/excell/storage/ssl
RUN 7z e /app/excell/storage/ssl/ssl.zip -o/app/excell/ssl -y > nul
RUN chown -R nobody:nobody /app/excell/ssl
RUN chown -R nobody:nobody /app/excell/logs
RUN chown -R nobody:nobody /app/excell/tmp
RUN chmod -R 777 /app/excell/ssl
RUN chmod -R 777 /app/excell/list
RUN chmod -R 777 /app/excell/tmp

# Switch to use a non-root user from here on
USER nobody

# Add application
WORKDIR /app/excell/code
COPY --chown=nobody src /app/excell/code

#COPY docker/env/excell-app-local.env /app/excell/code/.env
#COPY docker/ssl/ssl.zip /app/excell/storage/ssl
#RUN 7z e /app/excell/storage/ssl/ssl.zip -o/app/excell/ssl -y > nulp7zip

# Expose the port nginx is reachable on
EXPOSE 8080 4443

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://localhost:8080/fpm-ping
