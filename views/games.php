<?php
require_once "../models/Game.php";

$this->title = "Liste de jeux";
?>
<h1>Liste des jeux</h1>
<ul>
    <?php foreach (Utils::sortedArray(Game::listGames(), "name") as $game) { ?>
    <li><a href="/games/<?= $game->id ?>"><?= $game->name ?></a></li>
    <?php } ?>
</ul>
<p>
    <a href="home">Retour à l'accueil</a>
</p>
