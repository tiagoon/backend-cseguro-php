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
      $sql = "SELECT * FROM $this->table ORDER BY company_name ASC";
      
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
      $this->document    = trim(strip_tags($this->document));
      $this->address     = trim(strip_tags($this->address));
      
      $sql = "INSERT INTO $this->table (company_name, document, address) VALUES (?, ?, ?)";
   
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(1, $this->companyName);
      $stmt->bindParam(2, $this->document);
      $stmt->bindParam(3, $this->address);
      
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
                        company_name = :company_name, 
                        document     = :document, 
                        address      = :address, 
                        created_at   = :created_at
                     WHERE 
                        id = :id";
   
      $stmt = Model::getConn()->prepare($sql);
   
      $this->companyName = htmlspecialchars(strip_tags($this->companyName));
      $this->document    = htmlspecialchars(strip_tags($this->document));
      $this->address     = htmlspecialchars(strip_tags($this->address));
      $this->createdAt   = htmlspecialchars(strip_tags($this->createdAt));
      $this->id          = htmlspecialchars(strip_tags($this->id));
   
      // bind data
      $stmt->bindParam(":company_name", $this->companyName);
      $stmt->bindParam(":document", $this->document);
      $stmt->bindParam(":address", $this->address);
      $stmt->bindParam(":created_at", $this->createdAt);
      $stmt->bindParam(":id", $this->id);
   
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

      $this->id = intval($this->id);
   
      $stmt->bindParam(1, $this->id);
   
      if($stmt->execute()){
         return true;
      }

      return false;
   }

}
?>
