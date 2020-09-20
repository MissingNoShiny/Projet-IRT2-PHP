<?php
$this->title = "Accueil";
?>
<h1>Accueil</h1>
<p>
    Wouaouw, ça fonctionne ?!!
</p>
<p>
    Bienvenue, <?= $_SESSION["user"]->username ?? "visiteur" ?>
</p>
<ul>
    <li><a href="/games">Liste des jeux</a></li>
    <?php
    if (isset($_SESSION["user"])) {
        if ($_SESSION["user"]->isAdministrator) {
            echo "<li><a href='adminPanel'>Panel d'administration</a></li>";
        }
        echo "<li><a href='/profile'>Mon profil</a></li>";
        echo "<li><a href='/logout'>Se déconnecter</a></li>";
    } else {
        echo "<li><a href='/login'>Se connecter</a></li>";
        echo "<li><a href='/signup'>Créer un compte</a></li>";
    }
    ?>
</ul>
