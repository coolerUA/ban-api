#!/bin/bash

cat -E $1 | curl -X PUT http://HOSTNAME/`echo "$2"|base64`/`echo $3|base64`/ --data @-