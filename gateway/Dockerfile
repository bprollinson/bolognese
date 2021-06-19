FROM alpine:3.14.0

RUN apk add apache2 && apk add php

EXPOSE 80

CMD ["/usr/sbin/httpd", "-D", "FOREGROUND"]
