FROM mysql:latest

ENV MYSQL_DATABASE=laravel
ENV MYSQL_USER=laravel_user
ENV MYSQL_PASSWORD=secretpassword
ENV MYSQL_ROOT_PASSWORD=rootpassword

COPY ./db.sql /docker-entrypoint-initdb.d/db.sql

CMD ["mysqld"]
