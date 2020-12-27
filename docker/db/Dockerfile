FROM postgres as praga_db
COPY docker/db/initialdb /docker-entrypoint-initdb.d
COPY docker/db/conf/.pgpass /root/.pgpass
COPY docker/db/backupdb /root/backupdb
COPY docker/db/restoredb /root/restoredb

RUN mkdir -p /backup && chmod +x /root/backupdb && chmod +x /root/restoredb

EXPOSE 5432:5432
