<?php

namespace App\Models;

use App\Configurations\Database;
use \PDO;

class User {

   // Connection
   private $conn;

   // Table
   private $table = "users_companies";

   // Columns
   public $id;
   public $userId;
   public $companyId;
   public $createdAt;

   // Db connection
   public function __construct(Database $db){
      $this->conn = $db->getConnection();
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
      $this->userId    = htmlspecialchars(strip_tags($this->userId));
      $this->companyId = htmlspecialchars(strip_tags($this->companyId));
      $this->createdAt = htmlspecialchars(strip_tags($this->createdAt));
      
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

      $this->id = htmlspecialchars(strip_tags($this->id));
   
      $stmt->bindParam(1, $this->id);
   
      if($stmt->execute()){
         return true;
      }

      return false;
   }

}
?>
