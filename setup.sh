# CHECK ROOT
# todo


# Freshen up system
apt-get -y update
apt-get -y upgrade


# Install prerequisites
apt-get -y install lighttpd php5-common php5-cgi php5-cli php5 git


# Enable PHP
lighty-enable-mod fastcgi-php
service lighttpd force-reload


# Enable GPIO, and at bootup via /etc/rc.local
sed -i "/\b\(exit 0\)\b/d" /etc/rc.local
echo "echo 4 > /sys/class/gpio/export" >> /etc/rc.local
echo "echo out > /sys/class/gpio/gpio4/direction" >> /etc/rc.local
echo "echo 1 > /sys/class/gpio/gpio4/value" >> /etc/rc.local
echo "" >> /etc/rc.local
echo "exit 0" >> /etc/rc.local
echo 4 > /sys/class/gpio/export
echo out > /sys/class/gpio/gpio4/direction
echo 1 > /sys/class/gpio/gpio4/value


# Get the code
git clone https://github.com/squiggleuk/RaspberryPi_CentralHeating.git /var/www/html/heating


# Set permissions
chown www-data /var/www/html/heating/schedule/ -R
usermod -a -G gpio www-data


# Create crontab file to run manager every 60 seconds
echo "* * * * * root /usr/bin/php /var/www/html/heating/manager.php >/dev/null 2>&1" > /etc/cron.d/heating


# Copy crontab defaults file to turn cron logging off
# cp sysconfig/cron.defaults /etc/default/cron
service cron restart


# Apple WebApp icon - has to be in root for ios8+
cp /var/www/html/heating/apple-touch-icon.png /var/www/html/apple-touch-icon.png

