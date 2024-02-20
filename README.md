# Ecran-dynamique
1. Contexte et objectifs 

1.1 Contexte 
Le lycée LPJW souhaite moderniser son système de communication interne et d'affichage d'informations. L'objectif est de diffuser des informations de manière dynamique et centralisée sur des écrans répartis dans l'enceinte du lycée. 

Centraliser et diffuser les informations importantes de manière claire et efficace. 

Améliorer la communication interne entre les différents acteurs du lycée. 

Faciliter la gestion des absences. 

Moderniser l'image du lycée et son attractivité. 

 

1.2 Objectifs 
Le présent projet vise à développer une application web pour le lycée, accessible depuis un Raspberry Pi, permettant de gérer divers aspects de la vie scolaire : 

Gestion des absences des professeurs et du personnel. 

Configuration des groupes d'écrans et des contenus à afficher. 

Diffusion d'informations ponctuelles et d'alertes. 

Personnalisation du style de l'interface pour chaque utilisateur. 

Gestion des menus et conversion en images pour affichage 

 

2. Fonctionnalités principales 
L'application web propose les fonctionnalités suivantes : 

Affichage Actuel : Configuration des URL des contenus à afficher sur les écrans connectés. 

Gestion des Absences : Saisie et consultation des absences des enseignants et du personnel. 

Gestion des Affichages : Création et suppression de groupes d'écrans, envoi de liens et de commandes, affichage d'alertes. 

Configuration des Hôtes/Groupes : Ajout, suppression et modification des Raspberry Pi et des groupes d'écrans. 

Informations Ponctuelles : Ajout d'informations temporaires à afficher sur les écrans. 

Personnalisation de l'interface : Les utilisateurs pourront personnaliser leur profil et l'affichage des informations en fonction de leurs besoins. 

Configuration des Menus : Conversion des pages de menus en images pour une meilleure lisibilité sur les écrans. 

 

 

3. Architecture technique et choix technologiques 
3.1 Architecture du site 
Le projet est basé sur une architecture LAMP :  

Linux : Système d'exploitation stable et sécurisé, largement utilisé pour les serveurs web. 

Apache : Serveur web performant et largement utilisé. 

MySQL : Base de données relationnelle robuste et fiable pour stocker les données du site. 

PHP : Langage de programmation backend pour le développement d'applications web dynamiques. 

 

3.2 Choix technologiques 
Langages de programmation : 

PHP : Pour le développement backend de l'application web dynamique. Il offre une grande flexibilité et s'intègre facilement avec la base de données MySQL. 

HTML/CSS : Langages fondamentaux pour la structuration et la mise en forme des pages web interactives et attrayantes. 

JavaScript : Permet d'ajouter des fonctionnalités interactives et dynamiques au site web, comme des animations, des formulaires de validation et des interactions utilisateur. 

Outils et protocoles : 

FTP/SSH : Protocoles sécurisés pour le transfert de fichiers et la gestion du serveur. 

Mode kiosque : Permet de transformer le Raspberry Pi en un terminal d'affichage dédié, idéal pour diffuser des informations sur les écrans du lycée. 

 

 

 
