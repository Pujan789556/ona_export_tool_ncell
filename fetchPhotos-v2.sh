#!/bin/bash

find . -name '*.jpg' -print | grep -o "[0-9]\{3,13\}-large.jpg" | perl -p -e "s/-large//g" > photoshere.data.list

cat schools.json buildings.json building_elements.json | grep -o "filename=wbsida321\/attachments\/[a-zA-Z0-9\_\-]\{3,26\}\.jpg&suffix=medium" > photostaken.fullquerypath.data.list

cat photostaken.fullquerypath.data.list | grep -o "[a-zA-Z0-9\_\-]\{3,26\}\.jpg" > photostaken.data.list

s3cmd ls s3://onadata/wbsida321/attachments/ > photosins3.withfullpath.data.list

cat photosins3.withfullpath.data.list | grep -o "[0-9]\{3,13\}.jpg" > photosins3.data.list

./set-a-b-overlap-minus-x.py photostaken.data.list photosins3.data.list photoshere.data.list > photostodownload.data.list

php picfetch.php
