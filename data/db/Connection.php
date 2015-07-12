<?php
/**
 * Created by PhpStorm.
 * User: Dmitry
 * Date: 12.07.15
 * Time: 17:47
 */
class Connection {
    public function getConnection($config) {
        //$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";
        $dsn =  $config['adapter'] . ":host=" . $config['hostname'] . ";port=5432;dbname=" .$config['dbname'] . ";user=" . $config['user'] . ";password=" . $config['password'];
        try {
            return new PDO($dsn);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}

?>