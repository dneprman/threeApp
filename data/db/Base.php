<?php
/**
 * Created by PhpStorm.
 * User: Dmitry
 * Date: 12.07.15
 * Time: 17:46
 */
require_once 'Connection.php';

abstract class Base {

    protected $id = null;
    protected  $database = null;
    protected  $table = null;

    public function __construct(array $options=null, PDO $database = null) {
        if (count($options))
            $this->setOptions($options);

        $this->config['adapter'] = "pgsql";
        $this->config['hostname'] = "192.168.248.130";
        $this->config['dbname'] = "agro_new";
        $this->config['user'] = "postgres";
        $this->config['password'] = "postgres";

        $connection = new Connection();

        $this->database = $connection->getConnection($this->config);

        if(method_exists($this, $_GET['action'])){
            call_user_func(array($this,$_GET['action']));
        }
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods))
                $this->$method($value);
        }
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function getTable() {
        return $this->table;
    }

    public function getDb() {
        return $this->database;
    }
}

?>