FROM mysql
COPY ./dump.sql /docker-entrypoint-initdb.d/
COPY ./haversine.sql /docker-entrypoint-initdb.d/
COPY grants.sql /docker-entrypoint-initdb.d/