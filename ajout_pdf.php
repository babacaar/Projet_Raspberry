<!------------HEADER------------>
<?php
$pageTitle = "Ajouter Pdf"; // Titre de la page
$dropDownMenu = true;
include "modules/header.php";
?>

<!------------BODY------------>

<body>
    <div class="pdf page">
        <section class="page-content">
            <h1>Ajouter un Pdf</h1>
            <hr>

            <?php phpinfo() ?>

            <form method="post" action="upload_pdf.php">

                <input type="file" accept=".pdf, .PDF"/>

                <button tabindex="0" type="submit" class="submit-btn">Enregistrer</button>

            </form>
        </section>
    </div>
</body>

<!------------FOOTER------------>
<?php include "modules/footer.php"; ?>