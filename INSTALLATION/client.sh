#!/bin/bash

# Fonction pour afficher un message d'information
show_info() {
    dialog --title "$1" --msgbox "$2" 10 50
}

# Fonction pour exécuter une commande avec affichage
run_command() {
    eval "$1"
    if [ $? -eq 0 ]; then
        dialog --title "Succès" --msgbox "$2" 8 50
    else
        dialog --title "Erreur" --msgbox "Échec lors de : $2" 8 50
    fi
}

# Titre principal
dialog --title "Installation Assistée" --msgbox "Bienvenue dans le script d'installation client assistée.\n\nAppuyez sur OK pour continuer." 10 50

# Menu principal
dialog --checklist "Choisissez les composants à installer/configurer :" 20 60 10 \
1 "Installer les paquets nécessaires" on \
2 "Configurer le démarrage automatique" on \
3 "Ajouter les tâches cron" on \
4 "Créer et activer les services systemd" on \
5 "Créer les scripts .sh nécessaires" on \
6 "Configurer les certificats" on \
7 "Installer et activer le serveur FTP" off \
8 "Démarrer le service Kiosk" on \
2> /tmp/choices

CHOICES=$(cat /tmp/choices)

clear

# Étapes selon choix utilisateur
for CHOICE in $CHOICES; do
    case $CHOICE in
        1)
            show_info "Installation des paquets" "Mise à jour et installation des paquets nécessaires..."
            run_command "sudo apt update" "Mise à jour des paquets"
            run_command "sudo apt install -y xdotool unclutter libnss3-tools cec-utils wmctrl mpv proftpd" "Installation des outils système"
            ;;
        2)
            show_info "Configuration LightDM" "Ajout de l'utilisateur 'pi' pour autologin"
            run_command "sudo sed -i '/autologin-user=/c\autologin-user=pi' /etc/lightdm/lightdm.conf" "Modification du fichier lightdm.conf"
            ;;
        3)
            show_info "Configuration Cron" "Ajout des tâches planifiées pour l'utilisateur pi"
            crontab -u pi - <<EOF
30 7 * * 1-5 /home/pi/tv_on.sh
30 17 * * 1-5 /home/pi/tv_off.sh
0 19 * * * /home/pi/reboot.sh
0 6 * * * /home/pi/reboot.sh
30 19 * * * /home/pi/closeService.sh
30 6 * * 6-7 /home/pi/closeService.sh
EOF
            ;;
        4)
            show_info "Services Systemd" "Création des services alertFeu, alertPpms, et kiosk"

            # Exemple pour alertFeu.service
            cat <<EOF | sudo tee /lib/systemd/system/alertFeu.service >/dev/null
[Unit]
Description=Alertest Incendie
After=graphical.target
Wants=graphical.target

[Service]
ExecStart=/bin/bash /home/pi/alertFeu.sh
Restart=on-abort
User=pi
Group=pi
Environment=DISPLAY=:0.0
Environment=XAUTHORITY=/home/pi/.Xauthority

[Install]
WantedBy=graphical.target
EOF
            # Répéter pour alertPpms.service et kiosk.service...
            ;;
        5)
            show_info "Création des scripts .sh" "Les scripts seront créés dans /home/pi"
            # Répéter le contenu des scripts avec `cat <<EOF` comme dans votre script initial
            # Par exemple :
            cat <<EOF > /home/pi/reboot.sh
#!/bin/bash
sudo reboot
EOF
            chmod +x /home/pi/*.sh
            ;;
        6)
            show_info "Configuration des certificats" "Création du répertoire et script d'import de certificat"
            mkdir -p /home/pi/ca_certificates
            chmod 777 /home/pi/ca_certificates
            cat <<EOF > /home/pi/cert.sh
#!/bin/bash
certutil -A -d sql:\$HOME/.pki/nssdb -t "CT,C,C" -n "CA" -i /home/pi/ca_certificates/ca_cert.cer
EOF
            chmod +x /home/pi/cert.sh
            ;;
        7)
            show_info "Installation FTP" "Installation et activation de proftpd"
            run_command "sudo apt install -y proftpd" "Installation de proftpd"
            run_command "sudo systemctl enable proftpd" "Activation du service FTP"
            ;;
        8)
            show_info "Service Kiosk" "Activation et démarrage du service"
            sudo systemctl enable kiosk.service
            sudo systemctl start kiosk.service
            ;;
    esac
done

dialog --title "Installation terminée" --msgbox "L'installation assistée est terminée.\nRedémarrez si nécessaire." 10 50
clear
