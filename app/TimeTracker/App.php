<?php
class App
{
     private static $pdo;


    public static function getPdo()
    {
     if (is_null(self::$pdo)) {
         self::$pdo = new  PDO("mysql:host=localhost;dbname=timetracker;charset=UTF8", 'root', '');
         self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     };
        return self::$pdo;
    }
}
