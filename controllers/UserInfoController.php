<?php

require_once "../models/Utils.php";

class UserInfoController {
    public static function infoPage(string $id) {
        if (!isset($_SESSION["user"])) Utils::redirect("/login");
        try {
            $user = User::getUserById($id);
            $data = array("user" => $user);
            (new ViewBuilder("../views/user.php", $data))->generateView();
        } catch (Exception $e) {
            HomeController::e404();
        }
    }
}