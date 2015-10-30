#!/bin/bash

aws s3 cp s3://onadata/wbsida321/attachments/$1 ./ >>awslog.log
mogrify -resize 25% $1 >>morgifylog.log
rename 's/.jpg/-large.jpg/' $1