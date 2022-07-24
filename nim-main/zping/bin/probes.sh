#!/bin/bash
#
# Program : probes.sh
# Usage   : probes.sh <probe> <step>
# Descr   : <probe> integer. offset/run at ..., default 0
#			<step> integer. in minutes, default 5

base_dir='/var/www/zping'
file_dir="$base_dir/etc"
bin_dir="$base_dir/bin"
log="$base_dir/log/probes.log"

re='^[0-9]+$'
p=$1
m=$2

if [ -z "$1" ]; then
	p=0
fi
if [ -z "$2" ]; then
	m=5
fi

if ! [[ $p =~ $re ]] ; then 
	p=0
fi
if ! [[ $m =~ $re ]] ; then 
	m=5
fi

step=$(($m*60))
fs="$step-$p*.txt"

function write_log()
{
    echo "`date '+%m/%d %H:%M:%S'` $1" >> $log
}

#write_log "starting probes.sh $p $m";

for filename in $file_dir/$fs; do
   #echo $filename;
   f=$(echo "${filename##*/}");
   #echo $f;
   if [ "$fs" != "$f" ]; then
		#echo "$bin_dir/probe.sh $f";
		$bin_dir/probe.sh $f &
   else
        write_log "$file_dir/$fs not found. consider disabling crond $bin_dir/probes.sh $p $m";
   fi
done

#write_log "end probes.sh $p $m";
