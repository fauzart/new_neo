#!/bin/bash
#
# Program : ctlgen.sh
# Usage   : ctlgen.sh
# Descr   : create ctl file called from crontab every 2 minutes

base_dir='/var/www/zping'
log_dir="$base_dir/log"
log="$log_dir/ctlgen.log"
file_dir="$base_dir/etc"

function write_log()
{
    echo "`date '+%m/%d %H:%M:%S'` $1" >> $log
}

. $base_dir/conf/db.sh

# get the data
sql="select distinct ping_interval from core_node where EXISTS(select rowid from core_bgjob where name='zping' and startnow='1')"
mysql --user="$myusr" --password="$mypass" --database="$mydb" --execute="$sql"  --silent --raw > $base_dir/interval.txt

# set the cron flag to off
sql="update core_bgjob set startnow=0, startedat=now(), running='1', finishedat=null where name='zping' and startnow='1'"
mysql --user="$myusr" --password="$mypass" --database="$mydb" --execute="$sql"

cat $base_dir/interval.txt |  while read baris
do
	rm "$file_dir/$baris"*.txt
	
	write_log "Writing interval $baris"
	sql="select concat(host,' ',ping_count,' ',ping_interval) from core_node where ping_interval=$baris order by host"
	mysql --user="$myusr" --password="$mypass" --database="$mydb" --execute="$sql"  --silent --raw > $base_dir/$baris.all
	split -l 50 -d --additional-suffix=.txt $base_dir/$baris.all $file_dir/$baris-0-
	
	rm $base_dir/$baris.all
done

# set finished
sql="update core_bgjob set finishedat=now(), running='0' where name='zping' and running='1'"
mysql --user="$myusr" --password="$mypass" --database="$mydb" --execute="$sql"

exit 0
