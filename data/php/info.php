<?php
/**
 * Created by PhpStorm.
 * User: Dmitry
 * Date: 19.06.14
 * Time: 20:54
 */

require_once 'db/Base.php';

class Info extends Base {

    private $name = null;
    protected $table = "parcel_owner_doc";

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
        /*
                $db = $this->getDb();
                $stm = $db->prepare('UPDATE ' . $this->getTable() . ' SET name=:name, email=:email WHERE id=:id');
                //$stm->bindValue(':id', $this->getId());
                //$stm->bindValue(':name', $this->getName());
                //$stm->bindValue(':email', $this->getEmail());
                $stm->bindValue(':id', $data->id);
                $stm->bindValue(':name', $data->name);
                $stm->bindValue(':email', $data->email);
                $update = $stm->execute();
        */

        $db = $this->getDb();
        $stm = $db->prepare('UPDATE parcel SET area_size=:area_size, measurement_unit=:measurement_unit WHERE id=:parcel_id');
        $stm->bindValue(':parcel_id', $data->parcel_id);
        $stm->bindValue(':cadnum', $data->cadnum);
        $stm->bindValue(':area_size', $data->area_size);
        $stm->bindValue(':measurement_unit', $data->measurement_unit);
        $update = $stm->execute();

        $db = $this->getDb();
        $stm = $db->prepare('UPDATE person SET last_name=:last_name, first_name=:first_name, middle_name=:middle_name, identification_code=:identification_code WHERE id=:person_id');
        //$stm->bindValue(':doc_code', "VL");
        $stm->bindValue(':person_id', $data->person_id);
        $stm->bindValue(':last_name', $data->last_name);
        $stm->bindValue(':first_name', $data->first_name);
        $stm->bindValue(':middle_name', $data->middle_name);
        $stm->bindValue(':identification_code', $data->identification_code);
        $update = $stm->execute();

        $db = $this->getDb();
        $stm = $db->prepare('UPDATE documents SET doc_number=:doc_number, doc_series=:doc_series, onm_reg_date=:onm_reg_date, onm_end_date=:onm_end_date WHERE id=:doc_id');
        $stm->bindValue(':doc_id', $data->doc_id);
        $stm->bindValue(':doc_number', $data->doc_number);
        $stm->bindValue(':doc_series', $data->doc_series);
        $stm->bindValue(':onm_reg_date', $data->onm_reg_date);
        $stm->bindValue(':onm_end_date', $data->onm_end_date);
        $update = $stm->execute();

        $msg = $update ? "Update data" : "Error update";

        //$data->data = date('Y-m-d', strtotime($data->data));

        echo json_encode(array(
            "success" => $update,
            "message" => $msg,
            //"stm" => $stm
            "data" => $data
        ));

    }
}

new Info();

?>