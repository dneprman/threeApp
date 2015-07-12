<?php
/**
 * Created by PhpStorm.
 * User: Dmitry
 * Date: 19.06.14
 * Time: 20:54
 */

require_once 'db/Base.php';

class Users extends Base {

    private $name = null;
    protected $table = "person";

    /*
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name=$name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email=$email;
    }
    */
    public function insert() {

        $data = json_decode($_POST['data']);

        $db = $this->getDb();
        $stm = $db->prepare('INSERT INTO ' . $this->getTable() . ' (name, email) Values(:name, :email)');
        /*$stm->bindValue(':name', $this->getName());
        $stm->bindValue(':email', $this->getEmail());*/
        $stm->bindValue(':name', $data->name);
        $stm->bindValue(':email', $data->email);
        $stm->execute();

        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $insert = $db->lastInsertId('person_id_seq');

        $msg = $insert ? "Data insert" : "Error insert";

        $newData = $data;
        $newData->id = $insert;

        //$newData->data = date('Y-m-d', strtotime($data->data));

        echo json_encode(array(
            "success" => $insert,
            "message" => $msg,
            "data" => $newData
        ));
    }

    public function update() {

        $data = json_decode($_POST['data']);

        $db = $this->getDb();
        $stm = $db->prepare('UPDATE ' . $this->getTable() . ' SET name=:name, email=:email WHERE id=:id');
        /*$stm->bindValue(':id', $this->getId());
        $stm->bindValue(':name', $this->getName());
        $stm->bindValue(':email', $this->getEmail());*/
        $stm->bindValue(':id', $data->id);
        $stm->bindValue(':name', $data->name);
        $stm->bindValue(':email', $data->email);
        $update = $stm->execute();

        $msg = $update ? "Update data" : "Error update";

        //$data->data = date('Y-m-d', strtotime($data->data));

        echo json_encode(array(
            "success" => $update,
            "message" => $msg,
            "data" => $data
        ));
    }
}

new Users();

?>
