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

      $sql = "SELECT * FROM $this->table WHERE TRUE $query";
      
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
   
      try {

         $stmt = Model::getConn()->prepare($sql);
         $stmt->bindParam(1, $this->name);
         $stmt->bindParam(2, $this->email);
         $stmt->bindParam(3, preg_replace('/[^0-9]/', '', $this->phone));
         $stmt->bindParam(4, $this->birthday);
         $stmt->bindParam(5, $this->cityName);
         $stmt->bindParam(6, $this->createdAt);
         
         $stmt->execute();
         $this->id = Model::getConn()->lastInsertId();
         return $this;   

      } catch (\PDOException $e) {
         return ['error' => $e->getMessage(), 'code' => $e->getCode()];
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
                        name      = ?, 
                        email     = ?, 
                        phone     = ?, 
                        birthday  = ?,
                        city_name = ?
                     WHERE 
                        id = ?";
   
      //SANITIZE
      $this->name      = trim(strip_tags($this->name));
      $this->email     = trim(strip_tags($this->email));
      $this->phone     = preg_replace('/[^0-9]/', '', $this->phone);
      $this->birthday  = trim(strip_tags($this->birthday));
      $this->cityName  = trim(strip_tags($this->cityName));
      
      try {
         $stmt = Model::getConn()->prepare($sql);

         $stmt->bindParam(1, $this->name);
         $stmt->bindParam(2, $this->email);
         $stmt->bindParam(3, $this->phone);
         $stmt->bindParam(4, $this->birthday);
         $stmt->bindParam(5, $this->cityName);
         $stmt->bindParam(6, $id);
         $stmt->execute();
         
         return true;

      } catch (\PDOException $e) {
         return ['error' => $e->getMessage(), 'code' => $e->getCode()];
      }

   }

   //DELETE
   function destroy($id)
   {
      $sql = "DELETE FROM $this->table WHERE id = ?";
      
      $this->id = intval($id);
      
      try {
         $stmt = Model::getConn()->prepare($sql);
         $stmt->execute([$this->id]);

         if ($stmt->rowCount() > 0)
            return true;
         else
            return null;
         
      } catch (\PDOException $e) {
         return [
            'message' => 'Não foi possível excluir o usuário',
            'error' => $e->getMessage(), 
            'code' => $e->getCode()];
      }
   }

}
