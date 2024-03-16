FROM php:7.4-fpm

ENV TZ Asia/Tokyo

RUN apt-get update
RUN apt-get install -y git vim unzip libzip-dev libicu-dev libonig-dev
RUN apt-get install -y unzip libpq-dev
RUN apt-get install -y unzip libfreetype6-dev
RUN apt-get install -y unzip libjpeg62-turbo-dev
RUN apt-get install -y unzip libpng-dev
RUN docker-php-ext-configure gd  --with-freetype --with-jpeg
RUN docker-php-ext-install intl pdo_mysql zip bcmath
RUN docker-php-ext-install -j$(nproc) gd
RUN apt-get install -y curl gnupg
RUN apt-get install -y default-mysql-client
RUN apt-get install -y nodejs npm
RUN apt-get install -y gnupg
RUN apt-get install -y cron
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install -y nodejs

COPY ./docker/app/php.ini /usr/local/etc/php/php.ini
# COPY ./docker/app/ca-bundle.crt /usr/local/etc/php/

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

RUN pecl install xdebug-3.1.6 \
&& docker-php-ext-enable xdebug

WORKDIR /app

# cron
# 毎日6時30分
RUN echo "30 06 * * * root /var/www/html/bin/cake backup >> /var/log/cron.log 2>&1" >> /etc/crontab
# 毎時0分
RUN echo "0 * * * * root /var/www/html/bin/cake save_new_photos_rank >> /var/log/cron.log 2>&1" >> /etc/crontab
# 毎時5分
RUN echo "5 */1 * * * root /var/www/html/bin/cake analytics_report >> /var/log/cron.log 2>&1" >> /etc/crontab
# 毎時10分
# TODO: 料金取れるようになってからサービスプラン変更バッチは開始する
# RUN echo "10 */1 * * * root /var/www/html/bin/cake change_service_plan >> /var/log/cron.log 2>&1" >> /etc/crontab

RUN touch /var/log/cron.log
CMD ["cron", "-f"]
# COPY ./docker_startup_cmd.sh /docker_startup_cmd.sh
# RUN chmod 744 ./docker_startup_cmd.sh
# CMD sh -c "cron -f && \
#   sudo chmod 0555 /var/www/html/bin/cake && \
#   sudo chmod 0555 /var/www/html/bin/cake.bat && \
#   sudo chmod 0555 /var/www/html/bin/cake.php"

# # cron
# # 毎日6時30分
# RUN echo '06 30 * * * root /var/www/html/bin/cake backup' >> /etc/crontab
# # 毎時0分
# RUN echo '*/1 * * * * root /var/www/html/bin/cake save_new_photos_rank' >> /etc/crontab
# # 毎時5分
# RUN echo '5 */1 * * * root /var/www/html/bin/cake analytics_report' >> /etc/crontab

# #COPY ./docker/cron/crontab /etc/crontab
# CMD ["cron", "-f"]
