FROM alpine:3.14.0

RUN apk add mysql-client mysql

RUN mysql_install_db --user=mysql --ldata=/var/lib/mysql
RUN sed -i 's/skip-networking/#skip-networking/' /etc/my.cnf.d/mariadb-server.cnf
RUN sed -i 's/#bind-address/bind-address/' /etc/my.cnf.d/mariadb-server.cnf

COPY files/ /root
RUN chmod u+x /root/start_mysql

CMD ["/root/start_mysql"]
