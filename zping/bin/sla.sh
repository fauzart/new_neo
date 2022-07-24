#!/bin/bash
#
# Program : sla.sh
# Usage   : sla.sh
# Descr   : backup status to status_sla and reset status
#			called from cron every minute 1 after midnight
#			1 0 * * * /path/to/sla.sh

base_dir='/var/www/zping'
log_dir="$base_dir/log"
log="$log_dir/sla.log"

. $base_dir/conf/db.sh

function write_log()
{
    echo "`date '+%m/%d %H:%M:%S'` $1" >> $log
}
function write_db(){
	echo "`date '+%m/%d %H:%M:%S'` $1 " >> $log_dir/db.log
	mysql --user="$myusr" --password="$mypass" --database="$mydb" --execute="$1" >> $log_dir/db.log
}

write_log "Starting SLA calculation for yesterday log"

write_db "call proc_sla();"

write_log "Calculation SLA ended"

exit 0