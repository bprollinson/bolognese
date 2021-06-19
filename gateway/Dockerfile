FROM alpine:3.14.0

RUN apk add apache2 && apk add php7 && apk add php7-apache2

COPY files/index.php /var/www/localhost/htdocs
RUN rm /var/www/localhost/htdocs/index.html

EXPOSE 80

CMD ["/usr/sbin/httpd", "-D", "FOREGROUND"]
