<?php

require_once "../models/Administration.php";
require_once "../models/Utils.php";
require_once "../views/ViewBuilder.php";

class AdministrationController {

    private static function checkAuth() {
        if (!($_SESSION["user"]->isAdministrator ?? false)) HomeController::e403();
    }

    public static function panel() {
        self::checkAuth();
        (new ViewBuilder("../views/adminPanel.php", array()))->generateView();
    }

    public static function addGame(string $method) {
        self::checkAuth();
        if ($method == "GET") {
            (new ViewBuilder("../views/editGame.php", array("action" => "add")))->generateView();
            return;
        }
        try {
            Utils::trimPost();
            $game = Administration::addGame();
            Utils::redirect("/games/$game->id");
        } catch (Exception $e) {
            (new ViewBuilder("../views/editGame.php", array("action" => "add", "error" => $e->getMessage())))->generateView();
        }
    }

    public static function editGame(string $method, string $id) {
        self::checkAuth();
        if ($method == "GET") {
            try {
                $game = Game::getGame($id);
                $data = array("action" => "edit", "id" => $id, "name" => $game->name, "description" => $game->description);
                (new ViewBuilder("../views/editGame.php", $data))->generateView();
                return;
            } catch (Exception $e) {
                HomeController::e404();
            }
        }
        try {
            Utils::trimPost();
            var_dump($id);
            Administration::editGame($id);
            Utils::redirect("/games/$id");
        } catch (Exception $e) {
            $data = array("action" => "edit", "id" => $id, "error" => $e->getMessage());
            (new ViewBuilder("../views/editGame.php", $data))->generateView();
        }
    }

    public static function deleteGame(string $id) {
        self::checkAuth();
        Administration::deleteGame($id);
        Utils::redirect("/games");
    }

    public static function deleteUser(string $id) {
        self::checkAuth();
        Administration::deleteUser($id);
        Utils::redirect("/users");
    }

    public static function listUsers() {
        self::checkAuth();
        (new ViewBuilder("../views/users.php", array()))->generateView();
    }

    public static function toggleAdministrator(string $id) {
        Administration::toggleAdministrator($id);
        Utils::redirect("/users/$id");
    }
}