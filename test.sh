#!/bin/bash

date01=$(date +"%F_%T")
sudo systemctl stop kiosk.service
sudo mkdir -p /home/pi/KioskOld/$date01 
sudo cp /home/pi/kiosk.sh /home/pi/KioskOld/$date01/
sudo sleep 5
sudo cp -f /home/pi/Myfiles /home/pi/kiosk.sh
sudo chmod 744 /home/pi/kiosk.sh
sudo chown root:root /home/pi/kiosk.sh
sudo systemctl start kiosk.service
