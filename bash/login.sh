#!/bin/sh
echo "Through sshpass automatic login"
echo "please enter host suffix "
while true
do
    echo -n "'host suffix':"
    read host_suffix
    case $host_suffix in
    224)
        sshpass -p "224test+svn+3434472" ssh test-svn@192.168.9.224 -p 2211
    break;;
    225)
        sshpass -p "test20w133" ssh test@192.168.9.225 -p 2211
    break;;
    226)
        sshpass -p "test2222013" ssh test@192.168.9.226 -p 2211
    break;;
    esac
done
exit 0

