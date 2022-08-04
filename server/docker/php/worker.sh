#!/bin/bash -eu

# local queue setting
SQL_QUEUE_URL="${SQS_QUEUE_URL:-http://localhost:9324/000000000000/test-queue}"
OPTION=''
if [ "${USER_ENV:-local}" = 'local' ]; then
        # local endpoint URL
        OPTION="--endpoint-url http://${SQS_QUEUE_ENDPOINT:-localhost:9324}"
fi

# default visibility time 10 seconds
SQS_VISIBILITY_TIMEOUT=${SQS_VISIBILITY_TIMEOUT:-10} # queue setting


# batch server
batchServerSleepInterval=${BATCH_SERVER_SLEEP_INTERVAL:-5}
pid=''
epid=''

cleanup() {
        echo '[cleanup] clean up process started...'

        for p in $pid $epid; do
                # for MAC
                # local existPid=$(ps -ef | grep $p | grep -v grep | awk '{print $2}')
                # for Linux
                local existPid=$(ps -ef | grep $p | grep -v grep | awk '{print $1}')
                if [ "$existPid" != '' ]; then
                        echo "[cleanp] deleting pid $existPid"
                        kill $p
                # else
                #         echo "$p does not exist"
                fi
        done

        pid=''
        epid=''

        echo '[cleanup] done'
}

post_handler() {
        cleanup
        exit 0
}

trap 'cleanup' ERR
trap 'post_handler' SIGINT SIGTERM

extender() {
        local handler="$1"

        local halfOfVisibilityTimeout=$(expr $SQS_VISIBILITY_TIMEOUT / 2)

        echo "[extender] initial sleep $halfOfVisibilityTimeout seconds"
        sleep $halfOfVisibilityTimeout

        local visibilityTimeoutExtended=$(expr $halfOfVisibilityTimeout + $SQS_VISIBILITY_TIMEOUT )

        while true; do
                echo "[extender] extending visibilityTimeout to '$visibilityTimeoutExtended'"

                # TODO: add hard limit check, you dont't want to extend it way too long

                aws sqs change-message-visibility \
                        --queue-url "$SQL_QUEUE_URL" \
                        --receipt-handle "$handler" \
                        --visibility-timeout "$visibilityTimeoutExtended" \
                        $OPTION

                visibilityTimeoutExtended=$(expr $visibilityTimeoutExtended + $halfOfVisibilityTimeout )
                # echo "[extender] wait $halfOfVisibilityTimeout seconds for next visibility timeout extension"
                sleep $halfOfVisibilityTimeout
        done
}

fetch() {
        local message=$(aws sqs receive-message \
                --queue-url "$SQL_QUEUE_URL" \
                --visibility-timeout $SQS_VISIBILITY_TIMEOUT \
                --max-number-of-messages 1 \
                $OPTION | jq -r '.Messages[0]')
        # do not put any information other than message
        echo "$message"
}

worker() {
        local receiptHandler="$1"
        local body="$2"

        local dt=$(date '+%H:%M:%S')
        echo "[worker] $dt received message: '$body'"

        local dt=$(date '+%H:%M:%S')

        local cmd=$(echo "$body" | jq -r '.command')
        local companies=$(echo "$body" | jq -r '.companies')
        local cmd_return_code=''
        local delete_return_code=''

        if [ "$cmd" = 'google' ]; then
                set +e
                COMPANIES="$companies" php artisan google && true || false
                cmd_return_code=$?
                set -e
        elif [ "$cmd" = 'test' ]; then
                # TODO: delete this section later
                set +e
                COMPANIES="$companies" php -r  'throw new Exception("[TEST] exception!");' && true || false
                cmd_return_code=$?
                set -e
        else
                echo "[worker] unable to process command request '$cmd'"
                cmd_return_code=0
        fi

        echo "[worker] php command return_code: $cmd_return_code"

        if [ "$cmd_return_code" = '0' ]; then
                # successfully executed task
                echo "[worker] trying to delete $receiptHandler"
                set +e
                aws sqs delete-message \
                        --queue-url $SQL_QUEUE_URL \
                        --receipt-handle $receiptHandler \
                        $OPTION
                delete_return_code=$?
                set -e
        else
                echo '[worker] command execution error?'
                echo '[worker] set visibility timeout to 0 and try again'
                set +e
                aws sqs change-message-visibility \
                        --queue-url "$SQL_QUEUE_URL" \
                        --receipt-handle "$receiptHandler" \
                        --visibility-timeout 0 \
                        $OPTION
                delete_return_code=$?
                set -e
        fi
        [ "$delete_return_code" = '0' ] && echo '[worker] message deleted!' || echo '[worker] message deletion error?'
}

echo 'batch server started!'

while true; do
        message=''
        message=$(fetch)
        messageId=$(echo "$message" | jq -r '.MessageId')
        receiptHandler=$(echo "$message" | jq -r '.ReceiptHandle')
        body=$(echo "$message" | jq -r '.Body')

        if [ "$messageId" = '' ]; then
                echo "[batch] nothing to process, sleep $batchServerSleepInterval seconds"
        else
                echo "[batch] message found: $body"
                echo "[batch] messageId: '$messageId'"
                echo "[batch] receiptHandler: '$receiptHandler'"
                echo ''

                worker "$receiptHandler" "$body" &
                pid=$!

                # for test, skipping extender visibility timeout will fail deleteting message
                if [ "${SKIP_EXTENDER:-}" != 'skip' ]; then
                        extender "$receiptHandler" &
                        epid=$!

                        echo "[batch] extender id: $epid, worker id: $pid"
                fi

                echo "[batch] worker id: $pid"
                echo "[batch] wait until workeer process finishes, pid: $pid"
                wait $pid
                cleanup
        fi

        sleep $batchServerSleepInterval
done