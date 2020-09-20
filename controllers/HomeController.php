<?php

require_once "../views/ViewBuilder.php";

class HomeController {

    public static function home() {
        (new ViewBuilder("../views/home.php", array()))->generateView();
    }

    public static function e403() {
        (new ViewBuilder("../views/403.php", array()))->generateView();
        http_response_code(403);
        exit;
    }

    public static function e404() {
        (new ViewBuilder("../views/404.php", array()))->generateView();
        http_response_code(404);
        exit;
    }
}