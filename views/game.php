<?php
require_once "../models/Game.php";
require_once "../models/User.php";

$this->title = $game->name;
?>
<h1><?= $game->name ?></h1>
<h2>Description</h2>
<p>
    <?= $game->description ?>
</p>
<?php if (isset($_SESSION["user"])) { ?>
    <h2>Utilisateurs possédant ce jeu</h2>
    <ul>
        <?php foreach (Utils::sortedArray($game->getOwners(), "username") as $owner) { ?>
            <li><a href="/users/<?= $owner->id ?>"><?= $owner->username ?></a></li>
        <?php } ?>
    </ul>
<?php } ?>
<p>
    <?php
    if (isset($_SESSION["user"])) {
        if ($_SESSION["user"]->hasGame($game->id)) {
            echo "<a href='/games/$game->id/remove'>Retirer de ma collection</a>";
        } else {
            echo "<a href='/games/$game->id/add'>Ajouter à ma collection</a>";
        }
    }
    ?>
</p>
<p>
    <?= ($_SESSION["user"]->isAdministrator ?? false) ? "<a href='/editGame/$game->id'>Modifier</a>" : "" ?>
</p>
<p>
    <?= ($_SESSION["user"]->isAdministrator ?? false) ? "<a href='/editGame/$game->id' onclick='return confirm(\"ATTENTION !!!! Cette action est irréversible.\")'>Modifier</a>" : "" ?>
</p>
<p>
    <a href="/games">Retour à la liste des jeux</a>
</p>
