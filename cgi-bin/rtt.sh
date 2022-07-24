#!/bin/bash
printf 'content-type: image/png\n\n'

#IFS='=&' read -ra parm <<< "$QUERY_STRING"

#host=${parm[1]}
#begin=${parm[3]}
#end=${parm[5]}

declare -A param   
while IFS='=' read -r -d '&' key value && [[ -n "$key" ]]; do
    param["$key"]=$value
done <<<"${QUERY_STRING}&"

host=${param["h"]}
begin=${param["b"]}
end=${param["e"]}

graph_dir='/var/www/zping/rrd'

rfile=$graph_dir/$host.rrd

	IMG= rrdtool graph - \
		-w 1200 -h 350 -a PNG \
        --slope-mode \
        --start $begin --end $end \
        --font DEFAULT:8: \
        --font TITLE:10: \
        --title "Ping RTT to $host" \
        --vertical-label "Latency (MS)" \
        --lower-limit 0 \
        --alt-y-grid --rigid \
        DEF:min=$rfile:min:MAX \
        DEF:avg=$rfile:avg:MAX \
        DEF:max=$rfile:max:MAX \
		COMMENT:"Graph \: `date -d \@\"$begin\" +'%Y/%m/%d'` to `date -d \@\"$end\" +'%Y/%m/%d'` \n" \
        LINE1:min#03bd10:"Minimum" \
		GPRINT:min:MIN:" \:%8.2lf %s \n"  \
        LINE1:avg#0223ca:"Average" \
        GPRINT:avg:AVERAGE:" \:%8.2lf %s \n"  \
        LINE1:max#e11110:"Maximum" \
		GPRINT:max:MAX:" \:%8.2lf %s \n"  
        
cat $IMG
