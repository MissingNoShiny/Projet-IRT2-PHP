<?php
$this->title = "Connexion";
?>
<h1>Connexion</h1>
<form action="login" method="post">
    <section>
        <label for="email">Adresse email :</label>
        <input type="text" id="email" name="email" maxlength="320" value="<?= $_POST["email"] ?? "" ?>" required>
    </section>
    <section>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" minlength="4" maxlength="72" required>
    </section>
    <input type="submit" value="Se connecter">
</form>
<p>
    <?= $error ?? "" ?>
</p>
<p>
    Pas de compte ? <a href="/signUp">S'inscrire</a>
</p>
<p>
    <a href="/home">Retour à l'accueil</a>
</p>
