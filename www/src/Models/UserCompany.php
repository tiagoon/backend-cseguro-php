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
   
      //SANITIZE
      $this->userId    = intval($this->userId);
      $this->companyId = intval($this->companyId);
      $this->createdAt = date('Y-m-d H:i:s');
      
      try {
         $stmt = Model::getConn()->prepare($sql);
      
         $stmt->bindParam(1, $this->userId);
         $stmt->bindParam(2, $this->companyId);
         $stmt->bindParam(3, $this->createdAt);
         $stmt->execute();
         $this->id = Model::getConn()->lastInsertId();
         return $this;
         
      } catch (\PDOException $e) {
         return ['error' => $e->getMessage(), 'code' => $e->getCode()];
      }
   }


   // DELETE
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
            'message' => 'Não foi possível excluir o vínculo',
            'error' => $e->getMessage(), 
            'code' => $e->getCode()];
      }
   }

}
?>
