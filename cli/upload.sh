#!/bin/bash

API_URL=""

function print_help {
echo "This is a help.

-s for single
    Example:
	$0 -s 123.45.67.89 FILTER_NAME COMMENT


-b for bulk from FILE_NAME
    Example:
	$0 -s FILE_NAME FILTER_NAME COMMENT

"
exit 1
}

function check_param {
	    if [ "$2" == "" ]; then echo "
ERROR: Option $1 requires parameter. 
"; print_help; fi
}

while true; 
    do
	if [ "$1" == "" ]; then print_help
fi
        case "$1" in
            -s | --single ) 
	    check_param $1 $2
	    echo "$2$" |curl -X PUT http://$API_URL/`echo "\`hostname\`|$3"|base64`/`echo $4|base64`/ 
	    exit 1
	    ;;
            -b | --bulk ) 
	    check_param $1 $2
	    cat -E $2 |curl -X PUT http://$API_URL/`echo "\`hostname\`|$3"|base64`/`echo $4|base64`/ --data @-
	    exit 1
	    ;;
	    \?) print_help;;
	    :) print_help;;
        esac
done
