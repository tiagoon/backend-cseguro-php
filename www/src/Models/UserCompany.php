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
   public function create()
   {
      $sql = "INSERT INTO $this->table (user_id, company_id, created_at)
                     VALUES (?, ?, ?)";
   
      $stmt = Model::getConn()->prepare($sql);
   
      // sanitize
      $this->userId    = intval($this->userId);
      $this->companyId = intval($this->companyId);
      $this->createdAt = date('Y-m-d H:i:s');
      
      // bind data
      $stmt->bindParam(1, $this->userId);
      $stmt->bindParam(2, $this->companyId);
      $stmt->bindParam(3, $this->createdAt);
   
      if($stmt->execute()){
         $this->id = Model::getConn()->lastInsertId();
         return $this;
      }

      return null;
   }


   // DELETE
   function destroy($id)
   {
      $sql = "DELETE FROM $this->table WHERE id = ?";
      
      $stmt = Model::getConn()->prepare($sql);
      
      $this->id = intval($id);
   
      $stmt->bindParam(1, $this->id);
   
      if($stmt->execute()){
         return true;
      }

      return null;
   }

}
?>
