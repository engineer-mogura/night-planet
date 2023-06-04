FROM nginx:latest

ENV TZ Asia/Tokyo

#COPY ./docker/web/default.conf /etc/nginx/conf.d/default.conf
################## 以降の設定は上手くできないので無視する 2022/11/02 設定出来たっぽい                  #################
################## https://github.com/itouoti12/logrotate-in-nginx-docker #################

# copy to nginx settings
COPY ./docker/web/default.conf /etc/nginx/conf.d/
COPY ./docker/web/nginx.conf /etc/nginx/

RUN apt-get update

##### rsyslog settings #####
RUN apt -y install rsyslog
COPY ./docker/web/rsyslog/50-default.conf /etc/rsyslog.d/
RUN update-rc.d rsyslog enable

##### logrotate settings #####
RUN apt -y install logrotate
# nginxのlogrotate以外は動かさない
# RUN rm /etc/cron.daily/passwd ← 存在しない
RUN rm /etc/cron.daily/dpkg
RUN rm /etc/cron.daily/apt-compat
RUN rm /etc/cron.daily/exim4-base
# copy to logrotate settings
COPY ./docker/web/logrotate/nginx_rotate /etc/logrotate.d/nginx
COPY ./docker/web/logrotate/daily_crontab /etc/cron.d/
COPY ./docker/web/logrotate/status /var/lib/logrotate
RUN update-rc.d cron enable

CMD service cron start && touch /etc/crontab /etc/cron.d/* && service rsyslog start && nginx -g 'daemon off;'
