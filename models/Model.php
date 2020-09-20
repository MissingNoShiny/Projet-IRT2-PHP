<?php

abstract class Model {
    private static $db;

    protected static function executeQuery(string $query, array $parameters): PDOStatement {
        $result = self::getDb()->prepare($query);
        $result->execute($parameters);
        return $result;
    }

    protected static function getLastInsertedId(): string {
        return self::getDb()->lastInsertId();
    }

    private static function getDb(): PDO {
        if (is_null(self::$db))
            self::$db = new PDO("mysql:host=localhost;dbname=bgdb", "root", "");
        return self::$db;
    }
}
