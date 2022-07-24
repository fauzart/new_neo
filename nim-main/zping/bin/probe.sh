#!/bin/bash
#
# Program : probe.sh
# Usage   : probe.sh <file>
# Descr   : <file> contains list of host/ip maximum 50, performance issue


base_dir='/var/www/zping'
file_dir="$base_dir/etc"
bin_dir="$base_dir/bin"
log="$base_dir/log/probe.log"

function write_log()
{
    echo "`date '+%m/%d %H:%M:%S'` $1" >> $log
}

# this is the master process, start mass ping, 50 devices per probe maximum
    timestamp=`date +"%s"`

#    write_log "starting mass ping : $1"

    cat $file_dir/$1 | xargs -n 1 -I ^ -P 50 $bin_dir/ping.sh ^ $timestamp

    retval=$?

    if [ $retval -gt 0 ]
    then
        write_log "mass ping : $1 failed retval $retval"
        exit 202
    fi

#    write_log "pings complete : $1"

    exit 0
