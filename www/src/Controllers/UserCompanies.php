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

   public function store()
   {
      $data = $this->getRequestBody();

      $userCompanyModel            = $this->model('UserCompany');
      $userCompanyModel->userId    = $data->user_id;
      $userCompanyModel->companyId = $data->company_id;
      
      $userCompanyModel->create();

      if ($userCompanyModel) {
         http_response_code(201);
         echo json_encode($userCompanyModel);
      } else {
         http_response_code(500);
         echo json_encode(['message' => 'Erro ao cadastrar usuário']);
      }

   }

   //DELETE
   public function delete($id)
   {
      $companyModel = $this->model('UserCompany');
      $company = $companyModel->destroy($id);

      if (!$company) {
         http_response_code(404);
         echo json_encode(['message' => 'Vínculo não localizado'], JSON_UNESCAPED_UNICODE);
      } else {
         echo json_encode(['message' => 'Vínculo excluído com sucesso.'], JSON_UNESCAPED_UNICODE);
      }

   }
}