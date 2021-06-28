FROM alpine:3.14.0

RUN apk add apache2 php7 php7-apache2 php7-sockets php7-json curl php7-phar php7-mbstring php7-openssl

RUN cp -p /etc/apache2/httpd.conf /etc/apache2/httpd.conf.bak
RUN sed -i 's@^#LoadModule rewrite_module modules/mod_rewrite\.so@LoadModule rewrite_module modules/mod_rewrite.so@' /etc/apache2/httpd.conf
RUN sed -i '/<Directory "\/var\/www\/localhost\/htdocs">/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/httpd.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

EXPOSE 80

CMD ["/var/www/localhost/htdocs/run"]
