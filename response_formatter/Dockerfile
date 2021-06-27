FROM alpine:3.14.0

RUN apk add php && apk add php7-sockets

COPY files/ /root

CMD ["php", "/root/listen.php"]
