#!/bin/bash


			xset s noblank

			xset s off

			xset -dpms

			unclutter -idle 1 -root &
			
 			/usr/bin/chromium-browser --kiosk --noerrdialogs -volume 100 --start-fullscreen /http://172.17.5.202/Video/LpjwVideo.mp4 & sleep 90

			/usr/bin/chromium-browser --kiosk --noerrdialogs http://192.168.250.3/pwa/devices-sensors.html http://192.168.251.103/scp/login.php http://192.168.250.1/ http://192.168.250.1/ http://192.168.250.1/ http://192.168.250.1/ http://lpjw.fr/ecrans/menu.jpg http://lpjw.fr/ecrans/menupeda.jpg &
			

		while true; do

		   xdotool keydown ctrl+Next; xdotool keyup ctrl+Next;

		   xdotool keydown ctrl+r; xdotool keyup ctrl+r;

		   sleep 15

		done
