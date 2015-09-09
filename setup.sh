# Freshen up system
apt-get -y update
apt-get -y upgrade

# Install lighttpd & PHP
apt-get -y install lighttpd php5-common php5-cgi php5-cli php5
lighty-enable-mod fastcgi-php
service lighttpd force-reload

# Set permissions for heatign data
chmod 777 schedule/ -R

# Create udev rules to allow www-data gpio access
cp sysconfig/99-gpio.rules /lib/udev/rules.d/99-gpio.rules

# Enable GPIO at bootup vi /etc/rc.local
sed -i "/\b\(exit 0\)\b/d" /etc/rc.local
echo "echo 4 > /sys/class/gpio/export" >> /etc/rc.local
echo "echo out > /sys/class/gpio/gpio4/direction" >> /etc/rc.local
echo "echo 1 > /sys/class/gpio/gpio4/value" >> /etc/rc.local
echo "exit 0" >> /etc/rc.local

# Create crontab file to run manager every 60 seconds
echo "* * * * * /usr/bin/php /var/www/heating/manager.php >/dev/null 2>&1" > /etc/cron.d/heating
