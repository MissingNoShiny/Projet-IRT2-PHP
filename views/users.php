<?php
$this->title = "Liste des utilisateurs"
?>
<h1>Liste des utilisateurs</h1>
<ul>
    <?php foreach (Utils::sortedArray(User::listUsers(), "username") as $user) { ?>
        <li><a href="/users/<?= $user->id ?>"><?= $user->username ?> <?= $user->isAdministrator ? "(admin)" : "" ?></a></li>
    <?php } ?>
</ul>
<p>
    <a href="adminPanel">Retour au panel</a>
</p>