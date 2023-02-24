<?php 

namespace App\Controllers;

use App\Core\Controller;

class UserCompanies extends Controller {

   //FIND ALL COMPANIES TO USER
   public function find($id)
   {
      $companyModel = $this->model('UserCompany');

      $company = $companyModel->find($id);

      if (!$company) {
         http_response_code(404);
         echo json_encode(['message' => 'Não localizamos empresas para este usuário'], JSON_UNESCAPED_UNICODE);
         exit;
      }

      echo json_encode($company, JSON_UNESCAPED_UNICODE);
   }
}