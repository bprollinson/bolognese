FROM alpine:3.14.0

RUN apk add php && apk add php7-sockets && apk add php7-json

COPY files/ /root

CMD ["php", "/root/listen.php"]
