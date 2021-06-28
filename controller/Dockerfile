FROM alpine:3.14.0

RUN apk add php7 php7-sockets php7-json

COPY files/ /root

CMD ["php", "/root/listen.php"]
