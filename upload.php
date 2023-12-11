<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
var_dump($_POST);
if(isset($_POST["submit"])) {
    $targetDir = "/var/www/monsite.fr/Videos/";
    $targetFile = $targetDir . basename($_FILES["video"]["name"]);
    $uploadOk = 1;
    $videoFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    // Vérifie si le fichier vidéo est une vidéo réelle ou une fausse vidéo
    if(isset($_POST["submit"])) {
	$check = mime_content_type($_FILES["video"]["tmp_name"]);
        if($check !== false) {
            echo "Le fichier est une vidéo - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Le fichier n'est pas une vidéo.";
            $uploadOk = 0;
        }
    }

    // Vérifie si le fichier vidéo existe déjà
    if (file_exists($targetFile)) {
        echo "Désolé, le fichier existe déjà.";
        $uploadOk = 0;
    }

    // Vérifie la taille du fichier (ici, 100 Mo)
    if ($_FILES["video"]["size"] > 100000000) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // Autorise certains formats de fichiers
    $allowedExtensions = array("mp4", "avi", "mov", "mkv");
    if (!in_array($videoFileType, $allowedExtensions)) {
    echo "Désolé, seuls les fichiers MP4, AVI, MOV et MKV sont autorisés.";
    $uploadOk = 0;
    }

    // Vérifie si $uploadOk est défini à 0 par une erreur
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    // Si tout est ok, essaye de télécharger le fichier
    } else {
        if (move_uploaded_file($_FILES["video"]["tmp_name"], $targetFile)) {
            echo "Le fichier ". htmlspecialchars( basename( $_FILES["video"]["name"])). " a été téléchargé.";
        } else {
            echo "Une erreur est survenue lors du téléchargement de votre fichier.";
        }
    }
}
?>
