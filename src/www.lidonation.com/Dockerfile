FROM registry.lidonation.com/lidonation/lidonation/www.lidonation.com.base:8.2-fpm-alpine3.18

COPY /  /

# RUN  wget --no-check-certificate 'https://docs.google.com/uc?export=download&id=1tSt8GXQ3veQ7I0UjJhZgqIIm-MgptVwA' -O /opt/cardano-cli && chmod a+x /opt/cardano-cli

# Install PHP extensions
RUN chmod a+x /opt/install-extensions.sh /opt/entrypoint.sh \
    && chmod a+x /opt/php-fpm-healthcheck \
    && mkdir -p /run/nginx \
    && /opt/install-extensions.sh

# RUN npm install --global --unsafe-perm puppeteer

# RUN chown -R nginx:nginx /var/www

# RUN find /var/www -type d -print0|xargs -0 chmod 755; find /var/www -type f -print0|xargs -0 chmod 644;

WORKDIR /var/www

STOPSIGNAL SIGQUIT

CMD ["/bin/bash", "/opt/entrypoint.sh"]
