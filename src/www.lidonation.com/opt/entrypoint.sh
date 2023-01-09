#!/bin/bash

set -xe

## Functions
set_and_true() {
  if [[ -n "$1" ]] && $1; then return 0; else return 1; fi
}

until $(nc -zv $POSTGRESQL_WEB_DB_HOST 5432 &>/dev/null); do
  sleep 2s
done

if [ -d "/tmp/gcloud" ]; then
  mkdir -p /gcloud
  cp /tmp/gcloud/* /gcloud
  find /gcloud -type d -print0|xargs -0 chmod 755; find /gcloud -type f -print0|xargs -0 chmod 644;
fi

php artisan package:discover

php artisan migrate --force

#
if [[ "$APP_ENV" != "testing" ]]; then

#  if [[ "$APP_SETUP" == "true" ]]; then
#    rm -rf storage/app/public/*
#    php artisan media-library:regenerate
#  fi

  php artisan cache:clear
  # Clear View cache:
  php artisan view:clear
  php artisan storage:link
fi

mkdir -p /var/run/supervisor
mkdir -p /ipc

if [[ "$APP_ENV" != "local" ]]; then
  php artisan view:clear
  php artisan event:cache
#  php artisan optimize
#  php artisan route:trans:cache
fi

case "$CONTAINER_ROLE" in
  queue | q)
    /usr/bin/supervisord -c /etc/supervisor/supervisord.queue.conf
    ;;
  scheduler | s)
    printenv | sed -e '/GOOGLE_STORAGE_SERVICE_ACCOUNT/,+12d' | sed -e '/BASH_FUNC_module%%=()/,+500d' | sed 's/^\(.*\)$/export \1/g' > /root/.cron_env
    chmod 770 /opt/scripts/cron.sh
    crontab /etc/crontab
    /usr/bin/supervisord -c /etc/supervisor/supervisord.scheduler.conf
    ;;
  app | a)
    printenv | sed -e '/BASH_FUNC_module%%=()/,+500d' | sed 's/^\(.*\)$/export \1/g' > /root/.cron_env
    chmod 770 /opt/cron.sh
    crontab /etc/crontab

#    if [[ "$APP_ENV" != "local" ]] && [[ "$APP_ENV" != "testing" ]]; then
#      php artisan ln:sitemap-generate --no-interaction
#    fi

    /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
    ;;
  *)
    echo 'this container has no role... it is a sitting duck doing nothing!'
    echo 'Please $CONTAINER_ROLE to either queue, scheduler, or app'
    ;;
esac
