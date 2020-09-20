<?php

require_once "Model.php";
require_once "User.php";

class Authentication extends Model {

    public static function register() {
        if (!ctype_alnum($_POST["username"])) throw new Exception("Le nom d'utilisateur doit être alphanumérique");
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) throw new Exception("Adresse email invalide");
        if ($_POST["password"] != $_POST["passwordCheck"]) throw new Exception("Les mots de passe ne correspondent pas");
        $user = User::createUser($_POST["email"], $_POST["username"], $_POST["password"]);
        $_SESSION["user"] = $user;
    }

    public static function login() {
        $user = User::getUserByEmail($_POST["email"]);
        if (!$user->validatePassword($_POST["password"])) throw new Exception("Mot de passe invalide");
        $_SESSION["user"] = $user;
    }

    public static function logout() {
        unset($_SESSION["user"]);
    }

    public static function deleteAccount() {
        $query = "DELETE FROM users WHERE id = :id";
        $parameters = array(":id" => $_SESSION["user"]->id);
        self::executeQuery($query, $parameters);
        self::logout();
    }

}