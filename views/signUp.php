<?php
$this->title = "Inscription";
?>
<h1>Inscription</h1>
<form action="signup" method="post">
    <section>
        <label for="email">Adresse email :</label>
        <input type="text" id="email" name="email" maxlength="320" value="<?= $_POST["email"] ?? "" ?>" required>
    </section>
    <section>
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" maxlength="24" value="<?= $_POST["username"] ?? "" ?>" required>
    </section>
    <section>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" minlength="4" maxlength="72" required>
    </section>
    <section>
        <label for="passwordCheck">Confirmer le mot de passe :</label>
        <input type="password" id="passwordCheck" name="passwordCheck" minlength="4" maxlength="72" required>
    </section>
    <input type="submit" value="S'inscrire">
</form>
<p>
    <?= $error ?? "" ?>
</p>
<a href="home">Retour à l'accueil</a>

