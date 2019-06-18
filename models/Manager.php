<?php
namespace Project\Models;

class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=project_4;charset=utf8', 'root', 'root');
        return $db;
    }
}