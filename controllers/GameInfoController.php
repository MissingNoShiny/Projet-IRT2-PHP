<?php

require_once "../views/ViewBuilder.php";

class GameInfoController {

    public static function infoPage(string $id) {
        try {
            $game = Game::getGame($id);
            $data = array("game" => $game);
            (new ViewBuilder("../views/game.php", $data))->generateView();
        } catch (Exception $e) {
            HomeController::e404();
        }
    }

    public static function listGames() {
        (new ViewBuilder("../views/games.php", array()))->generateView();
    }

    public static function addGame(string $id) {
        if ((isset($_SESSION["user"])) && !$_SESSION["user"]->hasGame($id)) $_SESSION["user"]->addGame($id);
        Utils::redirect("/games/$id");
    }

    public static function removeGame(string $id) {
        if ((isset($_SESSION["user"])) && $_SESSION["user"]->hasGame($id)) $_SESSION["user"]->removeGame($id);
        Utils::redirect("/games/$id");
    }
}