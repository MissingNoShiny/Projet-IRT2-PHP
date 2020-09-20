<?php

class Utils {
    public static function redirect($url) {
        header("Location: $url");
        exit;
    }

    public static function trimPost() {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = trim($value);
        }
    }

    public static function sortedArray(array $array, string $attribute) {
        $copy = $array;
        usort($copy, function ($a, $b) use ($attribute) {
            return $a->$attribute > $b->$attribute;
        });
        return $copy;
    }
}