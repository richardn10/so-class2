#!/bin/bash

YUMREPO_USER=yumrepo
YUMREPO_HOST=vpn-dev.switchedon.org
#YUMREPO_HOST=localhost
YUMREPO_PORT=1026
#YUMREPO_PORT=22
YUMREPO_PATH=/srv/www/htdocs/yum/so/
#YUMREPO_PATH=/var/www/html/yum/so/

if [ $# -ne 1 ] ; then
	echo "Usage: $0 <rpmfile>"
fi

#upload the rpm file...

UPLOADFILE=$1

scp -P $YUMREPO_PORT $UPLOADFILE $YUMREPO_USER@$YUMREPO_HOST:$YUMREPO_PATH

#refresh the repo on the server

ssh -p $YUMREPO_PORT $YUMREPO_USER@$YUMREPO_HOST "createrepo $YUMREPO_PATH"



