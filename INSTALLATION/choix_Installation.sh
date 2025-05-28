#!/bin/bash

# Vérifie si dialog est installé
if ! command -v dialog &> /dev/null; then
    echo "Le paquet 'dialog' est requis. Installez-le avec : sudo apt install dialog"
    exit 1
fi

# Titre de bienvenue
dialog --title "Installation assistée" --msgbox "Bienvenue dans l'assistant d'installation du système.\n\nCe script vous permet d'installer le client, le serveur, ou les deux sur le même appareil." 10 60

# Choix de l'installation
dialog --title "Choix de l'installation" --menu "Que souhaitez-vous installer ?" 15 60 4 \
1 "Installer uniquement le CLIENT" \
2 "Installer uniquement le SERVEUR" \
3 "Installer le CLIENT et le SERVEUR (même hôte)" \
4 "Quitter" 2> /tmp/install_choice

CHOICE=$(< /tmp/install_choice)
clear

# Fonction d'exécution sécurisée
run_script() {
    SCRIPT_PATH="$1"
    if [ -f "$SCRIPT_PATH" ]; then
        chmod +x "$SCRIPT_PATH"
        "$SCRIPT_PATH"
    else
        dialog --title "Erreur" --msgbox "Le script $SCRIPT_PATH est introuvable !" 8 50
        exit 1
    fi
}

# Lancer selon le choix
case $CHOICE in
    1)
        run_script "./client.sh"
        ;;
    2)
        run_script "./install_srv_assist.sh"
        ;;
    3)
        run_script "./install_srv_assist.sh"
        run_script "./client.sh"
        ;;
    4|*)
        dialog --title "Annulé" --msgbox "Installation annulée par l'utilisateur." 8 40
        exit 0
        ;;
esac

dialog --title "Installation complète" --msgbox "✅ Tous les composants sélectionnés ont été installés." 8 50
clear
