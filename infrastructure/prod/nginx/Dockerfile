FROM nginx:1.13.9-alpine
ENV WORKDIR /var/www/html/

WORKDIR $WORKDIR

RUN apk add --no-cache bash
RUN ln -sf /usr/share/zoneinfo/UTC /etc/localtime

COPY infrastructure/prod/nginx/app.conf /etc/nginx/conf.d/default.conf
COPY infrastructure/prod/nginx/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT entrypoint.sh
