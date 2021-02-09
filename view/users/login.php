<div class="container-fluid loginBackground d-flex h-100">


    <img src="<?= $vars['baseUrl'] ?>public/images/Nesti-logo.png" alt="logo Nesti" class="img-fluid logo">


    <div class="container w-50">
        <?php if (@$vars['message'] == 'disconnect') {
            echo "<div class='disconnectMessage text-center fw-bold my-5 py-3'> Déconnexion réussie</div>";
        } else if (@$vars['message'] == 'errorLogin') {
            echo "<div class='errorLoginMessage text-center fw-bold my-5 py-3'>Erreur d'identifiant ou de mot de passe</div>";
        }
        ?>
        <div class="loginContainer shadow p-3 mb-5 bg-white rounded">
            <p class="text-center fs-1 fw-bold mt-5">Connexion</p>
            <form class="d-flex flex-column align-items-center" method="post" action="<?= $vars['baseUrl'] ?>users/login">
                <div class="mb-3 mx-5 w-50">
                    <label for="login" class="form-label mx-5 mt-5">Identifiant</label>
                    <div class="d-flex align-items-center">
                        <i class="far fa-user-circle fa-2x mb-3"></i>
                        <input type="text" name="Users[login]" class="form-control mx-3 mb-3" id="login" aria-describedby="login field">
                    </div>

                </div>
                <div class="mb-3 mx-5 w-50">
                    <label for="password" class="form-label mx-5">Mot de passe</label>

                    <div class="d-flex align-items-center">
                        <i class="fas fa-lock fa-2x mb-3"></i>
                        <input type="password" name="Users[password]" class="form-control mx-3 mb-3" id="password">
                    </div>
                </div>
                <button type="submit" class="btn colorBtn fs-5 px-5 mt-3 mb-5">Valider</button>
            </form>
        </div>
    </div>

</div>