#!/bin/bash

cd ../

COPYFILE_DISABLE=1 /usr/bin/tar \
	--exclude='./.git*' \
	--exclude='./deploy.sh' \
	--exclude='*.DS_Store' \
	-czvf academyresources.tar.gz ./academyresources
/usr/bin/scp -i "~/cnn-academy-frankfurt.pem" ./academyresources.tar.gz bitnami@ec2-3-67-111-127.eu-central-1.compute.amazonaws.com:~/

/bin/rm ./academyresources.tar.gz

/usr/bin/ssh -tt -i "~/cnn-academy-frankfurt.pem" bitnami@ec2-3-67-111-127.eu-central-1.compute.amazonaws.com << EOF
cd /tmp
cd /bitnami/moodle/blocks
/bin/rm -rf academyresources
sudo /bin/mv ~/academyresources.tar.gz ./
sudo /bin/tar -xzvf academyresources.tar.gz
sudo /bin/rm academyresources.tar.gz
exit
EOF
