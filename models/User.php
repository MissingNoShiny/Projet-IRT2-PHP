<?php

require_once "Model.php";
require_once "Game.php";

class User extends Model {
    private $id;
    private $email;
    private $username;
    private $isAdministrator;

    private function __construct(string $id, string $email, string $username, bool $isAdministrator) {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->isAdministrator = $isAdministrator;
    }

    public function __get($name) {
        if (property_exists($this, $name)) return $this->$name;
    }

    public static function createUser(string $email, string $username, string $password): User {
        $lowerEmail = mb_strtolower($email, "UTF-8");
        $query = "SELECT * FROM users WHERE email = :email";
        $parameters = array(":email" => $lowerEmail);
        $result = self::executeQuery($query, $parameters);
        if ($result->rowCount()) throw new Exception("Un compte associé à cet email existe déjà.");

        $query = "SELECT * FROM users WHERE username = :username";
        $parameters = array(":username" => $username);
        $result = self::executeQuery($query, $parameters);
        if ($result->rowCount()) throw new Exception("Ce nom d'utilisateur est déjà pris.");

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users VALUES (0, :email, :username, :hash, '0')";
        $parameters = array(":email" => $lowerEmail, ":username" => $username, ":hash" => $hash);
        self::executeQuery($query, $parameters);
        return new User(self::getLastInsertedId(), $lowerEmail, $username, false);
    }

    public static function getUserById(string $id): User {
        $query = "SELECT * FROM users WHERE id = :id";
        $parameters = array(":id" => $id);
        $result = self::executeQuery($query, $parameters);
        if (!$result->rowCount()) throw new Exception("Cet utilisateur n'exite pas.");
        $user = $result->fetch();
        return new User($id, $user["email"], $user["username"], boolval($user["administrator"]));
    }

    public static function getUserByEmail(string $email): User {
        $query = "SELECT * FROM users WHERE email = :email";
        $parameters = array(":email" => mb_strtolower($email, "UTF-8"));
        $result = self::executeQuery($query, $parameters);
        if (!$result->rowCount()) throw new Exception("Aucun utilisateur avec cet email n'a été trouvé.");
        $user = $result->fetch();
        return new User($user["id"], $email, $user["username"], boolval($user["administrator"]));
    }

    public function validatePassword(string $password): bool {
        $query = "SELECT password FROM users WHERE username = :username";
        $parameters = array(":username" => $this->username);
        $result = self::executeQuery($query, $parameters);
        $saved_hash = $result->fetch()["password"];
        return password_verify($password, $saved_hash);
    }

    public function updatePassword(string $newPassword) {
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $query = "UPDATE users SET password = :hash WHERE username = :username";
        $parameters = array(":hash" => $hash, ":username" => $this->username);
        self::executeQuery($query, $parameters);
    }

    public function getGames(): array {
        $query = "SELECT game FROM owners WHERE userId = :userId";
        $parameters = array(":userId" => $this->id);
        $result = self::executeQuery($query, $parameters);
        return array_map(function ($row) {
            return Game::getGame($row["game"]);
        }, $result->fetchAll());
    }

    public function addGame(string $id) {
        $query = "INSERT INTO owners VALUES (:userId, :game)";
        $parameters = array(":userId" => $this->id, ":game" => $id);
        self::executeQuery($query, $parameters);
    }

    public function removeGame(string $id) {
        $query = "DELETE FROM owners WHERE userId = :userId AND game = :game";
        $parameters = array(":userId" => $this->id, ":game" => $id);
        self::executeQuery($query, $parameters);
    }

    public function hasGame(string $id): bool {
        $query = "SELECT * FROM owners WHERE userId = :userId AND game = :game";
        $parameters = array(":userId" => $this->id, ":game" => $id);
        $result = self::executeQuery($query, $parameters);
        return $result->rowCount();
    }

    public static function listUsers(): array {
        $result = self::executeQuery("SELECT * FROM users", array());
        return array_map(function ($row) {
            return new User($row["id"], $row["email"], $row["username"], boolval($row["administrator"]));
        }, $result->fetchAll());
    }

    public function toggleAdministrator() {
        $this->isAdministrator = !$this->isAdministrator;
        $query = "UPDATE users SET administrator = :administrator WHERE id = :id";
        $parameters = array(":administrator" => (int) $this->isAdministrator, ":id" => $this->id);
        self::executeQuery($query, $parameters);
    }
}
