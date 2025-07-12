#!/bin/bash
yum update -y
yum install -y httpd php php-mysqlnd git

systemctl enable httpd
systemctl start httpd

cd /var/www/html
rm -rf *

git clone https://github.com/karim664/aws-scalable-web-app/tree/main/Frontend .

chown -R apache:apache /var/www/html
chmod -R 755 /var/www/html
