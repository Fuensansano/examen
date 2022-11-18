<?php

class Address
{
    private $db;

    public function __construct()
    {
        $this->db = Mysqldb::getInstance()->getDatabase();
    }

    public function findAddressByUserId($id)
    {
        $sql = 'select * from addresses where user_id=:id and deleted_at is null';
        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function deleteAddress($id)

    {
        $errors = [];
        $sql = 'UPDATE addresses SET deleted_at = NOW() WHERE deleted_at IS NULL AND user_id = :id';
        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);

        if ( ! $query->execute([':id' => $id])) {
            $errors[] = 'Error al borrar el producto';
        }

        return $errors;
    }

    public function createAddress($dataForm)
    {
        $this->deleteAddress($dataForm['user_id']);

        $sql = 'INSERT INTO addresses (address,city,state,country,zipcode, user_id)
			values (:address, :city, :state, :country, :zipcode, :id)';
        $query = $this->db->prepare($sql);
        $params = [
            ':address' => $dataForm['address'],
            ':city' => $dataForm['city'],
            ':state' => $dataForm['state'],
            ':country' => $dataForm['country'],
            ':zipcode' => $dataForm['zipcode'],
            ':id' => $dataForm['user_id'],
        ];
        //var_dump($params);die();
        return $query->execute($params);
    }

}