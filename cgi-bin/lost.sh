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
count=${param["c"]}

graph_dir='/var/www/zping/rrd'

rfile=$graph_dir/$host.rrd

	IMG= rrdtool graph - \
		-w 1200 -h 350 -a PNG \
        --slope-mode \
        --start $begin --end $end \
        --font DEFAULT:8: \
        --font TITLE:10: \
        --title "Packet Lost to $host" \
        --vertical-label "Lost (%)" \
        --lower-limit 0 \
        --alt-y-grid --rigid \
        DEF:lost=$rfile:lost:MAX \
		CDEF:mylost=lost,$count,/  \
		COMMENT:"Graph \: `date -d \@\"$begin\" +'%Y/%m/%d'` to `date -d \@\"$end\" +'%Y/%m/%d'` \n" \
        LINE1:mylost#e11110:"Packet Lost" \
		GPRINT:mylost:MIN:" MIN\:%8.2lf %s"  \
        GPRINT:mylost:AVERAGE:" AVG\:%8.2lf %s"  \
        GPRINT:mylost:MAX:" MAX\:%8.2lf %s"  
        
cat $IMG
