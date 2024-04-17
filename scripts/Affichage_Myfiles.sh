#!/bin/bash
#Compteur d'itérations
compteur=0;
#Fonction pour lancer Chromium
lancer_chromium() {
    xset s noblank
    xset s off
    xset -dpms
    unclutter -idle 1 -root &
 /usr/bin/chromium-browser --kiosk --noerrdialogs https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg &
}

fermer_onglets_chromium() {
    xdotool search --onlyvisible --class "chromium-browser" windowfocus key ctrl+shift+w
    wmctrl -k off
}

#Fonction pour arrêter Chromium
arreter_chromium() {
    killall chromium-browser
    #Ajoutez ici dutres commandes pour nettoyer l'environnement si nécessaire
}

#Lancer Chromium au début
lancer_chromium

while true; do
    xdotool keydown ctrl+Next
    xdotool keyup ctrl+Next

    xdotool keydown ctrl+r
    xdotool keyup ctrl+r

    sleep 15
        	#Aucune vidéo à lancer car video_acceptance n'est pas égal à 1
        	#Relancer Chromium et réinitialiser le compteur

done
