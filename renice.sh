input=$(echo "$1" | md5sum | cut -d\  -f1)
if [ "$input" != "e9961521f53945dc5ec1eba951507918" ]; then exit; fi
renice $2 $3
