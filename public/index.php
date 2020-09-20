<?php

require_once "../controllers/AdministrationController.php";
require_once "../controllers/AuthenticationController.php";
require_once "../controllers/GameInfoController.php";
require_once "../controllers/HomeController.php";
require_once "../controllers/UserInfoController.php";

session_start();

$url = explode("/", rtrim($_GET["url"], "/"));
switch ($url[0]) {
    case "":
    case "home":
        HomeController::home();
        break;
    case "users":
        sizeof($url) == 1 ? AdministrationController::listUsers() : UserInfoController::infoPage($url[1]);
        break;
    case "games":
        if (sizeof($url) == 1) {
            GameInfoController::listGames();
        } else if (sizeof($url) == 2) {
            GameInfoController::infoPage($url[1]);
        } else switch ($url[2]) {
            case "add":
                GameInfoController::addGame($url[1]);
                break;
            case "remove":
                GameInfoController::removeGame($url[1]);
                break;
            default:
                HomeController::e404();
        }
        break;
    case "signup":
        AuthenticationController::signUp($_GET["method"]);
        break;
    case "login":
        AuthenticationController::login($_GET["method"]);
        break;
    case "logout":
        AuthenticationController::logout();
        break;
    case "profile":
        isset($_SESSION["user"]) ? UserInfoController::infoPage($_SESSION["user"]->id) : HomeController::e404();
        break;
    case "deleteAccount":
        AuthenticationController::deleteAccount();
        break;
    case "adminPanel":
        AdministrationController::panel();
        break;
    case "addGame":
        AdministrationController::addGame($_GET["method"]);
        break;
    case "editGame":
        AdministrationController::editGame($_GET["method"], $url[1]);
        break;
    case "deleteGame":
        AdministrationController::deleteGame($url[1]);
        break;
    case "deleteUser":
        AdministrationController::deleteUser($url[1]);
        break;
    case "toggleAdministrator":
        AdministrationController::toggleAdministrator($url[1]);
        break;
    default:
        HomeController::e404();
}