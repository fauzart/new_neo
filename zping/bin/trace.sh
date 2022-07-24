#!/bin/bash
#
# Program : traces.sh
# Usage   : traces.sh <filename>
# Descr   : called from traces.sh
#			- <filename> format trace.host rename to done.host after execution to prevent re run

f=$1
host=${f:6}
#host=$1

base_dir='/var/www/zping'
log="$base_dir/log/trace.log"
trace_dir="$base_dir/trace"
bin_dir="$base_dir/bin"
tmp_dir="$base_dir/tmp"

function write_log()
{
    echo "`date '+%m/%d %H:%M:%S'` $1" >> $log
}

write_log "tracing $host"

out=`traceroute $host`
echo "$out" > $trace_dir/$host.trace

res=`mv $tmp_dir/$f $tmp_dir/done.$host`

write_log "trace $host complete"

exit 0
