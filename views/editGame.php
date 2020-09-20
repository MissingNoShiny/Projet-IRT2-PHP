<?php
$actionName = $action == "add" ? "Ajouter" : "Modifier";
$this->title = "$actionName un jeu";
?>
<h1><?= $actionName ?> un jeu</h1>
<form action="/<?= $action ?>Game/<?= $id ?? "" ?>" method="post">
    <section>
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" maxlength="100" value="<?= $_POST["name"] ?? $name ?? "" ?>" required>
    </section>
    <section>
        <label for="description">Description :</label>
        <textarea id="description" name="description" maxlength="8192"><?= $_POST["description"] ?? $description ?? "" ?></textarea>
    </section>
    <input type="submit" value="<?= $actionName ?>">
</form>
<p>
    <?= $error ?? "" ?>
</p>
<a href="/adminPanel">Retour au panel</a>