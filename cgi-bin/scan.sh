#!/bin/bash
printf 'content-type: text/html\n\n'

declare -A param   
while IFS='=' read -r -d '&' key value && [[ -n "$key" ]]; do
    param["$key"]=$value
done <<<"${QUERY_STRING}&"

h=${param["h"]}
c=${param["c"]}

out=`nmap -sP $h/$c`
echo "$out"
