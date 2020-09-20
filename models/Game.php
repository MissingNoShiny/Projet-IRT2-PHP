<?php

require_once "Model.php";
require_once "User.php";

class Game extends Model {
    private $id;
    private $name;
    private $description;

    private function __construct(string $id, string $name, string $description) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function __get($name) {
        if (property_exists($this, $name)) return $this->$name;
    }

    public static function getGame(string $id): Game {
        $query = "SELECT * FROM games WHERE id = :id";
        $parameters = array(":id" => $id);
        $result = self::executeQuery($query, $parameters);
        if (!$result->rowCount()) throw new Exception("Ce jeu n'existe pas.");
        $game = $result->fetch();
        return new Game($game["id"], $game["name"], $game["description"]);
    }

    public static function createGame($name, $description): Game {
        $query = "SELECT * FROM games WHERE name = :name";
        $parameters = array(":name" => $name);
        if (self::executeQuery($query, $parameters)->rowCount()) throw new Exception("Il y a déjà un jeu avec ce nom");

        $query = "INSERT INTO games VALUES (0, :name, :description)";
        $parameters = array(":name" => $name, ":description" => $description);
        self::executeQuery($query, $parameters);
        return new Game(self::getLastInsertedId(), $name, $description);
    }

    public function getOwners(): array {
        $query = "SELECT userId FROM owners WHERE game = :id";
        $parameters = array(":id" => $this->id);
        $result = self::executeQuery($query, $parameters);
        return array_map(function ($row) {
            return User::getUserById($row["userId"]);
        }, $result->fetchAll());
    }

    public static function listGames(): array {
        $result = self::executeQuery("SELECT * FROM games", array());
        return array_map(function ($row) {
            return new Game($row["id"], $row["name"], $row["description"]);
        }, $result->fetchAll());
    }
}
