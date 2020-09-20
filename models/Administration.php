<?php

require_once "Game.php";

class Administration extends Model {

    public static function addGame() : Game {
        return Game::createGame($_POST["name"], $_POST["description"]);
    }

    public static function editGame($id) {
        $query = "SELECT * FROM games WHERE name = :name and id <> :id";
        $parameters = array(":name" => $_POST["name"], ":id" => $id);
        if (self::executeQuery($query, $parameters)->rowCount()) throw new Exception("Un jeu de ce nom existe déjà");

        $query = "UPDATE games SET name = :name, description = :description WHERE id = :id";
        $parameters = array(":name" => $_POST["name"], ":description" => $_POST["description"], ":id" => $id);
        self::executeQuery($query, $parameters);
    }

    public static function deleteGame(string $id) {
        $query = "DELETE FROM games WHERE id = :id";
        $parameters = array(":id" => $id);
        self::executeQuery($query, $parameters);
    }

    public static function deleteUser(string $id) {
        $query = "DELETE FROM users WHERE id = :id";
        $parameters = array(":id" => $id);
        self::executeQuery($query, $parameters);
    }

    public static function toggleAdministrator(string $id) {
        $user = User::getUserById($id);
        $user->toggleAdministrator();
    }
}