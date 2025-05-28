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
git clone --branch master "$REPO_URL" "$PROJECT_DIR"

if [ $? -ne 0 ]; then
    dialog --msgbox "Erreur lors du clonage du dépôt Git." 6 50
    rm -f project_dir.txt
    exit 1
fi

# === Nettoyage fichier temporaire ===
rm -f project_dir.txt

# === Mise à jour et installation des paquets ===
dialog --infobox "Mise à jour du système..." 5 40
sudo apt update -y && sudo apt upgrade -y

dialog --infobox "Installation des paquets requis (Apache, PHP, extensions, mpv, etc.)..." 5 60
sudo apt install -y mariadb-server apache2 php php-pdo php-ssh2 php-mbstring php-mysql unzip mpv xdotool unclutter wmctrl


# Modifier le bind-address pour écouter sur toutes les interfaces
CONF_FILE="/etc/mysql/mariadb.conf.d/50-server.cnf"

if grep -q "^bind-address" "$CONF_FILE"; then
    sudo sed -i "s/^bind-address.*/bind-address = 0.0.0.0/" "$CONF_FILE"
else
    echo "bind-address = 0.0.0.0" | sudo tee -a "$CONF_FILE" > /dev/null
fi

# Redémarrer MariaDB pour appliquer la modification
sudo systemctl restart mariadb


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

dialog --inputbox "Hôte MySQL [localhost ou votre ip] :" 8 60 2>db_host.txt
DB_HOST=$(<db_host.txt)

dialog --inputbox "Port MySQL [3306] :" 8 60 "3306" 2>db_port.txt
DB_PORT=$(<db_port.txt)


# === Infos admin ===
dialog --inputbox "Nom d'utilisateur admin du projet :" 8 60 "admin" 2>admin_user.txt
ADMIN_USER=$(<admin_user.txt)

dialog --insecure --passwordbox "Mot de passe admin (IL FAUDRA S'EN RAPPELER POUR L'INTERFACE WEB):" 8 60 2>admin_pass.txt
ADMIN_PASS=$(<admin_pass.txt)

dialog --inputbox "Entrez Email valide :" 8 60 "admin@example.com" 2>admin_email.txt
ADMIN_EMAIL=$(<admin_email.txt)

# === Résumé et confirmation ===
dialog --yesno "Confirmer ces informations :\n\nDB_NAME: $DB_NAME\nDB_USER: $DB_USER\nDB_HOST: $DB_HOST\nDB_PORT: $DB_PORT" 12 60
if [ $? -ne 0 ]; then
    dialog --msgbox "Installation annulée." 6 40
    exit 1
fi



# === Création du fichier .env ===
cat <<EOF > "$ENV_FILE"
DB_HOST=$DB_HOST
DB_PORT=$DB_PORT
DB_NAME=$DB_NAME
DB_USER=$DB_USER
DB_PASS=$DB_PASS
EOF

# Créer base + utilisateur MySQL si besoin
mysql -u root <<EOF
CREATE DATABASE IF NOT EXISTS $DB_NAME;
Use $DB_NAME;
CREATE USER IF NOT EXISTS '$DB_USER'@'%' IDENTIFIED BY '$DB_PASS';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'%';
FLUSH PRIVILEGES;
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


# === Création de l'utilisateur admin + rôle + permissions ===
HASHED_PASS=$(php -r "echo password_hash('$ADMIN_PASS', PASSWORD_DEFAULT);")

mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" <<EOF
INSERT INTO Utilisateurs (nom_utilisateur, mot_de_passe, email) VALUES ('$ADMIN_USER', '$HASHED_PASS', '$ADMIN_EMAIL');
SET @uid = LAST_INSERT_ID();

-- Rôle administrateur
SET @admin_role_id = (SELECT id FROM Roles WHERE nom_role = 'administrateur' LIMIT 1);
INSERT INTO Utilisateurs_Roles (id_utilisateur, id_role) VALUES (@uid, @admin_role_id);
EOF


# === Écriture du fichier .htaccess pour redirection ===
HTACCESS_FILE="$PROJECT_DIR/.htaccess"
cat <<EOF > "$HTACCESS_FILE"
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Redirection vers connexion.php si on accède à la racine
    RewriteCond %{REQUEST_URI} ^/?$
    RewriteRule ^$ connexion.php [L,R=302]

    # BEGIN WordPress
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
    RewriteBase /
    RewriteRule ^index\.php$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]
    # END WordPress
</IfModule>
EOF


# === Attribution des droits ===
sudo chown -R $APACHE_USER:$APACHE_USER "$PROJECT_DIR"

# === Virtual Host ===
VHOST_FILE="/etc/apache2/sites-available/monsite.fr.conf"

sudo bash -c "cat > $VHOST_FILE" <<EOF
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    ServerName monsite.fr
    DocumentRoot $PROJECT_DIR

    <Directory $PROJECT_DIR>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/monsite_error.log
    CustomLog \${APACHE_LOG_DIR}/monsite_access.log combined
</VirtualHost>
EOF

sudo a2dissite 000-default.conf

sudo a2ensite monsite.fr.conf
sudo a2enmod rewrite
sudo systemctl reload apache2

# === Fin de l'installation ===
dialog --title "Installation terminée" --msgbox "✅ Le projet a été installé avec succès !\n\nTu peux maintenant accéder à l’interface via http://<adresse-ip-de-ton-pi>" 10 60

# === Nettoyage fichiers temporaires ===
rm -f db_name.txt db_user.txt db_pass.txt db_host.txt db_port.txt mysql_err.txt
clear
