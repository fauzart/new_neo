#!/bin/bash
printf 'content-type: text/html\n\n'

declare -A param   
while IFS='=' read -r -d '&' key value && [[ -n "$key" ]]; do
    param["$key"]=$value
done <<<"${QUERY_STRING}&"

h=${param["h"]}
f=${param["f"]}

dir='/var/www/zping/trace'


out=`cat $dir/$h.$f`
echo "$out"