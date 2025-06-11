FROM richarvey/nginx-php-fpm:3.1.6

# Copy all project files
COPY . .

# Copy custom nginx config to where nginx expects it
COPY conf/nginx/nginx-site.conf /etc/nginx/conf.d/default.conf

# Make scripts executable
RUN chmod +x /scripts/laravel-deploy.sh /scripts/start.sh

# Set environment variables
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# Run start script on container launch
CMD ["/scripts/start.sh"]


