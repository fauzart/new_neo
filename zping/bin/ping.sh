#!/bin/bash
#
# Program : ping.sh
# Usage   : ping.sh <host/ip count step> <timestamp>
# Descr   : called from probe.sh
#			<host/ip> = ping target
#			<timestamp> = rrd timestamp
#			<step> = rrd step
#			<count> = ping count

IFS=' ' read -ra parm <<< "$1";
host=${parm[0]}
count=${parm[1]}
rrdstep=${parm[2]}

timestamp=$2
rrdheartbeat=$((2*$rrdstep))

base_dir='/var/www/zping'
graph_dir="$base_dir/rrd"
log_dir="$base_dir/log"
log="$log_dir/ping.log"
trace_dir="$base_dir/trace"
bin_dir="$base_dir/bin"
tmp_dir="$base_dir/tmp"

. $base_dir/conf/db.sh

function write_log()
{
    echo "`date '+%m/%d %H:%M:%S'` $1" >> $log
}
function write_trace()
{
	echo "`date '+%m/%d %H:%M:%S'` $1" > $trace_dir/$host.log
}
function remove_tmp()
{
	o=`rm -f $tmp_dir/*.$host`
	echo "`date '+%m/%d %H:%M:%S'` $1" > $trace_dir/$host.trace
}
function do_trace()
{
	if [ ! -f $tmp_dir/trace.$host ] && [ ! -f $tmp_dir/done.$host ]
	then
		echo "do_trace $1" > $tmp_dir/trace.$host
	fi
}
function write_db(){
	#echo "`date '+%m/%d %H:%M:%S'` $1 " >> $log_dir/db.log
	mysql --user="$myusr" --password="$mypass" --database="$mydb" --execute="$1" # >> $log_dir/db.log
}

#  this is a worker process, ping a target
    output=`ping -c $count -i .2 -W 1 -q $host`
    retval=$?

    if [ $retval -eq 0 ] # at least some pings were returned
    then
        recvd=`echo $output | grep -o '[0-9]\+ received'`
        recvd=${recvd% received}
        lost=`expr $count - $recvd`
        stats=(`echo $output | grep -o '[0-9.]\+/[0-9.]\+/[0-9.]\+/[0-9.]\+' | tr '/' ' '`)
        min=${stats[0]}
        avg=${stats[1]}
        max=${stats[2]}
		mdev=${stats[3]}
		write_trace "$host is OK lost/min/avg/max/mdev = $lost/$min/$avg/$max/$mdev"
		remove_tmp "$host is OK"
		write_db "call proc_update_status('$host',$timestamp,$count,$lost,$avg,$min,$max,$mdev,1);"
    elif [ $retval -eq 1 ] # no pings were returned
    then
        lost=$count
        min='U'
        avg='U'
        max='U'
		mdev='U'
		write_trace "$host unreachable. doing trace"
		do_trace "$host"
		write_db "call proc_update_status('$host',$timestamp,$count,$lost,0,0,0,0,0);"
    elif [ $retval -eq 2 ] # host not found
    then
        lost=$count
        write_log "unknown host $host"
        write_trace "unknown host $host"
		write_db "call proc_update_status('$host',$timestamp,$count,$lost,0,0,0,0,0);"
        exit $retval
    else # other errors
        lost=$count
        write_log "error pinging $host retval $retval"
        write_trace "unknown error pinging $host retval $retval"
		write_db "call proc_update_status('$host',$timestamp,$count,$lost,0,0,0,0,0);"
        exit $retval
    fi

    if [ ! -f $graph_dir/$host.rrd ] # create rrd if it doesn't exist
    then
        rrdtool create $graph_dir/$host.rrd \
        --step $rrdstep \
        DS:lost:GAUGE:$rrdheartbeat:0:$count \
        DS:min:GAUGE:$rrdheartbeat:0:U \
        DS:avg:GAUGE:$rrdheartbeat:0:U \
        DS:max:GAUGE:$rrdheartbeat:0:U \
        DS:mdev:GAUGE:$rrdheartbeat:0:U \
		RRA:AVERAGE:0.5:1:2016 \
		RRA:AVERAGE:0.5:6:1440 \
		RRA:AVERAGE:0.5:24:1440 \
		RRA:AVERAGE:0.5:288:1440 \
		RRA:MIN:0.5:1:720 \
		RRA:MIN:0.5:6:1440 \
		RRA:MIN:0.5:24:775 \
		RRA:MIN:0.5:288:797 \
		RRA:MAX:0.5:1:720 \
		RRA:MAX:0.5:6:1440 \
		RRA:MAX:0.5:24:775 \
		RRA:MAX:0.5:288:797


        retval=$?

        if [ $retval -gt 0 ]
        then
            write_log "unable to create rrd for $host retval $retval"
            exit 200
        fi
		timestamp=`date +"%s"`
    fi

    rrdtool update $graph_dir/$host.rrd $timestamp:$lost:$min:$avg:$max:$mdev

    retval=$?

    if [ $retval -gt 0 ]
    then
        write_log "rrd update for $host failed retval $retval"
        exit 201
    fi
