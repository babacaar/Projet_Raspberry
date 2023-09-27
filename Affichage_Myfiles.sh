#!/bin/bash


			xset s noblank

			xset s off

			xset -dpms

			unclutter -idle 1 -root &


			#/usr/bin/chromium-browser --kiosk --noerrdialogs http://10.49.11.214/captures/capturemm.png http://10.49.11.214/captures/capturemm.png http://10.49.11.214/captures/capturemm.png https://lpjw.fr/ecrans/menu.jpg &

			/usr/bin/chromium-browser --kiosk --noerrdialogs http://192.168.250.1/ https://lpjw.fr/ecrans/menu.jpg http://172.17.5.202/Vue_Taches.php &


		while true; do

		   xdotool keydown ctrl+Next; xdotool keyup ctrl+Next;

		   xdotool keydown ctrl+r; xdotool keyup ctrl+r;

		   sleep 50

		done
