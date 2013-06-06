#!/bin/bash

cat -E $1 |grep -v "^$" | curl -X PUT http://HOSTNAME/`echo "$2"|base64`/`echo $3|base64`/ --data @-