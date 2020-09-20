<?php

require_once "../models/Authentication.php";
require_once "../models/Utils.php";

class AuthenticationController {
    public static function signUp(string $method) {
        if (isset($_SESSION["user"])) {
            Utils::redirect("home");
        }
        if ($method == "GET") {
            (new ViewBuilder("../views/signUp.php", array()))->generateView();
            return;
        }
        try {
            Utils::trimPost();
            Authentication::register();
            Utils::redirect("home");
        } catch (Exception $e) {
            (new ViewBuilder("../views/signUp.php", array("error" => $e->getMessage())))->generateView();
        }
    }

    public static function login(string $method) {
        if (isset($_SESSION["user"])) {
            Utils::redirect("home");
        }
        if ($method == "GET") {
            (new ViewBuilder("../views/login.php", array()))->generateView();
            return;
        }
        try {
            Utils::trimPost();
            Authentication::login();
            Utils::redirect("home");
        } catch (Exception $e) {
            (new ViewBuilder("../views/login.php", array("error" => $e->getMessage())))->generateView();
        }
    }

    public static function logout() {
        if (!isset($_SESSION["user"])) {
            Utils::redirect("home");
        }
        Authentication::logout();
        Utils::redirect("home");
    }

    public static function deleteAccount() {
        if (!isset($_SESSION["user"])) {
            Utils::redirect("home");
        }
        Authentication::deleteAccount();
        Utils::redirect("home");
    }
}