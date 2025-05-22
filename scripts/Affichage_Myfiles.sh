#!/bin/bash
#Compteur d'itérations
compteur=0;
#Fonction pour lancer Chromium
lancer_chromium() {
    xset s noblank
    xset s off
    unclutter -idle 1 -root &
 /usr/bin/chromium-browser --kiosk --noerrdialogs https://srvprtg01.joseph.wresinski/public/mapshow.htm?id=5006&mapid=C17E0589-AAF7-470C-A36C-8A65A9D5C309 http://192.168.250.1/plugins/autologin/core/php/go.php?apikey%3DX9WFcmXDig1SmtbwMqgZe6YSM0YToQL1GESXS4ddsPnJPYdvMFXcjKjCwfzaLfaQ&id%3D72 http://192.168.250.1/index.php?v=d&p=plan&plan_id=4 &
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

        #Incrémente le compteur d'itérations
    ((compteur++))

    #Vérifie si le nombre d'itérations spécifié est atteint
    if [ "$compteur" -eq "3" ]; then
        #Arrêtez le processus Chromium
        #arreter_chromium
        #fermer_onglets_chromium

        #Lancement de la vidéo avec VLC
  	mpv --fs /home/pi/Videos/video.mp4
	#sleep 10
        #Attendez que VLC se termine avant de réinitialiser le compteur
        #Relancer Chromium après que VLC ait terminé
        lancer_chromium

        #Réinitialisez le compteur
        compteur=0
    fi
done

