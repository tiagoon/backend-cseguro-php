<?php

namespace App\Models;

use App\Core\Model;
use \PDO;

class UserCompany {

   // Connection
   private $conn;

   // Table
   private $table = "user_companies";

   // Columns
   public $id;
   public $userId;
   public $companyId;
   public $createdAt;


   //FIND COMPANIES OF USER
   public function find($id)
   {
      $sql = "SELECT uc.id, uc.created_at, u.name, c.company_name, c.document, c.address
                  FROM $this->table uc
                  LEFT JOIN users u ON u.id = uc.user_id
                  LEFT JOIN companies c ON c.id = uc.company_id
                  WHERE uc.user_id = ?";

      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(1, $id);
      
      if ($stmt->execute()) {
         $user = $stmt->fetchAll(PDO::FETCH_OBJ);
         
         if (!$user) {
            return null;
         }

         return $user;

      } else {
         return null;
      }
   }


   // CREATE
   public function store()
   {
      $sqlQuery = "INSERT INTO $this->table SET
                        user_id       = :user_id, 
                        company_id    = :company_id, 
                        created_at = :created_at";
   
      $stmt = $this->conn->prepare($sqlQuery);
   
      // sanitize
      $this->userId    = trim(strip_tags($this->userId));
      $this->companyId = trim(strip_tags($this->companyId));
      $this->createdAt = trim(strip_tags($this->createdAt));
      
      // bind data
      $stmt->bindParam(":user_id", $this->userId);
      $stmt->bindParam(":company_id", $this->companyId);
      $stmt->bindParam(":created_at", $this->createdAt);
   
      if($stmt->execute()){
         return true;
      }

      return false;
   }


   // DELETE
   function destroy()
   {
      $sqlQuery = "DELETE FROM $this->table WHERE id = ?";
      
      $stmt = $this->conn->prepare($sqlQuery);

      $this->id = intval($this->id);
   
      $stmt->bindParam(1, $this->id);
   
      if($stmt->execute()){
         return true;
      }

      return false;
   }

}
?>
