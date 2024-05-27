    #!/bin/bash
    # Compteur d'itérations
    compteur=0;
    duree=300;
    # Fonction pour lancer Chromium
    lancer_chromium() {
        xset s noblank
        xset s off
        xset -dpms
        unclutter -idle 1 -root &
        /usr/bin/chromium-browser --kiosk --noerrdialogs https://affichage.lpjw.local/display_info.php https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg &
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

    # Lancer Chromium au début
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
    if [ "$compteur" -eq "4" ]; then
        #Arrêtez le processus Chromium
        #arreter_chromium
        fermer_onglets_chromium

        #Lancement de la vidéo avec VLC
        mpv --fs /home/pi/Videos/video.mp4
        sleep 10
        #Attendez que VLC se termine avant de réinitialiser le compteur
        #Relancer Chromium après que VLC ait terminé
        lancer_chromium

        #Réinitialisez le compteur
        compteur=0
    fi
done

