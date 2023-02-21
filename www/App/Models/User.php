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
   public function all()
   {
      $sql = "SELECT * FROM $this->table ORDER BY name ASC";
      
      $stmt = Model::getConn()->prepare($sql);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
         $results = $stmt->fetch(PDO::FETCH_OBJ);
         
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
      $stmt->bindParam(3, $this->phone);
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
      $sql = "SELECT * FROM $this->table WHERE id = ?";
      
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(1, $id);
      
      if ($stmt->execute()) {
         $user = $stmt->fetch(PDO::FETCH_OBJ);
         
         if (!$user) {
            return null;
         }

         $this->id    = $user->id;
         $this->name  = $user->name;
         $this->email = $user->email;
         $this->phone = $user->phone;
         $this->birthday = $user->birthday;
         $this->createdAt = $user->created_at;

         return $this;

      } else {
         return null;
      }
   }

   //UPDATE
   public function update($id)
   {
      $sqlQuery = "UPDATE $this->table 
                     SET
                        name       = :name, 
                        email      = :email, 
                        phone      = :phone, 
                        birth_day  = :birthday,
                        city_name  = :city_name
                     WHERE 
                        id = :id";
   
      $stmt = $this->conn->prepare($sqlQuery);
   
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
      $stmt->bindParam(":created_at", $this->createdAt);
      $stmt->bindParam(":id", $id);
   
      if($stmt->execute()){
         return true;
      }

      return false;
   }

   //DELETE
   function destroy($id)
   {
      $sqlQuery = "DELETE FROM $this->table WHERE id = ?";
      
      $stmt = $this->conn->prepare($sqlQuery);

      $this->id = htmlspecialchars(strip_tags($this->id));
   
      $stmt->bindParam(1, $this->id);
   
      if($stmt->execute()){
         return true;
      }

      return false;
   }

}
