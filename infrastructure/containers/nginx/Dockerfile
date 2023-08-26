FROM nginx:stable-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN apk upgrade --update-cache --available && \
    apk add openssl && \
    rm -rf /var/cache/apk/*

RUN mkdir -p /etc/nginx/certs/self-signed/
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/nginx/certs/self-signed/localhost.key -out /etc/nginx/certs/self-signed/localhost.crt -subj "/C=US/ST=Florida/L=Orlando/O=Development/OU=Dev/CN=localhost"
RUN openssl dhparam -out /etc/nginx/certs/dhparam.pem 2048

RUN addgroup -g ${GID} --system app \
    && adduser -G app --system -D -s /bin/sh -u ${UID} app \
    && sed -i "s/user  nginx/user app/g" /etc/nginx/nginx.conf
