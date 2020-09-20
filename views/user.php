<?php
require_once "../models/Game.php";
require_once "../models/User.php";

$isProfile = ($_SESSION["user"]->id ?? "") == $user->id;
$this->title = $isProfile ? "Profil" : $user->username;
?>
<h1><?= $user->username . ($user->isAdministrator ? " (Administrateur)" : "") ?></h1>
<h2>Jeux possédés</h2>
<ul>
    <?php foreach (Utils::sortedArray($user->getGames(), "name") as $game) { ?>
        <li><a href="/games/<?= $game->id ?>"><?= $game->name ?></a></li>
    <?php } ?>
</ul>
<p>
    <?php
    if ($_SESSION["user"]->isAdministrator ?? false && !$isProfile) {
        echo "<a href='/deleteUser/$user->id' onclick='return confirm(\"ATTENTION !!!! Cette action est irréversible.\")'>Supprimer cet utilisateur</a>";
    } else if ($isProfile) {
        echo "<a href='/deleteAccount' onclick='return confirm(\"ATTENTION !!!! Cette action est irréversible.\")'>Supprimer mon compte</a>";
    }
    ?>
</p>
<p>
    <?php
    if ($_SESSION["user"]->isAdministrator ?? false && !$isProfile) {
        echo "<a href='/toggleAdministrator/$user->id'>" . ($user->isAdministrator ? "Destituer du" : "Donner le") . " rôle d'administrateur</a>";
    }
    ?>
</p>
<p>
    <a href="/home">Retour à l'accueil</a>
</p>

