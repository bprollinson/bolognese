FROM alpine:3.14.0

RUN apk add php7 php7-sockets php7-json curl php7-phar php7-mbstring php7-openssl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

CMD ["/root/run"]
