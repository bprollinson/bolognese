FROM alpine:3.14.0

RUN apk add mysql-client mysql

RUN mysql_install_db --user=mysql --ldata=/var/lib/mysql

COPY files/ /root
RUN chmod u+x /root/start_mysql

CMD ["/root/start_mysql"]
