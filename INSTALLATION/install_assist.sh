#!/bin/bash

# === Variables par défaut ===
DEFAULT_PROJECT_DIR="/var/www/monsite.fr"
REPO_URL="https://github.com/babacaar/Projet_Raspberry.git"
APACHE_USER="www-data"

# === Vérifie que dialog est installé ===
if ! command -v dialog &> /dev/null; then
    echo "dialog n'est pas installé. Veuillez l’installer avec : sudo apt install dialog"
    exit 1
fi

# === Fenêtre de bienvenue ===
dialog --title "Installation Affichage Dynamique" --msgbox "Bienvenue dans l'assistant d'installation du projet pour Raspberry Pi.\n\nAppuie sur OK pour commencer." 10 60

# === Choix du dossier d'installation ===
dialog --inputbox "Choisis le dossier d'installation du projet :" 8 60 "$DEFAULT_PROJECT_DIR" 2>project_dir.txt
PROJECT_DIR=$(<project_dir.txt)

# === Clone ou mise à jour du dépôt ===
if [ -d "$PROJECT_DIR" ] && [ "$(ls -A $PROJECT_DIR)" ]; then
    dialog --yesno "Le dossier $PROJECT_DIR existe et n'est pas vide.\nVeux-tu supprimer son contenu et re-cloner le dépôt ?" 10 60
    if [ $? -eq 0 ]; then
        sudo rm -rf "$PROJECT_DIR"/*
    else
        dialog --msgbox "Installation annulée car dossier non vide." 6 50
        rm -f project_dir.txt
        exit 1
    fi
fi

dialog --infobox "Clonage du dépôt Git dans $PROJECT_DIR ..." 5 60
sudo apt install -y git
git clone "$REPO_URL" "$PROJECT_DIR"

if [ $? -ne 0 ]; then
    dialog --msgbox "Erreur lors du clonage du dépôt Git." 6 50
    rm -f project_dir.txt
    exit 1
fi

# === Nettoyage fichier temporaire ===
rm -f project_dir.txt

# === Variables pour la suite ===
DB_DUMP="$PROJECT_DIR/db.sql"
ENV_FILE="$PROJECT_DIR/.env"

# === Saisie des infos de BDD ===
dialog --inputbox "Nom de la base de données (ex: affichage) :" 8 60 2>db_name.txt
DB_NAME=$(<db_name.txt)

dialog --inputbox "Utilisateur MySQL :" 8 60 2>db_user.txt
DB_USER=$(<db_user.txt)

dialog --insecure --passwordbox "Mot de passe MySQL :" 8 60 2>db_pass.txt
DB_PASS=$(<db_pass.txt)

dialog --inputbox "Hôte MySQL [localhost] :" 8 60 "localhost" 2>db_host.txt
DB_HOST=$(<db_host.txt)

dialog --inputbox "Port MySQL [3306] :" 8 60 "3306" 2>db_port.txt
DB_PORT=$(<db_port.txt)

# === Résumé et confirmation ===
dialog --yesno "Confirmer ces informations :\n\nDB_NAME: $DB_NAME\nDB_USER: $DB_USER\nDB_HOST: $DB_HOST\nDB_PORT: $DB_PORT" 12 60
if [ $? -ne 0 ]; then
    dialog --msgbox "Installation annulée." 6 40
    exit 1
fi

# === Mise à jour et installation des paquets ===
dialog --infobox "Mise à jour du système..." 5 40
sudo apt update -y && sudo apt upgrade -y

dialog --infobox "Installation des paquets requis (Apache, PHP, extensions, mpv, etc.)..." 5 60
sudo apt install -y apache2 php php-pdo php-ssh2 php-mbstring php-mysql unzip mpv xdotool unclutter wmctrl

# === Création du fichier .env ===
cat <<EOF > "$ENV_FILE"
DBHOST=$DB_HOST
DBPORT=$DB_PORT
DBNAME=$DB_NAME
DBUSER=$DB_USER
DBPASS=$DB_PASS
EOF

# === Import de la base de données ===
mysql -u "$DB_USER" -p"$DB_PASS" -h "$DB_HOST" -P "$DB_PORT" "$DB_NAME" < "$DB_DUMP" 2>mysql_err.txt

if [ $? -ne 0 ]; then
    if [ -s mysql_err.txt ]; then
        dialog --title "Erreur MySQL" --textbox mysql_err.txt 15 60
    else
        dialog --title "Erreur MySQL" --msgbox "Une erreur inconnue est survenue pendant l'import." 8 60
    fi
    rm -f db_name.txt db_user.txt db_pass.txt db_host.txt db_port.txt mysql_err.txt
    exit 1
fi

# === Attribution des droits ===
sudo chown -R $APACHE_USER:$APACHE_USER "$PROJECT_DIR"

# === Fin de l'installation ===
dialog --title "Installation terminée" --msgbox "✅ Le projet a été installé avec succès !\n\nTu peux maintenant accéder à l’interface via http://<adresse-ip-de-ton-pi>" 10 60

# === Nettoyage fichiers temporaires ===
rm -f db_name.txt db_user.txt db_pass.txt db_host.txt db_port.txt mysql_err.txt
clear
