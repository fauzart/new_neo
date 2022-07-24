#!/bin/bash
#
# Program : traces.sh
# Usage   : traces.sh <count>
# Descr   : called from cron job once per minute is OK, trace all host in trace_dir started with trace.*
#			<count> = maximum host per run

max=$1

base_dir='/var/www/zping'
log="$base_dir/log/traces.log"
tmp_dir="$base_dir/tmp"
bin_dir="$base_dir/bin"

fs="trace.*"

function write_log()
{
    echo "`date '+%m/%d %H:%M:%S'` $1" >> $log
}

#write_log "starting traces.sh";

i=0

for filename in $tmp_dir/$fs; do
   ((i++))
   if [ "$i" -gt "$max" ]
   then
      break
   fi
   #echo $filename;
   f=$(echo "${filename##*/}");
   #echo $f;
   if [ "$fs" != "$f" ]; then
		#echo "$bin_dir/probe.sh $f";
		write_log "tracing $f"
		$bin_dir/trace.sh $f &
   #else
        #write_log "$trace_dir/$fs not found. All OK.";
   fi
done

#write_log "end traces.sh";
exit 0
