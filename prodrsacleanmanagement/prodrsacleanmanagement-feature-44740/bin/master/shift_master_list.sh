#!/bin/bash

. config.sh

SORT=`url_encode '{"sequence" : "asc" }'`

curl -X GET $API_URL"/master/shifts?q=&limit=0&offset=0&sort=${SORT}&in_deleted=1" | jq
