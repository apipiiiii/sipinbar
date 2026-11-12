FROM richarvey/nginx-php-fpm:3.1.6

COPY . .

# Ubah port Nginx dari 80 ke 7860 (Wajib untuk Hugging Face Spaces)
RUN sed -i 's/listen 80;/listen 7860;/g' /etc/nginx/sites-available/default.conf \
    && sed -i 's/listen \[::\]:80;/listen \[::\]:7860;/g' /etc/nginx/sites-available/default.conf

# Beri hak akses penuh ke folder storage dan cache Laravel
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

EXPOSE 7860

CMD ["/start.sh"]