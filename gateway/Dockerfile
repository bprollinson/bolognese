FROM alpine:3.14.0

RUN apk add apache2 && apk add php7 && apk add php7-apache2 && apk add php7-sockets && apk add php7-json
RUN cp -p /etc/apache2/httpd.conf /etc/apache2/httpd.conf.bak
RUN sed -i 's@^#LoadModule rewrite_module modules/mod_rewrite\.so@LoadModule rewrite_module modules/mod_rewrite.so@' /etc/apache2/httpd.conf
RUN sed -i '/<Directory "\/var\/www\/localhost\/htdocs">/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/httpd.conf

COPY files/ /var/www/localhost/htdocs
RUN rm /var/www/localhost/htdocs/index.html

EXPOSE 80

CMD ["/usr/sbin/httpd", "-D", "FOREGROUND"]
