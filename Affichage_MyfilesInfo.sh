    #!/bin/bash
    # Compteur d'itérations
    compteur=0;
    duree=20;
    # Fonction pour lancer Chromium
    lancer_chromium() {
        xset s noblank
        xset s off
        xset -dpms
        unclutter -idle 1 -root &
        /usr/bin/chromium-browser --kiosk --noerrdialogs http://172.17.5.202/displayInfo.php https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr /home/pi/barInfo.html &
    }

    fermer_onglets_chromium() {
        xdotool search --onlyvisible --class "chromium-browser" windowfocus key ctrl+shift+w
        wmctrl -k off
    }

    # Lancer Chromium au début
    lancer_chromium

    while true; do
        xdotool keydown ctrl+Next
        xdotool keyup ctrl+Next

        xdotool keydown ctrl+r
        xdotool keyup ctrl+r

        sleep 15

        # Incrémente le compteur d'itérations
        ((compteur++))

        # Vérifie si le nombre d'itérations spécifié est atteint
        #if [ "0" -eq "4" ]; then
            # Arrêtez le processus Chromium
            #fermer_onglets_chromium

            # Lancement de la vidéo avec VLC
           # mpv --fs /home/pi/Videos/Gestes.mp4

            # Relancer Chromium après que VLC ait terminé
            #lancer_chromium

            # Réinitialisez le compteur
            #compteur=0
        #fi
    done
