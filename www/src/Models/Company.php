<?php

namespace App\Models;

use App\Core\Model;
use \PDO;

class Company {

   //TABLE NAME
   private $table = "companies";

   //COLUMNS
   public $id;
   public $companyName;
   public $document;
   public $address;
   public $createdAt;

   //ALL
   public function all()
   {
      $sql = "SELECT * FROM $this->table";
      
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
      // sanitize
      $this->companyName = trim(strip_tags($this->companyName));
      $this->document    = preg_replace('/[^0-9]/', '', $this->document);
      $this->address     = trim(strip_tags($this->address));
      $this->createdAt   = date('Y-m-d H:i:s');
      
      $sql = "INSERT INTO $this->table (company_name, document, address, created_at) 
                  VALUES (?, ?, ?, ?)";
   
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(1, $this->companyName);
      $stmt->bindParam(2, $this->document);
      $stmt->bindParam(3, $this->address);
      $stmt->bindParam(4, $this->createdAt);
      
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
         $company = $stmt->fetch(PDO::FETCH_OBJ);
         
         if (!$company) {
            return null;
         }

         return $company;

      } else {
         return null;
      }
   }

   //UPDATE
   public function update($id)
   {
      $sql = "UPDATE $this->table 
                     SET
                        company_name = ?, 
                        document     = ?, 
                        address      = ?
                     WHERE 
                        id = ?";
   
      $stmt = Model::getConn()->prepare($sql);
   
      $this->companyName = trim(strip_tags($this->companyName));
      $this->document    = preg_replace('/[^0-9]/', '', $this->document);
      $this->address     = trim(strip_tags($this->address));
      $this->id          = intval($id);
   
      // bind data
      $stmt->bindParam(1, $this->companyName);
      $stmt->bindParam(2, $this->document);
      $stmt->bindParam(3, $this->address);
      $stmt->bindParam(4, $this->id);
   
      if($stmt->execute()){
         return true;
      }

      return null;
   }

   //DELETE
   function destroy($id)
   {
      $sql = "DELETE FROM $this->table WHERE id = ?";
      
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(1, $id);
   
      if($stmt->execute()){
         return true;
      }

      return null;
   }

}
?>
