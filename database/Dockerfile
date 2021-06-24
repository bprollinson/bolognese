FROM alpine:3.14.0

RUN apk add mysql-client mysql

RUN mysql_install_db --user=mysql --ldata=/var/lib/mysql

CMD ["mysqld_safe"]
