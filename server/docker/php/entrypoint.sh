#!/bin/sh
set -e

# for reference, see below link
# https://aws.amazon.com/jp/blogs/news/graceful-shutdowns-with-ecs/

pre_execution_handler() {
  # put your pre execution steps here
  php artisan config:cache

  ## Redirecting Filehanders
  ln -sf /proc/$$/fd/1 /tmp/stdout.log
  ln -sf /proc/$$/fd/2 /tmp/stderr.log
}

post_execution_handler() {
  echo 'post execution handler'
  # if a container run as batch task, add whatever required as cleanup task
  # if it runs as web application, just waiting is sufficient
}

## Sigterm Handler
sigterm_handler() {
  # 0)    successful termination
  # 3)    SIGQUIT - default signal given by docker stop
  # 15)   SIGTERM - ECS task will throw this signal
  # 128)  invalid argument to exit
  # 137)  SIGKILL - killed by docker

  if [ $pid -ne 0 ]; then
    # the above if statement is important because it ensures
    # that the application has already started. without it you
    # could attempt cleanup steps if the application failed to
    # start, causing errors.
    kill -15 "$pid"
    echo "wait pid $pid"
    wait "$pid"
    post_execution_handler
    exit 0
  fi

  # 128 + 15
  exit 143
}

## Setup signal trap
trap 'sigterm_handler' SIGTERM

## Initialization
pre_execution_handler

## Start Process
# run process in background and record PID
>/tmp/stdout.log 2>/tmp/stderr.log "$@" &

pid="$!"

## Wait forever until app dies
wait "$pid"
return_code="$?"

echo "app process $pid finished with return_code $return_code"

# if [ "$return_code" = "?" ]; then
#   # expecting batch job finishes with status code ? as success
#   echo "successfully finished"
# else
#   echo "app process finished with pid $pid"
# fi

## Cleanup when a program terminated by the child process
#post_execution_handler