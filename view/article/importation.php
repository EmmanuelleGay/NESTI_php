<div class="container-fluid ">
    <div class="d-flex mt-4">
        <a href="<?= $vars['baseUrl'] ?>article" class="linkHead">Articles > </a>
        <p class="linkHead"> Article</p>
    </div>




    <?php if (!empty($vars['lineImportations'])) {
        echo "<div class='importSuccessMessage successMessage text-center fw-bold my-5 py-3'>Importation réussie</div>";
    } else if (($vars['message'] ?? "") == 'ImportFailed') {
        echo "<div class='importSuccessMessage warningMessage text-center fw-bold my-5 py-3'>L'importation a échoué</div>";
    }
    ?>

    <h1>Importation</h1>
    <div class="container d-flex justify-content-between">

        <form method="post" action="<?= $vars['baseUrl'] ?>article/importation" enctype="multipart/form-data">

            <div class="align-items-center mt-5 mb-3">
                <label for="fileCsv">Télécharger un fichier CSV</label>
                <input type="file" name="fileCsv" class="form-control" id="fileCsv" accept=".csv" required>
            </div>
            <button type="submit" class="btn validButton fs-5 px-5 mt-3 mb-5">Importer</button>

        </form>

        <?php
        if (!empty($vars['lineImportations'])) {
        ?>
            <div class="mx-5 informationImportation">
                <h2>Liste des articles importés</h2>
                <div class="row d-flex">
                    <?php
                    foreach ($vars['lineImportations'] as $line) {
                    ?>
                    <div class = "col-md-4 justify-content-between"><?= $line["article"]?></div>
                    <div class ="col-md-4 justify-content-between"><?= $line["stock"]?></div>
                    <a class="col-md-4 editBtn" href="<?=$vars['baseUrl']?>article/edit/<?=$line["idArticle"]?>">Editer</a>
                    
                    
                    
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }

        ?>

    </div>