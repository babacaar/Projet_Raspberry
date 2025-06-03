<!DOCTYPE html>
<html lang="fr">

<head>
    <title>
        <?php echo $pageTitle; ?>
    </title>
    <link rel="stylesheet" type="text/css" href="../../style.css" />
    <script src="https://kit.fontawesome.com/10bb5e6754.js" crossorigin="anonymous"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<?php require_once "/var/www/monsite.fr/controllers/controller_config_files.php"; ?>
<header>
<a  href='<?php echo $siteUrl; ?>/menu.php'>
    <img id="logo-img" class="logo-img" src="../images/logo_transparent.png">
</a>

    <?php
    $siteUrl = "http://$dbhost";

    if ($dropDownMenu)
        include "header_menu.php";

    ?>
</header>

<div class="background-image"></div>

<script type="text/javascript" src="../js/customStyle.js">
    // Appliquer les couleurs au chargement de la page
    document.addEventListener("DOMContentLoaded", function () {
        applyStoredStyles();
    });
</script>
