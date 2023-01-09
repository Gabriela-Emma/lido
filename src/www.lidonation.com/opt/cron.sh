#!/bin/bash

set -e

source $HOME/.bash_profile

source /root/.cron_env

# restore SHELL env var for cron
SHELL=/bin/bash

# execute the cron command in an actual shell
exec /bin/bash --norc "$@"