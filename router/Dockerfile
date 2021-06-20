FROM alpine:3.14.0

RUN apk add php7 && apk add php7-sockets && apk add php7-json

COPY files/listen.php /root

CMD ["php", "/root/listen.php"]
