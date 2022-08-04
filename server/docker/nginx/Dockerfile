ARG VERSION=alpine

FROM nginx:${VERSION} as core

# https://stackoverflow.com/questions/56649582/substitute-environment-variables-in-nginx-config-from-docker-compose
# RUN mkdir -p /etc/nginx/templates /var/www/public
RUN mkdir -p /etc/nginx/templates
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/conf.d/default_and_auth.conf.template /etc/nginx/templates/default.conf.template
# COPY docker/nginx/healthcheck.html /var/www/public/
COPY public /var/www/public

#COPY docker/nginx/conf.d/default.conf.template /etc/nginx/templates/
#COPY . /var/www/

# Validate the config
RUN echo "Download nginx-${NGINX_VERSION}" && nginx -t
CMD ["nginx", "-g", "daemon off;"]

FROM nginx:${VERSION} as builder

ENV MORE_HEADERS_VERSION=0.33
ENV MORE_HEADERS_GITREPO=openresty/headers-more-nginx-module

# Download sources
RUN echo "Download nginx-${NGINX_VERSION}" &&  wget "http://nginx.org/download/nginx-${NGINX_VERSION}.tar.gz" -O nginx.tar.gz && \
    wget "https://github.com/${MORE_HEADERS_GITREPO}/archive/v${MORE_HEADERS_VERSION}.tar.gz" -O extra_module.tar.gz

# For latest build deps, see https://github.com/nginxinc/docker-nginx/blob/master/mainline/alpine/Dockerfile
RUN  apk add --no-cache --virtual .build-deps \
    gcc \
    libc-dev \
    make \
    openssl-dev \
    pcre-dev \
    zlib-dev \
    linux-headers \
    libxslt-dev \
    gd-dev \
    geoip-dev \
    perl-dev \
    libedit-dev \
    mercurial \
    bash \
    alpine-sdk \
    findutils

SHELL ["/bin/ash", "-eo", "pipefail", "-c"]

RUN rm -rf /usr/src/nginx /usr/src/extra_module && mkdir -p /usr/src/nginx /usr/src/extra_module && \
    tar -zxC /usr/src/nginx -f nginx.tar.gz && \
    tar -xzC /usr/src/extra_module -f extra_module.tar.gz

WORKDIR /usr/src/nginx/nginx-${NGINX_VERSION}

# Reuse same cli arguments as the nginx:alpine image used to build
RUN CONFARGS=$(nginx -V 2>&1 | sed -n -e 's/^.*arguments: //p') && \
    sh -c "./configure --with-compat $CONFARGS --add-dynamic-module=/usr/src/extra_module/*" && make modules

FROM nginx:alpine as debug
COPY --from=builder /usr/src/nginx/nginx-${NGINX_VERSION}/objs/*_module.so /etc/nginx/modules/

COPY . /var/www/
RUN mkdir /etc/nginx/templates
COPY docker/nginx/conf.d/debug.conf /etc/nginx/templates/default.conf.template
COPY docker/nginx/nginx-debug-sample.conf /etc/nginx/nginx.conf

CMD ["nginx-debug", "-g", "daemon off;"]