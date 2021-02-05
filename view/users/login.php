
<form method="post" action="<?= $vars['baseUrl']?>users/login">
    <div class="mb-3">
        <label for="login" class="form-label">Pseudo</label>
        <input type="login" name="Users[login]" class="form-control" id="login" aria-describedby="login field">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" name="Users[password]" class="form-control" id="password">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="keepConnect">
        <label class="form-check-label" for="keepConnect">Rester connecté</label>
    </div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>