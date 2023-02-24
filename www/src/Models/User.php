<?php

namespace App\Models;

use App\Core\Model;
use \PDO;

class User {

   //TABLE NAME
   private $table = "users";

   //COLUMNS
   public $id;
   public $name;
   public $email;
   public $phone;
   public $birthday;
   public $cityName;
   public $createdAt;

   //All
   public function all($queryParams=[])
   {
      if (!empty($queryParams['query']) && in_array($queryParams['param'], ['name', 'email'])) {
         $query = "AND $queryParams[param] LIKE '%$queryParams[query]%'";
      }

      $sql = "SELECT * FROM $this->table WHERE TRUE $query ORDER BY name ASC";
      
      $stmt = Model::getConn()->prepare($sql);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
         $results = $stmt->fetchAll(PDO::FETCH_OBJ);
         
         return $results;
      } else {
         return [];
      }
   }

   //CREATE
   public function create()
   {
      $sql = "INSERT INTO $this->table (name, email, phone, birthday, city_name, created_at)
                           VALUES (?, ?, ?, ?, ?, ?)";
   
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(1, $this->name);
      $stmt->bindParam(2, $this->email);
      $stmt->bindParam(3, preg_replace('/[^0-9]/', '', $this->phone));
      $stmt->bindParam(4, $this->birthday);
      $stmt->bindParam(5, $this->cityName);
      $stmt->bindParam(6, $this->createdAt);
   
      if ($stmt->execute()) {
         $this->id = Model::getConn()->lastInsertId();
         return $this;
      } else {
         print_r($stmt->errorInfo());
         return null;
      }
   }

   //FIND BY ID
   public function find($id)
   {
      $sql = "SELECT * FROM $this->table WHERE id = ? LIMIT 1";
      
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(1, $id);
      
      if ($stmt->execute()) {
         $user = $stmt->fetch(PDO::FETCH_OBJ);
         
         if (!$user) {
            return null;
         }

         return $user;

      } else {
         return null;
      }
   }

   //UPDATE
   public function update($id)
   {
      $sql = "UPDATE $this->table 
                     SET
                        name       = :name, 
                        email      = :email, 
                        phone      = :phone, 
                        birthday  = :birthday,
                        city_name  = :city_name
                     WHERE 
                        id = :id";
   
      $stmt = Model::getConn()->prepare($sql);
   
      $this->name      = trim(strip_tags($this->name));
      $this->email     = trim(strip_tags($this->email));
      $this->phone     = trim(strip_tags($this->phone));
      $this->birthday  = trim(strip_tags($this->birthday));
      $this->cityName  = trim(strip_tags($this->cityName));
      
      // bind data
      $stmt->bindParam(":name", $this->name);
      $stmt->bindParam(":email", $this->email);
      $stmt->bindParam(":phone", $this->phone);
      $stmt->bindParam(":birthday", $this->birthday);
      $stmt->bindParam(":city_name", $this->cityName);
      $stmt->bindParam(":id", $id);
   
      if($stmt->execute()){
         return true;
      }

      return false;
   }

   //DELETE
   function destroy($id)
   {
      $sql = "DELETE FROM $this->table WHERE id = ?";
      
      $stmt = Model::getConn()->prepare($sql);

      $this->id = intval($id);
   
      $stmt->bindParam(1, $this->id);
   
      if($stmt->execute()){
         return true;
      }

      return false;
   }

}
